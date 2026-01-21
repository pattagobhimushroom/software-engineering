<?php
$dbUser = mysqli_connect("localhost", "root", "", "electricity");

if (!isset($_GET['meter']) || $_GET['meter'] === "") {
    header("Location: register.php");
    exit();
}

$meterNumber = $_GET['meter'];
$userQuery   = mysqli_query($dbUser, "SELECT * FROM consumers WHERE meter_number = $meterNumber");

if (!$userQuery || mysqli_num_rows($userQuery) === 0) {
    header("Location: register.php");
    exit();
}

$consumerRow = mysqli_fetch_assoc($userQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consumer Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Consumer Panel</h2>

    <div class="info">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($consumerRow['name']); ?></p>
        <p><strong>Bill No:</strong> <?php echo isset($consumerRow['id']) ? $consumerRow['id'] : $consumerRow['meter_number']; ?></p>
        <p><strong>Meter:</strong> <?php echo $consumerRow['meter_number']; ?></p>
        <p><strong>Paid Amount:</strong> ₹<?php echo $consumerRow['amount_paid']; ?></p>
        <p><strong>Outstanding Due:</strong> ₹<?php echo $consumerRow['amount_due']; ?></p>
        <p><strong>Bill Date:</strong> <?php echo $consumerRow['billing_date']; ?></p>
        <p><strong>Pay By:</strong> <?php echo $consumerRow['due_date']; ?></p>
    </div>

    <button type="button" onclick="location.href='register.php'">
        New Registration
    </button>

    <button type="button" class="secondary-btn"
            onclick="location.href='main.php'">
        Back to Dashboard
    </button>
</div>

</body>
</html>
