<?php session_start(); ?>
<?php include_once("../../database/conn.php"); ?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_SESSION["id"])) {
        header("Location: /client/pages/auth/login.php");
        die();
    }

    $userID = $_SESSION["id"];

    try {
        $query = "SELECT * FROM users WHERE user_id = ?;";
        $result = $conn->execute_query($query, [$userID]);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(array());
        }

    } catch (Exception $e) {
        header("Location: /client/pages/auth/login.php");
        die();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["id"])) {
        header("Location: /client/pages/auth/login.php");
        die();
    }

    if ($_POST["type"] == "update_names") {
        $userID = $_SESSION["id"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];

        try {
            $query = "SELECT * FROM users WHERE user_id = ?;";
            $result = $conn->execute_query($query, [$userID]);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $updateQuery = "UPDATE users SET user_name = ?, user_surname = ? 
                                    WHERE user_id = ?";
                $updateResult = $conn->execute_query($updateQuery, [$name, $surname, $userID]);

                echo json_encode(array("updated" => $updateResult));

            } else {
                echo json_encode(array("updated" => false));
            }

        } catch (Exception $e) {
            header("Location: /client/pages/auth/login.php");
            die();
        }
    } else if ($_POST["type"] == "update_image") {
        $userID = $_SESSION["id"];
        $imageURL = $_POST["url"];

        try {
            $query = "SELECT * FROM users WHERE user_id = ?;";
            $result = $conn->execute_query($query, [$userID]);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $updateQuery = "UPDATE users SET user_image = ? WHERE user_id = ?";
                $updateResult = $conn->execute_query($updateQuery, [$imageURL, $userID]);

                echo json_encode(array("update" => $updateResult));
            }
        } catch (Exception $e) {
            header("Location: /client/pages/auth/login.php");
            die();
        }
    }


}

?>