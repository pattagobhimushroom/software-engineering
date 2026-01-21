<?php
$dbConnection = mysqli_connect("localhost","root","","electricity");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employee Portal</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Employee Portal - Bill Creation</h2>

<form method="post" action="">
<label>Consumer Meter ID</label>
<input type="number" name="meter_id" required>

<label>Current Meter Reading</label>
<input type="number" name="current_reading" required>

<button type="submit" name="create_bill">Create Bill</button>

<button type="button" class="secondary-btn"
onclick="location.href='main.php'">
Return to Main Menu
</button>

</form>

<?php
if(isset($_POST['create_bill'])){

    $meterId = intval($_POST['meter_id']);
    $currentReading = intval($_POST['current_reading']);

    $fetchQuery = mysqli_query($dbConnection,"SELECT * FROM consumers WHERE meter_number=$meterId");

    if(mysqli_num_rows($fetchQuery) == 0){
        echo "<p class='error'>Meter ID not found in system</p>";
    } else {

        $consumerData = mysqli_fetch_assoc($fetchQuery);

        $consumedUnits = $currentReading - intval($consumerData['past_units']);
        $consumedUnits = max(0, $consumedUnits);

        $unitPrice = 0;
        switch($consumerData['category']){
            case "household":
                $unitPrice = 7;
                break;
            case "commercial":
                $unitPrice = 10;
                break;
            default:
                $unitPrice = 12;
        }

        $billAmount = ($consumedUnits == 0) ? 50 : ($consumedUnits * $unitPrice);
        $newTotalDue = floatval($consumerData['amount_due']) + $billAmount;

        mysqli_query($dbConnection,"UPDATE consumers SET
            past_units = $currentReading,
            present_units = $currentReading,
            amount_due = $newTotalDue,
            billing_date = CURDATE(),
            due_date = DATE_ADD(CURDATE(), INTERVAL 15 DAY)
            WHERE meter_number = $meterId
        ");

        echo "<div class='info'>
                <p><b>Bill Created</b></p>
                <p>Consumption: $consumedUnits units</p>
                <p>Price per unit: ₹$unitPrice</p>
                <p>This period charge: ₹$billAmount</p>
                <p>Outstanding balance: ₹$newTotalDue</p>
              </div>";
    }
}
?>
</div>

</body>
</html>
