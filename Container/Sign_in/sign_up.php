<?php
$servername = "localhost:3306";
$username = "root"; 
$password = "Altanesmer_2005"; 
$dbname = "user_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['mail']) && isset($_POST['pass'])) {
    $username = $_POST['username'];
    $email = $_POST['mail'];
    $password = password_hash($_POST['pass'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "Sign-up successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
