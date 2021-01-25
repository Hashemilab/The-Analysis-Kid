<?php
switch ($_SERVER['REQUEST_URI']) {
  case '/':
  include 'home.php';
  break;
  case '/Documentation.php':
  include 'Documentation.php';
  break;
  case '/FSCAVCalibration.php':
  include 'FSCAVCalibration.php';
  break;
  case '/FSCVCalibration.php':
  include 'FSCVCalibration.php';
  break;
  case '/FSCVMichaelisMenten1.php':
  include 'FSCVMichaelisMenten1.php';
  break;
  case '/FSCVMichaelisMenten2.php':
  include 'FSCVMichaelisMenten2.php';
  break;
  case '/SubmitContactForm.php':
  include 'SubmitContactForm.php';
  break;
  case '/ContactForm.php':
  include 'ContactForm.php';
  break;
  default:
  include 'home.php';
  break;
}
?>
