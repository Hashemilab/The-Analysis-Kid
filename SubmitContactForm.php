<!DOCTYPE html>
<html lang="en">
<title>FSCV Calibration</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Styling/popup.css">
<script src="JavaScriptPackages/fontawesome-828d573e3a.js"></script>

<head>
<link rel="shortcut icon" href="Images/cv.png"/>
</head>
<br>
<br>
<div id="contact">
<form action="ContactForm.php" enctype="multipart/form-data" method="post">
<ul>
<h1><i class="far fa-check-circle"></i></h1>
<li>
<p style="text-align: center; font-family:verdana"><b>Message submitted</b></p>
<br>
<p style="text-align: center; font-family:verdana">Thank you for getting in contact </p>
<p style="text-align: center; font-family:verdana">We will get back to you shortly </p>
</li>
<p>
<li>
<input type="submit" value="Back to Contact Form" class="btn" id="submit">
</li>
</p>

</ul>
</form>
<p style="text-align: center;">
<a href = "mailto:sergio.mena19@imperial.ac.uk?subject = Feedback&body = Message"><i class="fa fa-envelope"></i></a>
<a href="https://twitter.com/sermeor"><i class="fab fa-twitter"></i></a>
<a href="https://www.linkedin.com/in/sergio-mena-ortega-a418ab120/"><i class="fab fa-linkedin-in"></i></a>
</p>
<br>
</div>
</html>

<?php
require 'vendor/autoload.php';
use \Mailjet\Resources;
$mj = new \Mailjet\Client('230739fc1c1bb63745b60db1b26aae7f','0d386f39497decfd383bae6e0486ade7',true,['version' => 'v3.1']);
$body = [
'Messages' => [
[
'From' => [
'Email' => "sergiomenaortega95@gmail.com",
'Name'  => htmlspecialchars($_POST['ContactName'])
],
'To' => [
[
'Email' => "sergiomenaortega95@gmail.com",
'Name' => "Sergio"
]
],
'Subject' => "NeuroCloud Message from ".htmlspecialchars($_POST['ContactEmail']),
'TextPart' => "",
'HTMLPart' => "Message: ".htmlspecialchars($_POST['ContactMessage']),
'CustomID' => htmlspecialchars($_POST['ContactEmail'])
]
]
];
$response = $mj->post(Resources::$Email, ['body' => $body]);

?>
