<?php session_start() ?>
<?php include_once("../../database/conn.php") ?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        die();
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userID = $_SESSION["id"];
    try {
        $query = "SELECT * FROM notes WHERE note_by = ?;";
        $result = $conn->execute_query($query, [$userID]);
        $userNotes = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $userNotes[] = $row;
            }
            echo json_encode($userNotes);
        }

    } catch (Exception $e) {
        header("Location: /client/pages/monomemo/home.php");
        die();
    }

} else {
    header("Location: /client/pages/auth/login.php");
    die();
}



?>