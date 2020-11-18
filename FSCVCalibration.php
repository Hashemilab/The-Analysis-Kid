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
<script src="JavaScriptPackages/kissFFT.js"></script>
<script src="JavaScriptPackages/tf.min.js"></script>
<script src="JavaScriptPackages/xlsx.full.min.js"></script>
<script src = "OOP/FSCVClasses.js"></script>
<script src = "OOP/LOADClass.js"></script>
<script src = "OOP/FilterClass.js"></script>
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
<div style = "margin:auto; width: 90%;">
<div class="row" style="margin:auto;">
<div class="col">
<div class="row">
<input type="file" name="FSCVfiles" id="FSCVfiles" accept=".xls,.xlsx,.csv,.txt" style="width:75%;"  multiple> </input>
<button>
<a id="include_button" onclick="include_pushed()" style="width: 25%;">Include</a>
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
<a id="previous_button" onclick="previous_pushed()" >< Prev.</a>
</button>
<input type="range" class="custom-range w-25" id="file_slider" min="1" max="1" value="1" step = "1" onchange="slider_changed()">
<button>
<a id="next_button" onclick="next_pushed()">Next ></a>
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
<div id="middle_panel" style = " margin:auto; width:90%;">
<div class="row">
<div class="col">
<button id="filtered_download_button" class="download_type_button" style="background-color:#3f51b5; color:white;">Filtered data</button>
<button id="calibration_download_button" class="download_type_button">Calibration</button>
<br>
<button style="margin-top:5px;" onclick="export_as_xlsx_pushed()">Export as XLSX</button>
</div>
<div class="col">
<div class="row">
<button class="filter_selection" id="convolution_button" style="background-color:#3f51b5; color:white;">Conv.</button>
&nbsp;
<button class="filter_selection" id="2dfft_button">2D FFT</button>
&nbsp;
<button onclick="apply_filtration_pushed()">Filter</button>
<button onclick="apply_changes_pushed()" style="margin-right:0px; margin-left:auto;">Apply changes</button>
</div>
<div class="row">
<div id="convolution_panel" style="margin-top:5px;">
<label  for="convolution_sigma" style="width:49%">Gaussian STD (px):</label>
<label for="convolution_repetitions" style="width:49%">Repetitions:</label>
<input style="width:49%" type="number" step="1" min=1 name="convolution_sigma" id="convolution_sigma" value=1 />
<input style="width:49%" type="number" step="1" min=1 name="convolution_repetitions" id="convolution_repetitions" value=1 max=5 />
</div>
<div id="2dfft_panel" style="display: none; margin-top:5px;">
<label for="horizontal_fft_slider" style="width:35%"> X cutoff (%):</label>
<input type="range" step="1" id="horizontal_fft_slider" style="width:25%" value=50 min=1 max=100 />
<span id="horizontal_fft_slider_number" style="width:40%">50</span>
<label for="vertical_fft_slider" style="width:35%"> Y cutoff (%):</label>
<input type="range" step="1" id="vertical_fft_slider" style="width:25%" value=50 min=1 max=100 />
<span id="vertical_fft_slider_number" style="width:40%">50</span>
<button onclick="graph_2dfft_pushed()" style="float: right;">Show</button>
<label for="butter_order" style="width:35%"> Order:</label>
<input type="number" step="1" id="butter_order" style="width:25%" value=2 min=1 max=20 />
<button onclick="graph_filter_pushed()" id="show_filter_button" style="float: right;" disabled>Show filter</button>
</div>
</div>
</div>
<div class="col">
<label for="calibration_coefficient" style="width:35%"> Coefficient:</label>
<input type="number" step="1" id="calibration_coefficient" style="width:25%" value=11 min=1 max=100 />
<button onclick="calibrate_button_pushed()" id="calibrate_button" style="float: right;">Calibrate</button>
<label for="concentration_units" style="width:35%"> Units:</label>
<input type="text" step="1" id="concentration_units" style="width:25%" value="nM"/>
<button onclick="nonlinear_fit_button_pushed()" id="calibrate_button" style="float: right;">Nonlinear opt.</button>
<label for="calibration_name" style="width:35%"> Name:</label>
<input type="text" step="1" id="calibration_name" style="width:25%" value="5-HT"/>
<select id="select_signal_button" style="float: right;">
</select>
</div>
</div>
</div>

