<?php
session_start();
require_once "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ? AND status = 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if ($password == $user["password"]) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["full_name"] = $user["full_name"];
            $_SESSION["role"] = $user["role"];

            header("Location: dashboard.php");
            exit();

        } else {
            $message = "Wrong password!";
        }

    } else {
        $message = "Username not found!";
    }
}
?><!DOCTYPE html>
<html>
<head>
    <title>Dairy Management Login</title>
</head>

<body>

    <h1>Milk Dairy Management System</h1>

    <h2>Login</h2>
    <?php
if ($message != "") {
    echo "<p>" . $message . "</p>";
}
?>

    <form method="POST">

        <label>Username:</label>
        <input type="text" name="username">

        <br><br>

        <label>Password:</label>
        <input type="password" name="password">

        <br><br>

        <button type="submit">Login</button>

    </form>

</body>
</html>