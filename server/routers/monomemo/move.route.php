<?php session_start() ?>
<?php
include_once("../../database/conn.php");
include_once("../../utils/tokens.php");
?>

<?php

$token = verifyAccessToken();

if (!$token) {
    header("Location: /client/pages/auth/login.php");
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] == "move_note") {

        if (!isset($_GET["note_uuid"]) || !isset($_POST["path"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

        $noteUUID = $_GET["note_uuid"];

        try {
            if ($_POST["path"] == "") {
                $moveQuery = "UPDATE notes SET note_from = ? WHERE note_uuid = ?";
                $moveResult = $conn->execute_query($moveQuery, [0, $noteUUID]);

                if ($moveResult) {
                    echo json_encode(array("new_path" => 0));
                } else {
                    echo json_encode(array("new_path" => null));
                }
            } else {
                $path = $_POST["path"];

                $folderQuery = "SELECT * FROM folders WHERE folder_uuid = ?";
                $folderResult = $conn->execute_query($folderQuery, [$path]);

                if ($folderResult->num_rows > 0) {
                    $folderRow = $folderResult->fetch_assoc();

                    $moveQuery = "UPDATE notes SET note_from = ? WHERE note_uuid = ?";
                    $moveResult = $conn->execute_query($moveQuery, [$folderRow["folder_id"], $noteUUID]);

                    if ($moveResult) {
                        echo json_encode(array("new_path" => $folderRow["folder_uuid"]));
                    } else {
                        echo json_encode(array("new_path" => null));
                    }
                } else {
                    header("Location: /client/pages/monomemo/home.php");
                    die();
                }
            }
        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

    } else if ($_POST["type"] == "move_folder") {

        if (!isset($_GET["folder_uuid"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

        $folderUUID = $_GET["folder_uuid"];

        try {
            if ($_POST["path"] == "") {
                $moveQuery = "UPDATE folders SET folder_from = ? WHERE folder_uuid = ?";
                $moveResult = $conn->execute_query($moveQuery, [0, $folderUUID]);

                if ($moveResult) {
                    echo json_encode(array("new_path" => 0));
                } else {
                    echo json_encode(array("new_path" => null));
                }
            } else {
                $path = $_POST["path"];

                $folderQuery = "SELECT * FROM folders WHERE folder_uuid = ?";
                $folderResult = $conn->execute_query($folderQuery, [$path]);

                if ($folderResult->num_rows > 0) {
                    $folderRow = $folderResult->fetch_assoc();

                    $moveQuery = "UPDATE folders SET folder_from = ? WHERE folder_uuid = ?";
                    $moveResult = $conn->execute_query($moveQuery, [$folderRow["folder_id"], $folderUUID]);

                    if ($moveResult) {
                        echo json_encode(array("new_path" => $folderRow["folder_uuid"]));
                    } else {
                        echo json_encode(array("new_path" => null));
                    }
                } else {
                    header("Location: /client/pages/monomemo/home.php");
                    die();
                }
            }
        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET["type"] == "note_path") {

        if (!isset($_GET["note_uuid"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

        $noteUUID = $_GET["note_uuid"];
        $folderBy = $_SESSION["id"];

        try {
            $noteQuery = "SELECT * FROM notes WHERE note_uuid = ?";
            $noteResult = $conn->execute_query($noteQuery, [$noteUUID]);

            if ($noteResult->num_rows > 0) {
                $noteRow = $noteResult->fetch_assoc();
                $pathsResult;

                if ($noteRow["note_from"] == 0) {
                    $pathsQuery = "SELECT * FROM folders WHERE folder_by = ?";
                    $pathsResult = $conn->execute_query($pathsQuery, [$folderBy]);
                } else {
                    $pathsQuery = "SELECT * FROM folders 
                                    WHERE folder_id <> ?
                                    AND folder_by = ?";
                    $pathsResult = $conn->execute_query($pathsQuery, [$noteRow["note_from"], $folderBy]);
                }

                $paths = array();

                if ($pathsResult->num_rows > 0) {
                    while ($row = $pathsResult->fetch_assoc()) {
                        $paths[] = $row;
                    }
                }

                echo json_encode($paths);

            } else {
                header("Location: /client/pages/monomemo/home.php");
                die();
            }

        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

    } else if ($_GET["type"] == "folder_path") {

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
                $folderRow = $folderResult->fetch_assoc();

                $pathsQuery = "SELECT * FROM folders 
                                    WHERE folder_id <> ?
                                    AND folder_id <> ?
                                    AND folder_by = ?";
                $pathsResult = $conn->execute_query($pathsQuery, [$folderRow["folder_id"], $folderRow["folder_from"], $folderBy]);

                $paths = array();

                if ($pathsResult->num_rows > 0) {
                    while ($row = $pathsResult->fetch_assoc()) {
                        $paths[] = $row;
                    }
                }

                echo json_encode($paths);

            } else {
                header("Location: /client/pages/monomemo/home.php");
                die();
            }

        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

    }
}

?>