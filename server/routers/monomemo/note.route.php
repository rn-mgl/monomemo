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
            $getQuery = "SELECT * FROM notes WHERE note_by = ?;";
            $getResult = $conn->execute_query($getQuery, [$noteBy]);
            $resultArray = array();

            if ($getResult->num_rows > 0) {
                while ($row = $getResult->fetch_assoc()) {
                    $resultArray[] = $row;
                }
            }
            echo json_encode($resultArray);
            die();
        }
    } catch (Exception $e) {
        header("Location: /client/pages/auth/login.php");
        die();
    }
} else {
    header("Location: /client/pages/auth/login.php");
    die();
}



?>