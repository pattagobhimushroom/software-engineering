<?php
$meterNumber = !empty($_GET['meter']) ? $_GET['meter'] : "";
$billNo = !empty($_GET['bill_no']) ? $_GET['bill_no'] : "";
$showSuccessMessage = !empty($meterNumber) && !empty($billNo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Control Center</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Control Center</h2>

    <?php if($showSuccessMessage){ ?>
    <div class="info" style="margin-bottom: 25px;">
        <p style="margin: 0;"><b>Account Created Successfully</b></p>
        <p style="margin: 0;">Meter ID: <strong><?php echo htmlspecialchars($meterNumber); ?></strong></p>
        <p style="margin: 0;">Account Number: <strong><?php echo htmlspecialchars($billNo); ?></strong></p>
    </div>
    <?php } ?>

    <div class="dashboard-options">

        <a href="user.php?meter=<?php echo urlencode($meterNumber); ?>" class="dash-box">
            <h3>Consumer Portal</h3>
            <p>Create new consumer account</p>
        </a>

        <a href="employee.php" class="dash-box">
            <h3>Staff Portal</h3>
            <p>Create and process bills</p>
        </a>

        <a href="admin.php" class="dash-box">
            <h3>Administrator Portal</h3>
            <p>Browse all accounts</p>
        </a>

    </div>

    <div style="margin-top:30px;">
        <a href="view.php" class="dash-box" style="width:95%;">
            <h3>Bill Inquiry</h3>
            <p>Search by meter ID to view bill information</p>
        </a>
    </div>

</div>

</body>
</html>
