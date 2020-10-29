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
<script src = "OOP/FSCAVClass.js"></script>
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

<div style = "text-align: left; margin-left: 30px;">
<b> Graph Selection: </b>
<label class="switch">
<input type="checkbox" id="graph_selection" name="graph_selection" value="graph_selection">
<span class="slider round"></span>
</label>
<span style="display:inline-block; width: 40px"></span>
<button>
<a id="recalculate_parameters_button" onclick="recalculate_button_pushed()" >Recalculate</a>
</button>
</div>
<div style = "text-align: left; margin-left: 30px;">
<button  id="min1" class="graph_selection" style = "background-color:#3f51b5; color: white">
<a>Min</a>
</button>
<button id="max" class="graph_selection">
<a>Max</a>
</button>
<button  id="min2" class="graph_selection">
<a id="min2">Min</a>
</button>
</div>
<div class = "center" style = " margin:auto; width:90%;">
<div class = "center" style = "float:left; width:50%;">
<div id="graph1" class = "center"></div>
</div>
<div class = "center" style = "float:right; width:50%;">
<div id="graph2"class = "center"></div>
</div>
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

<br>
<div>
<p class="footdash">Application created by The Hashemi Lab, Imperial College London.</p>
</div>

<script>
//Buttons callbacks.
//Change colors of graph selection buttons when clicking.
$(document).on("click", '.graph_selection', function(){
$('.graph_selection').css('background-color','');
$('.graph_selection').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
graph_selection_changed(this.id);
});
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
Data.plot_current_time("graph1", graph_index - 1);
};
function graph_selection_changed(id){
graph_selected_point = id;
};
function graph_clicked(evtObj){
if(document.getElementById('graph_selection').checked) {
if(evtObj.points.length != 0){
// Get index of clicked point.
let pindex = evtObj.points[0].pointIndex;
// Assign clicked point.
Data.change_points(graph_index-1, pindex, graph_selected_point);
Data.plot_current_time("graph1", graph_index-1);
}}};
function recalculate_button_pushed(){
Data.recalculate_auc_and_max();
};
</script>
<script>
// Create FSCAV Object, plot the first graph and link callbacks. .
var Data;
var graph_index = 1;
var graph_selected_point = "min1";
try {
Data = new HL_FSCAV_DATA(DataArray, neurotransmitter, v_units, c_units, frequency);
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
Data.plot_current_time("graph1", graph_index-1);
// Plot initial concentration-sample trace.
Data.plot_current_time("graph2", graph_index-1);
</script>
</body>
</html>
