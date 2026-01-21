<?php
$db = mysqli_connect("localhost", "root", "", "electricity");

$consumers = null;
if ($db) {
    $consumers = mysqli_query($db, "SELECT * FROM consumers");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin – Consumers Overview</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Admin – Consumers Overview</h2>

    <?php if(!$db){ ?>
        <p class="error">Unable to connect to database.</p>
    <?php } elseif(mysqli_num_rows($consumers) === 0){ ?>
        <p>No consumer records found.</p>
    <?php } else { ?>
        <?php while($row = mysqli_fetch_assoc($consumers)){ ?>
            <div class="info">
                <p><strong>Meter:</strong> <?php echo $row['meter_number']; ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                <p><strong>Type:</strong> <?php echo ucfirst($row['category']); ?></p>
                <p><strong>Pending Due:</strong> ₹<?php echo $row['amount_due']; ?></p>
            </div>
        <?php } ?>
    <?php } ?>

    <button type="button" class="secondary-btn" onclick="location.href='main.php'">
        Back to Dashboard
    </button>
</div>

</body>
</html>
