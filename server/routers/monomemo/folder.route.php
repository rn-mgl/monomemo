<?php session_start() ?>
<?php
include_once("../../database/conn.php");
include_once("../../utils/tokens.php");
include_once("../../utils/common.php");

?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] == "new_folder") {
        $folderUUID = bin2hex(openssl_random_pseudo_bytes(25));
        $name = $_POST["folderName"];
        $folderBy = $_SESSION["id"];

        try {
            $insertQuery = "INSERT INTO folders (folder_uuid, folder_name, folder_by)
                        VALUES(?, ?, ?);";
            $insertResult = $conn->execute_query($insertQuery, [$folderUUID, $name, $folderBy]);

            if ($insertResult) {
                echo json_encode(array("status" => $insertResult));
                die();
            }
        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }
    } else if ($_POST["type"] == "new_folder_folder") {
        $folderUUID = bin2hex(openssl_random_pseudo_bytes(25));
        $folderFrom = $_POST["folderUUID"];
        $name = $_POST["folderName"];
        $folderBy = $_SESSION["id"];

        try {
            $folderQuery = "SELECT * FROM folders WHERE folder_uuid = ?";
            $folderResult = $conn->execute_query($folderQuery, [$folderFrom]);

            if ($folderResult->num_rows > 0) {
                $row = $folderResult->fetch_assoc();

                $query = "INSERT INTO folders (folder_uuid, folder_name, folder_from, folder_by)
                        VALUES (?, ?, ?, ?);";

                $queryResult = $conn->execute_query($query, [$folderUUID, $name, $row["folder_id"], $folderBy]);

                if ($queryResult) {
                    echo json_encode(array("status" => $queryResult));
                }
            } else {
                header("Location: /client/pages/monomemo/home.php");
                die();
            }
        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

    } else if ($_POST["type"] == "update_folder") {
        if (!isset($_GET["folder_uuid"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }
        $folderUUID = $_GET["folder_uuid"];
        $folderTitle = $_POST["folderTitle"];

        try {
            $query = "UPDATE folders SET folder_name = ?
                        WHERE folder_uuid = ?;";
            $result = $conn->execute_query($query, [$folderTitle, $folderUUID]);

            if ($result) {
                echo json_encode(array("status" => $result));
            }

        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

    } else if ($_POST["type"] == "delete_folder") {
        if (!isset($_GET["folder_uuid"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

        $folderUUID = $_GET["folder_uuid"];
        $folderBy = $_SESSION["id"];

        try {
            $folderQuery = "SELECT * FROM folders WHERE folder_uuid = ?";
            $folderResult = $conn->execute_query($folderQuery, [$folderUUID]);

            if ($folderResult->num_rows > 0) {

                $row = $folderResult->fetch_assoc();

                $child = getAllChildren($row["folder_id"]);
                $implodedChild = implode(",", $child);

                $deleteNotesQuery = "DELETE FROM notes 
                                        WHERE note_from IN ($implodedChild) 
                                        AND note_from <> ?;";
                $deleteNotesResult = $conn->execute_query($deleteNotesQuery, [0]);

                $deleteFolderQuery = "DELETE FROM folders WHERE folder_id IN ($implodedChild);";
                $deleteFolderResult = $conn->execute_query($deleteFolderQuery, []);

                echo json_encode(array("deleted" => $deleteFolderResult));

            } else {
                header("Location: /client/pages/monomemo/home.php");
                die();
            }

        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET["type"] == "my_folders") {
        $userID = $_SESSION["id"];
        try {

            $deleteFoldersQuery = "DELETE FROM folders 
                                        WHERE folder_from NOT IN (
                                            SELECT folder_id FROM folders 
                                            WHERE folder_by = ?
                                        ) AND folder_from <> 0";
            $deleteFoldersResult = $conn->execute_query($deleteFoldersQuery, [$userID]);

            $query = "SELECT * FROM folders WHERE folder_by = ?;";
            $result = $conn->execute_query($query, [$userID]);
            $userFolders = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $userFolders[] = $row;
                }
            }
            echo json_encode($userFolders);
        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }
    } else if ($_GET["type"] == "single_folder") {

        if (!isset($_GET["folder_uuid"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

        $folderUUID = $_GET["folder_uuid"];

        $folderQuery = "SELECT f.folder_name, f.folder_from, f2.folder_uuid 
                        FROM folders AS f
                        LEFT JOIN folders AS f2
                        ON f.folder_from = f2.folder_id
                        AND f.folder_id <> f2.folder_id
                        WHERE f.folder_uuid = ?";
        $folderResult = $conn->execute_query($folderQuery, [$folderUUID]);

        $filesQuery = "SELECT folder_uuid AS uuid, 
                    folder_name AS title, 
                    null AS content, 
                    null AS file, 
                    folder_from AS from_path,
                    'folder' AS type,
                    date_created FROM folders
                    WHERE folder_from IN (
                        SELECT folder_id FROM folders AS sub_f 
                        WHERE sub_f.folder_uuid = ?
                    )

                    UNION 

                SELECT note_uuid AS uuid, 
                    note_title AS title, 
                    note_content AS content, 
                    note_file AS file, 
                    note_from AS from_path,
                    'note' AS type,
                    date_created FROM notes
                    WHERE note_from IN (
                        SELECT folder_id FROM folders AS sub_f 
                        WHERE sub_f.folder_uuid = ?
                    )";
        $filesResult = $conn->execute_query($filesQuery, [$folderUUID, $folderUUID]);

        $folderFiles = array("files" => array(), "folder_data" => array());

        if ($filesResult->num_rows > 0) {
            while ($row = $filesResult->fetch_assoc()) {
                $folderFiles["files"][] = $row;
            }
        }
        if ($folderResult->num_rows > 0) {
            $row = $folderResult->fetch_assoc();
            $folderFiles["folder_data"] = $row;
        }

        echo json_encode($folderFiles);
    }

} else {
    header("Location: /client/pages/auth/login.php");
    die();
}




?>