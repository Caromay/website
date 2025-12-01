
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$uploadStatus = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $uploadStatus = "<div class='alert alert-danger'>File upload error: " . $_FILES['image']['error'] . "</div>";
    } else {
        $id = $_POST["id"];
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $uploadDIR = 'uploads/';
        $targetfile = $uploadDIR . basename($imageName);
        
        if (move_uploaded_file($imageTmpName, $targetfile)) {
            $sql = "UPDATE register SET image = '$imageName' WHERE id = '$id'";
            if ($conn->query($sql) === TRUE) {
                $uploadStatus = "<div class='alert alert-success'>Image Uploaded Successfully</div>";
            } else {
                $uploadStatus = "<div class='alert alert-danger'>Failed Uploading: " . $conn->error . "</div>";
            }
        } else {
            $uploadStatus = "<div class='alert alert-danger'>Failed to move uploaded file.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <link rel="stylesheet" href="css/read.css">
</head>
<body>
	
    <div class="container">
        <center><h1>List of Customers</h1></center>
        <?php echo $uploadStatus; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Birthdate</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Image</th>
                     <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $sql = "SELECT * FROM register";
            $result = $conn->query($sql);
            if (!$result) {
                die("Error Query: " . $conn->error);
            }
            
            while ($row = $result->fetch_assoc()) { 
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['bday']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['password']}</td>
                    <td><img src='uploads/{$row['image']}' width='100' height='100' alt='Customer Image'></td>
                    <td>
                        <div class='button-group'>
                            <a class='btn btn-primary btn-sm' href='update.php?id={$row['id']}'>Edit</a><br><br>
                            <a class='btn btn-danger btn-sm' href='delete.php?id={$row['id']}'>Delete</a><br><br>

                            <form action='' method='POST' enctype='multipart/form-data' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='file' name='image' required><br><br>
                                <button type='submit' class='upload-btn'>Upload Image</button><br><br>
                                <button class='login-btn' onclick=\"window.location.href='login.html'\">Log In</button>
                            </form>
                        </div>
                    </td>
                </tr>
                ";
            }
            $conn->close();
            ?>
            </tbody> 
        </table>
    </div>
</body>
</html>