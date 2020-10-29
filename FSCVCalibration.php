<!DOCTYPE html>
<html lang="en">
<title>FSCV Analysis</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="JavaScriptPackages/plotly-latest.min.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script src="JavaScriptPackages/ArrayMethods.js"></script>
<script src="JavaScriptPackages/DashboardMethods.js"></script>
<script src="JavaScriptPackages/sweetalert.min.js"></script>
<script lang="javascript" src="JavaScriptPackages/xlsx.full.min.js"></script>
<script src = "OOP/FSCVClass.js"></script>
<script src = "OOP/LOADClass.js"></script>
<head>
<title>FSCV Analysis</title>
<link rel="shortcut icon" href="Images/cv.png"/>
<link type="text/css" rel="stylesheet" href="Styling/styles.css"/>
<link rel="stylesheet" href="Styling/bootstrap.min.css"/>
<link rel="stylesheet" href="Styling/buttons.css"/>
</head>

<script>
// Fading out of loading icon in applications.
$(window).on('load', function () {
$(".se-pre-con").fadeOut("slow");
});
</script>

<body>
<div class="header">
<h1>FSCV Analysis</h1>
</div>
<br>
<div id="loading" class="se-pre-con"></div>

<form id="upload_form3" enctype="multipart/form-data" method="post">
<input type="file" name="FSCVfiles" id="FSCVfiles" multiple> </input>

<p id="status"> Upload the files.</p>
</form>

<script>
var Loaded_data = new HL_LOAD_DATA("status");
document.getElementById("FSCVfiles").addEventListener('change', Loaded_data.read_files);



</script>

</body>
</html>
