<?php session_start() ?>
<?php include_once("../../database/conn.php"); ?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] == "move_note") {

        if (!isset($_GET["note_uuid"]) || !isset($_POST["folderUUID"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

        if ($_POST["folderUUID"] == "") {
            $noteUUID = $_GET["note_uuid"];
            $moveQuery = "UPDATE notes SET note_from = ? WHERE note_uuid = ?";
            $moveResult = $conn->execute_query($moveQuery, [0, $noteUUID]);

            if ($moveResult) {
                echo json_encode(array("new_path" => 0));
            } else {
                echo json_encode(array("new_path" => null));
            }
        } else {
            $folderUUID = $_POST["folderUUID"];
            $noteUUID = $_GET["note_uuid"];

            try {
                $folderQuery = "SELECT * FROM folders WHERE folder_uuid = ?";
                $folderResult = $conn->execute_query($folderQuery, [$folderUUID]);

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

            } catch (Exception $e) {
                header("Location: /client/pages/monomemo/home.php");
                die();
            }
        }

    } else if ($_POST["type"] == "move_folder") {

        if (!isset($_GET["folder_uuid"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

    }
}

?>