<?php session_start() ?> 
<?php 
include_once("../../database/conn.php");
include_once("../../utils/tokens.php");
 ?>

<?php 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!isset($_POST["newPassword"]) || !isset($_POST["retypedPassword"]) || !isset($_POST["token"])) {
            header("Location : /client/pages/auth/renew.php");
            die();
        }

        $newPassword = $_POST["newPassword"];
        $retypedPassword = $_POST["retypedPassword"];
        $token = verifyToken($_POST["token"]);

       
        if (!$token) {
            echo json_encode(array("updated" => false));
            die();
        }

        if ($newPassword != $retypedPassword) {
            echo json_encode(array("updated" => false));
            die();
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        try {
            $query = "UPDATE users SET user_password = ? WHERE user_id = ?;";
            $result = $conn->execute_query($query, [$hashedPassword, $token->id]);

            echo json_encode(array("updated" => $result));

        } catch (Exception $e) {
            header("Location : /client/pages/auth/renew.php");
            die();
        }

    }

?>