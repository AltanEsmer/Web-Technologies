<?php
$servername = "localhost:3306";
$username = "root"; 
$password = "Altanesmer_2005"; 
$dbname = "user_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['mail']) && isset($_POST['pass'])) {
    $email = $_POST['mail'];
    $password = $_POST['pass'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        echo "Login successful!";
    } else {
        echo "Invalid email or password!";
    }

    $stmt->close();
}

$conn->close();
?>
