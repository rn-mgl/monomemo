<?php session_start() ?>
<?php
    include_once(__DIR__ . "/../../../vendor/autoload.php");

    use Dotenv\Dotenv;
    use Cloudinary\Configuration\Configuration;
    use Cloudinary\Api\Upload\UploadApi;

    $dotenv = Dotenv::createImmutable(__DIR__ . "/../../..");
    $dotenv->safeLoad();
?>

<?php 

Configuration::instance([
    "cloud" => [
        "cloud_name" => $_ENV["CLOUD_NAME"],
        "api_key" => $_ENV["API_KEY"],
        "api_secret" => $_ENV["API_SECRET"],
        "folder" => "monomemo-uploads"
    ],
    "url" => [
        "secure" => true
    ]
    ]);

$cloudinary = new UploadApi();
$cloudinary->upload("C:/Users/Rein/monomemo/client/public/images/logo.png", ["folder" => "monomemo-uploads"]);


?>