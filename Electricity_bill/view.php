<?php
$database = mysqli_connect("localhost","root","","electricity");
$billDetails = null;

if(isset($_POST['lookup'])){
    $meterId = intval($_POST['meter_id']);
    $resultSet = mysqli_query($database,"SELECT * FROM consumers WHERE meter_number=$meterId");
    if(mysqli_num_rows($resultSet) > 0){
        $billDetails = mysqli_fetch_assoc($resultSet);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bill Inquiry</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Bill Inquiry System</h2>

<form method="post" action="">
<label>Meter ID</label>
<input type="number" name="meter_id" required>
<button type="submit" name="lookup">Search</button>
<button type="button" class="secondary-btn"
onclick="location.href='main.php'">
Return to Control Center
</button>

</form>

<?php if($billDetails !== null){ ?>
<div class="info">
<p><b>Consumer Name:</b> <?php echo htmlspecialchars($billDetails['name']); ?></p>
<p><b>Account Number:</b> <?php echo isset($billDetails['id']) ? $billDetails['id'] : $billDetails['meter_number']; ?></p>
<p><b>Meter ID:</b> <?php echo $billDetails['meter_number']; ?></p>
<p><b>Amount Paid:</b> ₹<?php echo $billDetails['amount_paid']; ?></p>
<p><b>Amount Due:</b> ₹<?php echo $billDetails['amount_due']; ?></p>
<p><b>Issue Date:</b> <?php echo $billDetails['billing_date']; ?></p>
<p><b>Payment Deadline:</b> <?php echo $billDetails['due_date']; ?></p>
</div>
<?php } elseif(isset($_POST['lookup'])) { ?>
<div class="info">
<p>No records found for the provided Meter ID.</p>
</div>
<?php } ?>
</div>
</body>
</html>
