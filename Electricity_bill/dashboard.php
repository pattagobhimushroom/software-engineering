<?php
$dbHandle = mysqli_connect("localhost","root","","electricity");
$accountInfo = null;

if(isset($_POST['query'])){
    $meterId = intval($_POST['meter_id']);
    $queryResult = mysqli_query($dbHandle,"SELECT * FROM users WHERE meter_number=$meterId");
    if(mysqli_num_rows($queryResult) > 0){
        $accountInfo = mysqli_fetch_assoc($queryResult);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Account Lookup</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Account Lookup</h2>

<form method="post" action="">
<label>Meter ID</label>
<input type="number" name="meter_id" required>
<button type="submit" name="query">Retrieve</button>
</form>

<?php if($accountInfo !== null){ ?>
<div class="info">
<p><b>Account Holder:</b> <?php echo htmlspecialchars($accountInfo['name']); ?></p>
<p><b>Meter ID:</b> <?php echo $accountInfo['meter_number']; ?></p>
<p><b>Total Paid:</b> ₹<?php echo $accountInfo['amount_paid']; ?></p>
<p><b>Outstanding:</b> ₹<?php echo $accountInfo['amount_due']; ?></p>
<p><b>Issue Date:</b> <?php echo $accountInfo['billing_date']; ?></p>
<p><b>Payment Deadline:</b> <?php echo $accountInfo['due_date']; ?></p>
</div>
<?php } elseif(isset($_POST['query'])) { ?>
<div class="info">
<p>No account found for the provided Meter ID.</p>
</div>
<?php } ?>
</div>

</body>
</html>
