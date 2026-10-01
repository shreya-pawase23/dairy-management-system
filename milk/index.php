<?php

require_once "../config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $farmer_id = $_POST["farmer_id"];
    $collection_date = $_POST["collection_date"];

    $morning_litre = (float) $_POST["morning_litre"];
    $morning_fat = (float) $_POST["morning_fat"];
    $morning_snf = (float) $_POST["morning_snf"];
    $morning_rate = (float) $_POST["morning_rate"];

    $evening_litre = (float) $_POST["evening_litre"];
    $evening_fat = (float) $_POST["evening_fat"];
    $evening_snf = (float) $_POST["evening_snf"];
    $evening_rate = (float) $_POST["evening_rate"];

    $morning_amount = $morning_litre * $morning_rate;
    $evening_amount = $evening_litre * $evening_rate;

    $total_litre = $morning_litre + $evening_litre;
    $total_amount = $morning_amount + $evening_amount;

    $sql = "INSERT INTO milk_collection
            (
                farmer_id,
                collection_date,
                morning_litre,
                morning_fat,
                morning_snf,
                morning_rate,
                morning_amount,
                evening_litre,
                evening_fat,
                evening_snf,
                evening_rate,
                evening_amount,
                total_litre,
                total_amount
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "isdddddddddddd",
        $farmer_id,
        $collection_date,
        $morning_litre,
        $morning_fat,
        $morning_snf,
        $morning_rate,
        $morning_amount,
        $evening_litre,
        $evening_fat,
        $evening_snf,
        $evening_rate,
        $evening_amount,
        $total_litre,
        $total_amount
    );

    if ($stmt->execute()) {

        $message = "Milk collection saved successfully!";

    } else {

        $message = "Error: " . $stmt->error;

    }

    $stmt->close();
}

$farmer_result = $conn->query(
    "SELECT id, farmer_code, name
     FROM farmers
     WHERE status = 1
     ORDER BY name"
);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Milk Collection</title>
</head>

<body>

    <h1>🥛 Milk Collection</h1>
    <?php if ($message != ""): ?>

    <p>
        <?php echo htmlspecialchars($message); ?>
    </p>

<?php endif; ?>

    <a href="../dashboard.php">← Dashboard</a>

    <br><br>

    <form method="POST">

        <label>Farmer:</label>
        <br>

        <select name="farmer_id" required>

            <option value="">-- Select Farmer --</option>

            <?php while ($farmer = $farmer_result->fetch_assoc()): ?>

                <option value="<?php echo $farmer["id"]; ?>">

                    <?php
                    echo htmlspecialchars(
                        $farmer["farmer_code"] . " - " . $farmer["name"]
                    );
                    ?>

                </option>

            <?php endwhile; ?>

        </select>

        <br><br>

        <label>Collection Date:</label>
        <br>

        <input
            type="date"
            name="collection_date"
            value="<?php echo date('Y-m-d'); ?>"
            required
        >

        <hr>

        <h3>🌅 Morning Collection</h3>

        <label>Milk (Litres):</label>
        <br>

        <input
            type="number"
            name="morning_litre"
            step="0.01"
            value="0"
        >

        <br><br>

        <label>Fat:</label>
        <br>

        <input
            type="number"
            name="morning_fat"
            step="0.01"
            value="0"
        >

        <br><br>

        <label>SNF:</label>
        <br>

        <input
            type="number"
            name="morning_snf"
            step="0.01"
            value="0"
        >

        <br><br>

        <label>Rate:</label>
        <br>

        <input
            type="number"
            name="morning_rate"
            step="0.01"
            value="0"
        >

        <hr>

        <h3>🌆 Evening Collection</h3>

        <label>Milk (Litres):</label>
        <br>

        <input
            type="number"
            name="evening_litre"
            step="0.01"
            value="0"
        >

        <br><br>

        <label>Fat:</label>
        <br>

        <input
            type="number"
            name="evening_fat"
            step="0.01"
            value="0"
        >

        <br><br>

        <label>SNF:</label>
        <br>

        <input
            type="number"
            name="evening_snf"
            step="0.01"
            value="0"
        >

        <br><br>

        <label>Rate:</label>
        <br>

        <input
            type="number"
            name="evening_rate"
            step="0.01"
            value="0"
        >

        <br><br>

        <button type="submit">
            Save Milk Collection
        </button>

    </form>
    <hr>

<h2>📋 Milk Collection Records</h2>

<?php

$records = $conn->query("
    SELECT 
        milk_collection.*,
        farmers.farmer_code,
        farmers.name
    FROM milk_collection
    INNER JOIN farmers
        ON milk_collection.farmer_id = farmers.id
    ORDER BY milk_collection.collection_date DESC,
             milk_collection.id DESC
");

?>

<table border="1" cellpadding="10">

    <tr>
        <th>Date</th>
        <th>Farmer</th>
        <th>Morning (L)</th>
        <th>Evening (L)</th>
        <th>Total (L)</th>
        <th>Total Amount</th>
    </tr>

    <?php if ($records->num_rows > 0): ?>

        <?php while ($record = $records->fetch_assoc()): ?>

            <tr>

                <td>
                    <?php echo htmlspecialchars($record["collection_date"]); ?>
                </td>

                <td>
                    <?php
                    echo htmlspecialchars(
                        $record["farmer_code"] . " - " . $record["name"]
                    );
                    ?>
                </td>

                <td>
                    <?php echo $record["morning_litre"]; ?>
                </td>

                <td>
                    <?php echo $record["evening_litre"]; ?>
                </td>

                <td>
                    <?php echo $record["total_litre"]; ?>
                </td>

                <td>
                    ₹<?php echo $record["total_amount"]; ?>
                </td>

            </tr>

        <?php endwhile; ?>

    <?php else: ?>

        <tr>
            <td colspan="6">
                No milk collection records found.
            </td>
        </tr>

    <?php endif; ?>

</table>

</body>

</html>