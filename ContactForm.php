<!DOCTYPE html>
<html lang="en">
<title>Contact Form</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Styling/popup.css">
<script src="JavaScriptPackages/fontawesome-828d573e3a.js"></script>
<link rel="shortcut icon" href="Images/cv.png"/>
<br>
<br>
<div id="contact">
<form action="SubmitContactForm.php" enctype="multipart/form-data" method="post">
<ul>
<h1>Contact</h1>
<li>
<input type="text" name="ContactName" id="ContactName" placeholder="&#xf2c0; Full name" >
<input type="email" name="ContactEmail" id="ContactEmail" placeholder="&#xf003; Email" required>
</li>
<li>
<textarea name="ContactMessage" cols="50" id="ContactMessage" placeholder="&#xf040; Your message" required></textarea>
</li>
<li>
<input type="submit" value="Send message" class="btn" id="submit">
</li>
</ul>
</form>


<p style="text-align: center;">
<a href = "mailto:sergio.mena19@imperial.ac.uk?subject = Feedback&body = Message"><i class="fa fa-envelope"></i></a>
<a href="https://twitter.com/sermeor"><i class="fab fa-twitter"></i></a>
<a href="https://www.linkedin.com/in/sergio-mena-ortega-a418ab120/"><i class="fab fa-linkedin-in"></i></a>
</p>
<br>
</div>

<script>
$(function() {

// contact form animations
$('#contact').click(function() {
$('#contactForm').fadeToggle();
})
$(document).mouseup(function (e) {
var container = $("#contactForm");

if (!container.is(e.target) // if the target of the click isn't the container...
&& container.has(e.target).length === 0) // ... nor a descendant of the container
{
  container.fadeOut();
}
});
});
</script>

</html>
