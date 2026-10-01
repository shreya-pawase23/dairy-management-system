<?php

require_once "../config/db.php";

$sql = "SELECT * FROM farmers ORDER BY id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Farmers - Dairy Management</title>

</head>

<body>

    <h1>👨‍🌾 Farmer Management</h1>

    <a href="../dashboard.php">← Dashboard</a>

    <br><br>

    <a href="add.php">➕ Add Farmer</a>

    <br><br>

    <table border="1" cellpadding="10">

        <tr>
            <th>ID</th>
            <th>Farmer Code</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Village</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>

            <?php while ($farmer = $result->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?php echo $farmer["id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($farmer["farmer_code"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($farmer["name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($farmer["mobile"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($farmer["village"]); ?>
                    </td>

                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="5">
                    No farmers found.
                </td>
            </tr>

        <?php endif; ?>

    </table>

</body>
</html>