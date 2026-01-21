<?php
session_start();
if(empty($_SESSION['role'])) {
    die("Authentication required");
}

$adminAccess = ($_SESSION['role'] == "admin");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bill Generator</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
<h2>Bill Generator</h2>

<form method="post" action="">
<label>Full Name (camelCase format)</label>
<input type="text" name="name" pattern="[a-z]+([A-Z][a-z]+)*" required>

<label>Contact Number</label>
<input type="text" name="mobile" pattern="[0-9]{10}" required>

<label>Residential Address</label>
<textarea name="address"></textarea>

<label>Postal Code</label>
<input type="text" name="pincode" pattern="[0-9]{6}" required>

<label>Consumer Type</label>
<select name="category">
<option value="household">Household</option>
<option value="commercial">Commercial</option>
<option value="industry">Industry</option>
</select>

<label>Previous Reading</label>
<input type="number" name="past" required>

<label>Current Reading</label>
<input type="number" name="present" required>

<?php if($adminAccess){ ?>
<button type="submit" name="generate">Create Bill</button>
<?php } else { ?>
<p class="error">Access denied: Only administrators can create bills</p>
<?php } ?>

<button type="button" onclick="location.href='main.php'">
    Cancel
</button>

</form>

<?php
if(isset($_POST['generate']) && $adminAccess){

$dbLink = mysqli_connect("localhost","root","","electricity");

$previousReading = intval($_POST['past']);
$currentReading = intval($_POST['present']);
$unitsConsumed = $currentReading - $previousReading;
$unitsConsumed = max(0, $unitsConsumed);

$pricePerUnit = 0;
$consumerType = $_POST['category'];
if($consumerType == "household") {
    $pricePerUnit = 5;
} elseif($consumerType == "commercial") {
    $pricePerUnit = 8;
} else {
    $pricePerUnit = 10;
}

$currentCharge = ($unitsConsumed == 0) ? 50 : ($unitsConsumed * $pricePerUnit);
$previousBalance = isset($_POST['paid']) ? 0 : 200;
$grandTotal = $currentCharge + $previousBalance;

$issueDate = date("Y-m-d");
$expiryDate = date("Y-m-d", strtotime("+15 days"));

echo "<div class='info'>
<p><b>Meter ID:</b> 1001</p>
<p><b>Issue Date:</b> $issueDate</p>
<p><b>Expiry Date:</b> $expiryDate</p>
<p><b>Units Consumed:</b> $unitsConsumed</p>
<p><b>Current Charge:</b> ₹$currentCharge</p>
<p><b>Previous Balance:</b> ₹$previousBalance</p>
<h3>Grand Total: ₹$grandTotal</h3>
</div>";
}
?>
</div>
</body>
</html>
