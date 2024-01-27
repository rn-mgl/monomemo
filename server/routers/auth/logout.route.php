<?php
include_once("../../../client/components/global/header.comp.php");
session_destroy();
header("Location: /client/pages/index.php");
die();
?>