<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn -> connect_error){
    die ("Connection Failed: " . $conn->connect_error);
}

$name = $address = $phone = $bday = $username = $email = $password = '';
$errors=[];

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $bday = $_POST['bday'];
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password']; 
    
    if(empty($name)) $error['name'] = 'Name is Required';
    if(empty($address)) $error['address'] = 'Address is Required';
    if(empty($phone)) $error['phone'] = 'Phone is Required';
    if(empty($bday)) $error['bday'] = 'Bday is Required';
    if(empty($user)) $error['username'] = 'Username is Required';
    if(empty($email)) $error['email'] = 'Email is Required';
    if(empty($pass)) $error['password'] = 'Password is Required';
    
    if(count($error) == 0){
        $sql = "INSERT INTO register (name, address, phone, bday, username, email, password)
        VALUES ('$name', '$address', '$phone', '$bday', '$user', '$email', '$pass',)";
        
        if($conn -> query($sql) === TRUE){
            header("Location: register.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE>
<html lang="en">
<head>
	<title>Add New Customer</title>
</head>
<body>
	<div class="listtable">
		<h2>Add New Customer</h2>
		
		<?php if(!empty($error)): ?>
			<div class="alert">
				<ul>
					<?php foreach ($errors as $error): ?>
						<li> <?php echo $error; ?> </li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php  endif; ?>
		
		<form action="create.php" method="POST">
			<div class="mb-3">
				<input type="text" name="name" placeholder="Name" value="<?php echo $name;?>"><br>
			 	<input type="text" name="address" placeholder="Address" value="<?php echo $address;?>"><br>
				<input type="tel" name="phone" placeholder="Phone" value="<?php echo $phone;?>"><br>
				<input type="date" name="bday" placeholder="Birth-date" value="<?php echo $bday;?>"><br>
				<input type="text" name="username" placeholder="Username" value="<?php echo $user;?>"><br>
				<input type="text" name="email" placeholder="Email" value="<?php echo $email;?>"><br>
				<input type="password" name="password" placeholder="Password" value="<?php echo $pass;?>"><br>
			
				<button type="submit"> Update Customer </button>
				<button onclick="window.location.href='register.php'">Cancel</button>
			</div>
		</form>
	</div>
</body>
</html>