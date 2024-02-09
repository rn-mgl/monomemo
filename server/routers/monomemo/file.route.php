<?php session_start() ?>
<?php
    include_once(__DIR__ . "/../../../vendor/autoload.php");
    include_once("../../database/conn.php");

    use Dotenv\Dotenv;
    use Cloudinary\Configuration\Configuration;
    use Cloudinary\Api\Upload\UploadApi;

    $dotenv = Dotenv::createImmutable(__DIR__ . "/../../..");
    $dotenv->safeLoad();
?>

<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION["id"])) {
        header("Location: /client/pages/monomemo/profile.php");
        die();
    }


    Configuration::instance([
        "cloud" => [
            "cloud_name" => $_ENV["CLOUD_NAME"],
            "api_key" => $_ENV["API_KEY"],
            "api_secret" => $_ENV["API_SECRET"],
        ],
        "url" => [
            "secure" => true
        ]
    ]);

    $file = null;
    $userID = $_SESSION["id"];

    if (isset($_FILES["file"])) {
        $file = $_FILES["file"];
    }

    try {
        $url = null;

        if ($file) {
            $upload = (new UploadApi())->upload($file["tmp_name"], ["folder" => "monomemo-uploads"]);
            $url = $upload["secure_url"];
        }

        echo json_encode(array("url" => $url));

    } catch (Exception $e) {
        header("Location: /client/pages/monomemo/profile.php");
        die();
    }
    
}

?>