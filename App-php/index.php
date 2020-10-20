<?php
switch ($_SERVER['REQUEST_URI']) {
  case '/':
  include 'home.php';
  break;
  case '/Documentation.php':
  include 'Documentation.php';
  break;
  case '/FSCVConvolution.php':
  include 'FSCVConvolution.php';
  break;
  case '/FSCVisual00.php':
  include 'FSCVisual00.php';
  break;
  case '/FSCVisual02.php':
  include 'FSCVisual02.php';
  break;
  case '/FSCVisual3.php':
  include 'FSCVisual3.php';
  break;
  case '/SubmitContactForm.php':
  include 'SubmitContactForm.php';
  break;
  case '/ContactForm.php':
  include 'ContactForm.php';
  break;
  case '/save_csv.php':
  include 'save_csv.php';
  break;
  case '/save_csv2.php':
  include 'save_csv2.php';
  break;
  default:
  include 'home.php';
  break;
}
?>
