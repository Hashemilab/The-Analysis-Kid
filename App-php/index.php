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
  case '/FSCVisualColorPlot.php':
  include 'FSCVisualColorPlot.php';
  break;
  case '/FSCVisualTransient.php':
  include 'FSCVisualTransient.php';
  break;
  case '/FSCVisualiVPlot.php':
  include 'FSCVisualiVPlot.php';
  break;
  case '/SubmitContactForm.php':
  include 'SubmitContactForm.php';
  break;
  case '/ContactForm.php':
  include 'ContactForm.php';
  break;
  case '/check_upload.php':
  include 'check_upload.php';
  break;
  default:
  include 'home.php';
  break;
}
?>
