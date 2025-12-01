<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn -> connect_error){
    die ("Connection Failed: " . $conn->connect_error);
}

$id = $name = $address = $phone = $bday = $username = $email = $password = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM register WHERE id=$id";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
        
        $name = $row['name'];
        $address = $row['address'];
        $phone = $row['phone'];
        $bday = $row['bday'];
        $user = $row['username'];
        $email = $row['email'];
        $pass = $row['password'];  
    } else {
        $error = " Customer not found!";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $bday = $_POST['bday'];
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];  
    if(!empty($name) && !empty($address) && !empty($phone) && !empty($bday) && !empty($user) && !empty($email) && !empty($pass)){
        $sql = "UPDATE register SET name='$name', address='$address', phone='$phone', bday='$bday', username='$user', email='$email', password='$pass' WHERE id=$id";
        if($conn->query($sql) === TRUE){
            header("Location: read.php");
            exit;
        } else {
            $error = "Error updating record: " . $conn->error;
        }
    }else {
        $error = "All fields are required!";
    }
}
$conn->close();
?>

<html>
<head>
	<title>Edit Customer</title>
	<link rel="stylesheet" href="css/register.css">
</head>
<body>
	<center>
	<div class="container">
	<h2>Edit Customer</h2>
	
	<?php if(!empty($error)){echo "<div class='alert alert-danger'>$error</div>";}?>
	
	<form method="POST">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div class="form-group">
			<input type="text" name="name" placeholder="Name" value="<?php echo $name;?>"><br>
			<input type="text" name="address" placeholder="Address" value="<?php echo $address;?>"><br>
			<input type="tel" name="phone" placeholder="Phone" value="<?php echo $phone;?>"><br>
			<input type="date" name="bday" placeholder="Birth-date" value="<?php echo $bday;?>"><br>
			<input type="text" name="username" placeholder="Username" value="<?php echo $user;?>"><br>
			<input type="text" name="email" placeholder="Email" value="<?php echo $email;?>"><br>
			<input type="password" name="password" placeholder="Password" value="<?php echo $pass;?>"><br>
			
			<button type="submit"> Update Customer </button>
			<a href="read.php" class="login-link"> Cancel</a>
		</div>
	</form>
	</div>
	</center>
</body>
</html>