<?php
use PHPMailer\PHPMailer\PHPMailer;
require ("db.php");
require("login.php");
require("mycredential.php");
$result = mysqli_query($conn,"SELECT * FROM member WHERE email='" . $_SESSION['email'] . "'");
$row= mysqli_num_rows($result);
if($row > 0)
{
$token = md5($_SESSION['email']).rand(10,9999);
mysqli_query($conn, "UPDATE member SET email_verification_link = '" . $token . "' WHERE email='" . $_SESSION['email'] . "'");
$link = "<a href='localhost/BidFare/verify-email.php?key=".$_SESSION['email']."&token=".$token."'>Click and Verify Email</a>";

require_once('phpmailer/PHPMailer.php');
require_once('phpmailer/SMTP.php');
require_once('phpmailer/Exception.php');

$mail = new PHPMailer();
$mail->CharSet =  "utf-8";
$mail->IsSMTP();
// enable SMTP authentication
$mail->SMTPAuth = true;                  
// GMAIL username
$mail->Username = EMAIL;
// GMAIL password
$mail->Password = PASS;
$mail->SMTPSecure = "ssl";  
// sets GMAIL as the SMTP server
$mail->Host = "smtp.gmail.com";
// set the SMTP port for the GMAIL server
$mail->Port = "465";
$mail->From='halcyongarima@gmail.com';
$mail->FromName='BidFare';
$mail->addAddress($_SESSION["email"]);
$mail->Subject  =  'BidFare Account Verification';
$mail->IsHTML(true);
$mail->Body    = 'Click On This Link to Verify Email '.$link.'';
if($mail->send())
{
echo "Check Your Email box and Click on the email verification link.";
}
else
{
echo "Mail Error - >".$mail->ErrorInfo;
}
}
else
{
echo "You have already registered with us. Check Your email box and verify email"  ;
}
?>