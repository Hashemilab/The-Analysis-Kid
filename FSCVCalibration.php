<!DOCTYPE html>
<html lang="en">
<title>FSCV Analysis</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="JavaScriptPackages/plotly-latest.min.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script src="JavaScriptPackages/DashboardMethods.js"></script>
<script src="JavaScriptPackages/ArrayMethods.js"></script>
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

<div style = "margin-left:30px">
<input type="file" name="FSCVfiles" id="FSCVfiles" accept=".xls,.xlsx,.csv,.txt" multiple> </input>
<span style="display:inline-block; width: 5px"></span>
<button>
<a id="previous_button" onclick="include_pushed()" >Include</a>
</button>
<p id="status"> Upload the files.</p>
</div>

<div style = "text-align: center">
<label id="slider_label" for="plot_slider" style="display:none;"></label>
</div>
<div style = "text-align: center">
<button>
<a id="previous_button" onclick="previous_pushed()" >← Prev.</a>
</button>
<input type="range" class="custom-range w-25" id="file_slider" min="1" max="1" value="1" step = "1" onchange="slider_changed()">
<button>
<a id="next_button" onclick="next_pushed()">Next →</a>
</button>
</div>

<div class = "center" style = " margin:auto; width:90%;">
<div id="main_graph" class = "center"></div>
</div>

<br>
<div>
<p class="footdash">Application created by The Hashemi Lab, Imperial College London.</p>
</div>
<script>
//Buttons callbacks.
function previous_pushed(){
_('file_slider').stepDown();
slider_changed();
};
function next_pushed(){
_('file_slider').stepUp();
slider_changed();
};
function slider_changed(){
file_index = $('#file_slider').val();
$("#slider_label").html(file_index+"/"+_('file_slider').max);
};
function include_pushed(){
// Determine number of files.
_('slider_label').style.display = 'block';
_('file_slider').max = loaded_data.number_of_files;
slider_changed();
}
</script>
<script>
// Create loaded data object.
var loaded_data = new HL_LOAD_DATA("status");
var file_index = 1;
// Assign callback to read the data from the input.
_("FSCVfiles").addEventListener('change', loaded_data.read_files);

</script>

</body>
</html>
