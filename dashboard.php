<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
require_once "config/db.php";
$milk_result = $conn->query(
    "SELECT 
        COALESCE(SUM(total_litre), 0) AS total_milk,
        COALESCE(SUM(total_amount), 0) AS total_amount
     FROM milk_collection"
);

$milk_row = $milk_result->fetch_assoc();

$total_milk = $milk_row["total_milk"];
$total_amount = $milk_row["total_amount"];

$milk_row = $milk_result->fetch_assoc();

$total_milk = $milk_row["total_milk"];

require_once "config/db.php";

$result = $conn->query("SELECT COUNT(*) AS total_farmers FROM farmers");

$row = $result->fetch_assoc();

$total_farmers = $row["total_farmers"];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dairy Management Dashboard</title>
</head>

<body>

    <h1>🥛 Dairy Management System</h1>

    <h2>
        Welcome,
        <?php echo htmlspecialchars($_SESSION["full_name"]); ?>!
    </h2>

    <p>You are successfully logged in.</p>
    <h3>👨‍🌾 Total Farmers</h3>
    <h3>🥛 Total Milk Collected</h3>
    <h3>💰 Milk Amount</h3>

<p>
    ₹<?php echo number_format($total_amount, 2); ?>
</p>

<p>
    <?php echo $total_milk; ?> Litres
</p>

<a href="milk/index.php">
    Milk Collection
</a>

<p>
    <?php echo $total_farmers; ?>
</p>

<a href="farmers/index.php">
    Manage Farmers
</a>
<br><br>

<a href="milk/index.php">
    🥛 Manage Milk Collection
</a>
    <p>
        Role:
        <?php echo htmlspecialchars($_SESSION["role"]); ?>
    </p>

    <a href="logout.php">Logout</a>

</body>
</html>