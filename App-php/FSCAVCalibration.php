<!DOCTYPE html>
<html lang="en">
<title>FSCAV Calibration</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="JavaScriptPackages/plotly-latest.min.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script src="JavaScriptPackages/ArrayMethods.js"></script>
<script src="JavaScriptPackages/DashboardMethods.js"></script>
<script src="JavaScriptPackages/sweetalert.min.js"></script>
<script src = "OOP/FSCAVObject.js"></script>
<head>
<title>FSCAV Calibration</title>
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
<h1>FSCAV Calibration</h1>
</div>
<br>
<div id="loading" class="se-pre-con"></div>


<div class = "center" style = "margin: auto; width:60%;">
<div id="graph"class = "center"></div>
</div>
<div style = "text-align: center">
<button>
<a id="previous_button" onclick="previous_pushed()" >← Prev.</a>
</button>
<input type="range" class="custom-range w-25" id="plot_slider" min="1" max="10" value="1" step = "1" onchange="slider_changed()">
<button>
<a id="next_button" onclick="next_pushed()">Next →</a>
</button>
</div>
<div style = "text-align: center">
<label id="slider_label" for="plot_slider">1</label>
</div>

<div>
<p class="footdash">Application created by The Hashemi Lab, Imperial College London.</p>
</div>

<script>
//Buttons callbacks.
function previous_pushed(){
document.getElementById('plot_slider').stepDown();
slider_changed();
};
function next_pushed(){
document.getElementById('plot_slider').stepUp();
slider_changed();
};
function slider_changed(){
graph_index = $('#plot_slider').val();
$("#slider_label").html(graph_index);
Data.plot_current_time("graph", graph_index-1);
};
</script>
<script>
// Create FSCAV Object.
var Data;
var graph_index = 0;
try {
Data = new FSCAV_DATA(DataArray, neurotransmitter, v_units, c_units, frequency);
}
catch {
Swal.fire({
icon: 'error',
title: "Data Error",
text: "The uploaded data was not succesfully processed. Please make sure your upload follows the description given in the documentation."
}).then((result => window.close()));
};
// Determine number of signals.
document.getElementById('plot_slider').max = Data.number_of_signals;
// Plot first cyclic voltammogram.
Data.plot_current_time("graph", graph_index);
</script>
</body>
</html>