<br>

<div class = "center" style = " margin:auto; width:90%;height:500px">
<div class = "center" style = "float:left; width:50%;">
<div id="transient_graph" class = "center"></div>
</div>
<div class = "center" style = "float:right; width:50%;">
<div id="ct_graph" class = "center"></div>
</div>

<div style="position:absolute;left:35%;margin-top:2.5%">
<button style="font-size:12px" onclick="delete_trace_pushed()">Delete last</button>
<button style="font-size:12px" onclick="delete_all_pushed()">Delete all</button>
</div>

<div style="position:absolute;left:65%;margin-top:2.5%">
<button class="max_min_selection" id="max_button" style="font-size:12px;background-color:#3f51b5; color:white;">Max</button>
<button class="max_min_selection" id="min_button" style="font-size:12px">Min</button>
</div>

<div style="position:absolute;left:75%;margin-top:2.5%">
<button style="font-size:12px" onclick="previous_concentration_clicked()"> < </button>
<button style="font-size:12px" onclick="next_concentration_clicked()"> > </button>
</div>

<div style="position:absolute;left:80%;margin-top:2.5%">
<button style="font-size:12px" onclick="delete_concentration_trace_pushed()">Delete last</button>
<button style="font-size:12px" onclick="delete_all_concentration_pushed()">Delete all</button>
</div>
</div>


<div class = "center" style = " margin:auto; width:90%;height:500px">
<div class = "center" style = "float:left; width:50%;">
<div id="iv_graph" class = "center"></div>
</div>
<div class = "center" style = "float:right; width:50%;">
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

$(document).on("click", '.filter_selection', function(){
$('.filter_selection').css('background-color','');
$('.filter_selection').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
if (this.id == "convolution_button"){$('#convolution_panel').show(); $('#2dfft_panel').hide();}
else{$('#convolution_panel').hide(); $('#2dfft_panel').show();};
});

$(document).on("click", '.max_min_selection', function(){
$('.max_min_selection').css('background-color','');
$('.max_min_selection').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
});

$('#FFTselect').click(function() {
$('#CONVDiv').hide()
$('#FFTDiv').show()
});
$('#CONselect').click(function() {
$('#FFTDiv').hide()
$('#CONVDiv').show()
});

$('#vertical_fft_slider').on('input', function(){_("vertical_fft_slider_number").innerHTML = this.value});
$('#horizontal_fft_slider').on('input', function(){_("horizontal_fft_slider_number").innerHTML = this.value});

$(document).on("click", '.download_type_button', function(){
$('.download_type_button').css('background-color','');
$('.download_type_button').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
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
//Plot the main graph.
fscv_data.graph_color_plot("main_graph");
fscv_filtering = new HL_FILTERING(_('current_units').value);
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
fscv_transient.add_trace(fscv_data.current.array[pindex[0]], _('cycling_frequency').value, "transient_graph", fscv_data.name_of_file);
fscv_iv.add_trace(arrayColumn(fscv_data.current.array, pindex[1]), _('frequency').value, "iv_graph", fscv_data.name_of_file);
$('#select_signal_button').append($('<option>', {value:fscv_transient.counter, text:'Curve '+fscv_transient.legend_array[fscv_transient.counter-1]}));
}};
function delete_trace_pushed(){
$('#select_signal_button').find('[value='+fscv_transient.counter+']').remove();
fscv_transient.remove_trace("transient_graph");
fscv_iv.remove_trace("iv_graph");

};
function delete_all_pushed(){
while(fscv_transient.counter != 0){
delete_trace_pushed();
}};

