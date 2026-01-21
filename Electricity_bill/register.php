<?php
$dbLink = mysqli_connect("localhost", "root", "", "electricity");

$newMeterNumber = "";
$newBillId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $newMeterNumber = rand(100000, 999999);

    $custName   = $_POST['name'];
    $custPhone  = $_POST['phone'];
    $custAddr   = $_POST['address'];
    $custPin    = $_POST['pincode'];
    $custType   = $_POST['category'];

    $createdOn  = date("Y-m-d");
    $payBefore  = date("Y-m-d", strtotime("+15 days"));

    $insertSql = "
        INSERT INTO consumers
            (meter_number, name, phone, address, pincode, category, billing_date, due_date)
        VALUES
            ($newMeterNumber, '$custName', '$custPhone', '$custAddr', '$custPin',
             '$custType', '$createdOn', '$payBefore')
    ";

    if ($dbLink && mysqli_query($dbLink, $insertSql)) {
        $newBillId = mysqli_insert_id($dbLink);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Consumer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>New Consumer Registration</h2>

    <?php if($newMeterNumber !== "" && $newBillId !== null){ ?>
        <div class="info">
            <p><strong>Registration completed.</strong></p>
            <p>Your meter number:</p>
            <h3><?php echo $newMeterNumber; ?></h3>

            <p>Your bill reference:</p>
            <h3><?php echo $newBillId; ?></h3>

            <button type="button"
                    onclick="location.href='main.php?meter=<?php echo $newMeterNumber; ?>&bill_no=<?php echo $newBillId; ?>'">
                Go to Main Dashboard
            </button>
        </div>
    <?php } else { ?>

        <form method="post">
            <label>Name (camelCase)</label>
            <input type="text" name="name" pattern="[a-z]+([A-Z][a-z]+)*" required>

            <label>Phone (10 digits)</label>
            <input type="text" name="phone" pattern="[0-9]{10}" required>

            <label>Address</label>
            <textarea name="address"></textarea>

            <label>Pincode</label>
            <input type="text" name="pincode" pattern="[0-9]{6}" required>

            <label>Category</label>
            <select name="category">
                <option>household</option>
                <option>commercial</option>
                <option>industry</option>
            </select>

            <button name="register">Create Consumer</button>

            <button type="reset" class="secondary-btn">
                Clear
            </button>
        </form>

    <?php } ?>
</div>

</body>
</html>
