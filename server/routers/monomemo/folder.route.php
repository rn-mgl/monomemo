<?php session_start() ?>
<?php include_once("../../database/conn.php") ?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userID = $_SESSION["id"];
    try {
        $query = "SELECT * FROM folders WHERE folder_by = ?;";
        $result = $conn->execute_query($query, [$userID]);
        $userFolders = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $userFolders[] = $row;
            }
            echo json_encode($userFolders);
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