function apply_filtration_pushed(){
if (getComputedStyle(_("convolution_button"))['background-color'] == 'rgb(63, 81, 181)'){
//Convolution filtration.
fscv_filtering.apply_convolution(fscv_data, _('convolution_sigma').value , _('convolution_repetitions').value);
} else {
fscv_filtering.apply_2dfft_filtration(fscv_data, "main_graph",  _('frequency').value, _('cycling_frequency').value,
_('horizontal_fft_slider').value, _('vertical_fft_slider').value, _('butter_order').value);
_("show_filter_button").disabled = true;
}
fscv_data.graph_color_plot("main_graph");
};
function graph_2dfft_pushed(){
_("show_filter_button").disabled = false;
fscv_filtering.get_2dfft(fscv_data, "main_graph", _('frequency').value, _('cycling_frequency').value);
}
function graph_filter_pushed(){
fscv_filtering.graph_filter("main_graph", _('horizontal_fft_slider').value , _('vertical_fft_slider').value);
};
function apply_changes_pushed(){
loaded_data.data_array[file_index-1] = fscv_data.current.array;
}
function calibrate_button_pushed(){
fscv_concentration.calibrate_trace("ct_graph", _('select_signal_button').value, fscv_transient, _('cycling_frequency').value,
_('calibration_coefficient').value, _('concentration_units').value, _('calibration_name').value);
}
function previous_concentration_clicked(){
if(fscv_concentration.graph_index !== 0){--fscv_concentration.graph_index; fscv_concentration.plot_graph("ct_graph")};
};
function next_concentration_clicked(){
if(fscv_concentration.graph_index < fscv_concentration.counter - 1){++fscv_concentration.graph_index; fscv_concentration.plot_graph("ct_graph")};
};
function delete_concentration_trace_pushed(){
fscv_concentration.remove_trace("ct_graph");
};
function delete_all_concentration_pushed(){
while(fscv_concentration.counter != 0){delete_concentration_trace_pushed()};
};
function concentration_graph_clicked(evtObj){
if(_('graph_selection_checkbox').checked && evtObj.points.length != 0) {
// Get index of clicked point.
let pindex = evtObj.points[0].pointNumber;
let type;
if (getComputedStyle(_("max_button"))['background-color'] == 'rgb(63, 81, 181)'){type = 'max'}
else {type = 'min'};
fscv_concentration.change_max_and_min_values("ct_graph", pindex, type, _('cycling_frequency').value);
}};

function nonlinear_fit_button_pushed(){
fscv_concentration.get_nonlinear_exponential_fit();
fscv_concentration.plot_graph("ct_graph");
}

function export_as_xlsx_pushed(){
if (getComputedStyle(_("calibration_download_button"))['background-color'] == 'rgb(63, 81, 181)'){fscv_concentration.export_calibration()}
else{loaded_data.export_data()};
}
</script>

<script>
// Create loaded data object and declare varibles used in the dashboard.
var loaded_data = new HL_LOAD_DATA("status");
var file_index = 1;
var plot_type = 'surface';
var color_palette = 'Custom';
//Initialise blank data objects.
var fscv_data = new HL_FSCV_DATA([[0]], _('current_units').value, _('frequency').value,
_('cycling_frequency').value, 'Blank', plot_type, color_palette);
var fscv_transient = new HL_FSCV_1D_DATA(_('current_units').value, _('cycling_frequency').value, "i-t Curve");
var fscv_iv = new HL_FSCV_1D_DATA(_('current_units').value, _('frequency').value, "i-V Curve");
var fscv_concentration = new HL_FSCV_CONCENTRATION(_('concentration_units').value);
var fscv_filtering = new HL_FILTERING(_('current_units').value);
// Assign callback to read the data from the input.
_("FSCVfiles").addEventListener('change', loaded_data.read_files);
// Initialise blank plot on main graph, transient graph, iV graph and concentration.
fscv_data.initialise_graph("main_graph");
fscv_transient.initialise_graph("transient_graph");
fscv_iv.initialise_graph("iv_graph");
fscv_concentration.initialise_graph("ct_graph");
</script>

</body>
</html>
