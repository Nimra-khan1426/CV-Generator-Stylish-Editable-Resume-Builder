<?php
$conn = new mysqli("localhost", "root", "12345", "cv_generator");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // check user by username or email
  $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ? OR email = ?");
  $stmt->bind_param("ss", $username, $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($fetchedUsername, $hashedPassword);
    $stmt->fetch();

    if (password_verify($password, $hashedPassword)) {
      session_start();
      $_SESSION["user"] = $fetchedUsername;

      // ✅ Redirect to cv_form.php
      header("Location: cv_form.php");
      exit();
    } else {
      echo "<script>alert('❗ Incorrect password.'); window.location.href='auth.html';</script>";
    }
  } else {
    echo "<script>alert('❗ No user found.'); window.location.href='auth.html';</script>";
  }

  $stmt->close();
}
$conn->close();
?>
