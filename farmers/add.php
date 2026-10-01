<?php

require_once "../config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $farmer_code = trim($_POST["farmer_code"]);
    $name = trim($_POST["name"]);
    $mobile = trim($_POST["mobile"]);
    $address = trim($_POST["address"]);
    $village = trim($_POST["village"]);
    $bank_account = trim($_POST["bank_account"]);
    $ifsc = trim($_POST["ifsc"]);

    $sql = "INSERT INTO farmers
            (farmer_code, name, mobile, address, village, bank_account, ifsc)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssss",
        $farmer_code,
        $name,
        $mobile,
        $address,
        $village,
        $bank_account,
        $ifsc
    );

    if ($stmt->execute()) {

        header("Location: index.php");
        exit();

    } else {

        $message = "Error: " . $stmt->error;

    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Farmer</title>

</head>

<body>

    <h1>👨‍🌾 Add New Farmer</h1>

    <a href="index.php">← Back to Farmers</a>

    <br><br>

    <?php if ($message != ""): ?>

        <p style="color:red;">
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>


    <form method="POST">

        <label>Farmer Code:</label>
        <br>

        <input
            type="text"
            name="farmer_code"
            placeholder="Example: F001"
            required
        >

        <br><br>


        <label>Farmer Name:</label>
        <br>

        <input
            type="text"
            name="name"
            placeholder="Enter farmer name"
            required
        >

        <br><br>


        <label>Mobile:</label>
        <br>

        <input
            type="text"
            name="mobile"
            placeholder="Enter mobile number"
        >

        <br><br>


        <label>Address:</label>
        <br>

        <textarea
            name="address"
            placeholder="Enter address"
        ></textarea>

        <br><br>


        <label>Village:</label>
        <br>

        <input
            type="text"
            name="village"
            placeholder="Enter village"
        >

        <br><br>


        <label>Bank Account:</label>
        <br>

        <input
            type="text"
            name="bank_account"
            placeholder="Enter bank account"
        >

        <br><br>


        <label>IFSC:</label>
        <br>

        <input
            type="text"
            name="ifsc"
            placeholder="Enter IFSC"
        >

        <br><br>


        <button type="submit">
            Save Farmer
        </button>

    </form>

</body>

</html>