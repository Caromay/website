<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn -> connect_error){
    die ( "Connection Failed: " . $conn->connect_error);
}

if ($_SERVER ["REQUEST_METHOD"]=="POST"){
    $input= isset($_POST['email']) ? $_POST['email']:'';
    $pass = isset($_POST['password']) ? $_POST['password']:'';
    $sql = "SELECT * FROM register WHERE email = '$input' AND password = '$pass'";
    $result = $conn->query($sql);
    if ($result -> num_rows > 0){
        echo "Login Successfully";
        header("Location: index.html");
    } else{
        echo "Invalid Email And Password!"  . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
