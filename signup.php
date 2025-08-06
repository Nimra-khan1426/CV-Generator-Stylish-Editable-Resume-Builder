<?php
$conn = new mysqli("localhost", "root", "12345", "cv_generator");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    //  Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('❗ Email already registered. Please use another email or log in.'); window.location.href='auth.html';</script>";
        exit();
    }

    // If email is not taken, insert the new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        session_start();
        $_SESSION["user"] = $username;
        header("Location: cv_form.php");
        exit();
    } else {
        echo "Signup failed: " . $stmt->error;
    }

    $stmt->close();
    $check->close();
}

$conn->close();
?>
