<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>BidFare User Account Activation</title>
<!-- CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php
if($_GET['key'] && $_GET['token'])
{
require ("db.php");
$email = $_GET['key'];
$token = $_GET['token'];
$query = mysqli_query($conn,
"SELECT * FROM member WHERE email_verification_link='".$token."' AND email='".$email."';"
);
if (mysqli_num_rows($query) > 0) {
$row= mysqli_fetch_array($query);
if($row['verification'] == 'no'){
mysqli_query($conn,"UPDATE member SET verification ='yes' WHERE email='" . $email . "'");
$msg = "Congratulations! Your email has been verified. Now you can bid on desired items.";
}else{
$msg = "You have already verified your account with us";
}
} else {
$msg = "This email has not been registered with us";
}
}
else
{
$msg = "Danger! Something went wrong.";
}
?>
<div class="container mt-3">
<div class="card">
<div class="card-header text-center">
User Account successfully activated
</div>
<div class="card-body">
<p><?php echo $msg; ?></p>
</div>
</div>
</div>
</body>
</html>