<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if($_SERVER["REQUEST_METHOD"]=="GET"){
    if(!isset($_GET['id'])) {
        header("Location: read.php");
        exit;
    }
    
    $id = $_GET['id'];
    $sql = "DELETE FROM register WHERE id=$id";
    $conn->query($sql);
    
    header("Location: read.php");
    exit;
}
?>