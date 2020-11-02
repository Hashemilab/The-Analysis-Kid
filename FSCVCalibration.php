<!DOCTYPE html>
<html lang="en">
<title>FSCV Analysis</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="JavaScriptPackages/plotly-latest.min.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script src="JavaScriptPackages/html2pdf.bundle.min.js"></script>
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
</head>

<script>
// Fading out of loading icon in applications.
$(window).on('load', function () {
$(".se-pre-con").fadeOut("slow");
});
</script>

<body>
<div id="loading" class="se-pre-con"></div>

<div id="wrapper" style="background-color: #eff4f7;">
<div class="header">
<h1>FSCV Analysis</h1>
</div>
<br>
<div style = "margin:auto; width: 96%;">
<div class="row">
<div class="col">
<div class="row">
<input type="file" name="FSCVfiles" id="FSCVfiles" accept=".xls,.xlsx,.csv,.txt" style="width: 75%;"  multiple> </input>
<button>
<a id="include_button" onclick="include_pushed()" >Include</a>
</button>
</div>
<div class="row">
<p id="status"> Upload the files.</p>
</div>
<div class="row">
<label for="frequency" style="width: 33%;">Freq. (Hz):</label>
<label for="cycling_frequency" style="width: 33%;">Cyc. freq (Hz):</label>
<label for="current_units" style="width: 33%;">Units:</label>
<input type="number" step="1" min=1 name="frequency" id="frequency" style="width: 33%;"  value=500000 />
<input type="number" step="1" min=1 name="cycling_frequency" id="cycling_frequency" style="width: 33%;" value=10 />
<input type="text" name="current_units" id="current_units" style="width: 33%;" value="nA"/>
</div>
</div>

<div class="col-6">
<div style = "text-align: center">
<label id="slider_label" for="plot_slider" ></label>
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
<div style = "text-align: center; margin-top:10px">
<img src="/Images/HL_Icon.png" alt="Hashemi Lab Icon" width="375" height="125">
</div>

</div>

<div class="col">
<div class="row">
<button>
<a id="invert_sign_button" onclick="invert_pushed()">Invert</a>
</button>
&nbsp;
<button>
<a id="invert_sign_button" onclick="downloadPDF()">Download as PDF</a>
</button>
&nbsp;
<button>
<a id="invert_sign_button" onclick="reset_pushed()" >Reset</a>
</button>
</div>
<div class="row" style="margin-top:5px">
<button id="surface" class="type_of_plot_selection" style="background-color:#3f51b5; color:white;">
<a>3D</a>
</button>
&nbsp;
<button id="heatmap" class="type_of_plot_selection">
<a>2D</a>
</button>
&nbsp;
<button id="contour" class="type_of_plot_selection">
<a>Contour</a>
</button>
</div>

<div class="row" style="margin-top:5px">
<button id="Custom" class="color_palette_selection" style="background-color:#3f51b5; color:white;">
<a>Custom</a>
</button>
&nbsp;
<button id="Portland" class="color_palette_selection">
<a>Portland</a>
</button>
&nbsp;
<button id="Jet" class="color_palette_selection">
<a>Jet</a>
</button>
</div>
<div class="row" style="margin-top:5px">
<button id="graph_point_selection" class="graph_point_selection">
<a>Graph selection</a>
<input type="checkbox" hidden id="graph_selection_checkbox">
</button>
</div>
</div>
</div>
</div>
<br>
<div class = "center" style = " margin:auto; width:90%; height:700px;">
<div id="main_graph" class = "center" style="width:100%; height:700px;"></div>
</div>
<br>
<div class = "center" style = " margin:auto; width:90%;">
<div class = "center" style = "float:left; width:50%;">
<div id="transient_graph" class = "center"></div>
</div>
<div class = "center" style = "float:right; width:50%;">
<div id="iv_graph" class = "center"></div>
</div>
</div>

<br>
<div>
<p class="footdash">Application created by The Hashemi Lab, Imperial College London.</p>
</div>
</div>
<script>
//Buttons callbacks.
$(document).on("click", '.type_of_plot_selection', function(){
$('.type_of_plot_selection').css('background-color','');
$('.type_of_plot_selection').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
plot_type = this.id;
fscv_data.change_type_of_plot(plot_type, "main_graph");
});

$(document).on("click", '.color_palette_selection', function(){
$('.color_palette_selection').css('background-color','');
$('.color_palette_selection').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
color_palette = this.id;
fscv_data.change_color_palette(color_palette, "main_graph");
});

$(document).on("click", '.graph_point_selection', function(){
if ($(this).css("background-color") == 'rgb(63, 81, 181)'){
$(this).css('background-color','');
$(this).css('color','');
} else{
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
};
_("graph_selection_checkbox").checked = !_("graph_selection_checkbox").checked;
});

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
$("#slider_label").html(loaded_data.names_of_files[file_index-1]+" ("+file_index+"/"+ _('file_slider').max+")");
fscv_data = new HL_FSCV_DATA(loaded_data.data_array[file_index-1],_('current_units').value, _('frequency').value,
_('cycling_frequency').value, loaded_data.names_of_files[file_index-1], plot_type, color_palette);
fscv_data.graph_color_plot("main_graph");
};

function include_pushed(){
// Determine number of files.
_('file_slider').max = loaded_data.number_of_files;
slider_changed();
};

function invert_pushed(){
fscv_data.invert_current_values("main_graph");
};

function reset_pushed(){
location.reload();
};
function main_graph_clicked(evtObj){
if(_('graph_selection_checkbox').checked && evtObj.points.length != 0) {
// Get index of clicked point.
let pindex = evtObj.points[0].pointNumber;
// Assign clicked point to the data object.
//fscv_data.add_selected_transient(pindex, "transient_graph", "iv_graph");
}
};

</script>
<script>
// Create loaded data object and declare varibles used in the dashboard.
var loaded_data = new HL_LOAD_DATA("status");
var file_index = 1;
var plot_type = 'surface';
var color_palette = 'Custom';
var fscv_data;
// Assign callback to read the data from the input.
_("FSCVfiles").addEventListener('change', loaded_data.read_files);
// Initialise blank plot on main graph, transient graph and iV graph.
Plotly.plot("main_graph");
Plotly.plot("transient_graph");
Plotly.plot("iv_graph");
</script>

</body>
</html>
