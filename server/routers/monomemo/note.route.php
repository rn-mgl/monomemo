<?php session_start() ?>
<?php include_once("../../database/conn.php") ?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] == "new_note") {
        $noteUUID = bin2hex(openssl_random_pseudo_bytes(25));
        $title = $_POST["noteTitle"];
        $content = $_POST["noteContent"];
        $noteBy = $_SESSION["id"];
        try {
            $insertQuery = "INSERT INTO notes (note_uuid, note_title, note_content, note_by)
                            VALUES(?, ?, ?, ?);";
            $insertResult = $conn->execute_query($insertQuery, [$noteUUID, $title, $content, $noteBy]);

            if ($insertResult) {
                echo json_encode(array("status" => $insertResult));
                die();
            }
        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");

        }
        die();
    } else if ($_POST["type"] == "update_note") {
        if (!isset($_GET["note_uuid"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

        $noteUUID = $_GET["note_uuid"];
        $title = $_POST["noteTitle"];
        $content = $_POST["noteContent"];

        try {
            $query = "UPDATE notes SET
                    note_title = ?,
                    note_content = ?
                    WHERE note_uuid = ?;";
            $result = $conn->execute_query($query, [$title, $content, $noteUUID]);
            if ($result) {
                echo json_encode(array("status" => $result));
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
    if ($_GET["type"] == "single_note") {

        if (!isset($_GET["note_uuid"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

        $userID = $_SESSION["id"];
        $noteUUID = $_GET["note_uuid"];
        try {
            $query = "SELECT * FROM notes AS n
                    LEFT JOIN folders AS f
                    ON n.note_from = f.folder_id
                    WHERE note_uuid = ?;";
            $result = $conn->execute_query($query, [$noteUUID]);

            if ($result->num_rows > 0) {
                $note = $result->fetch_assoc();
                echo json_encode($note);
            } else {
                header("Location: /client/pages/monomemo/home.php");
                die();
            }
        } catch (Exception $e) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }
    } else {
        header("Location: /client/pages/monomemo/home.php");
        die();
    }
} else {
    header("Location: /client/pages/auth/login.php");
    die();
}



?>