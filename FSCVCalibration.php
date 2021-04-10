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
<script src="JavaScriptPackages/kiss_fft.js"></script>
<script src="JavaScriptPackages/tf.min.js"></script>
<script src="JavaScriptPackages/xlsx.full.min.js"></script>
<script src = "OOP/HLClasses.js"></script>
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
<input type="file" name="FSCVfiles" id="FSCVfiles" accept=".xls,.xlsx,.csv,.txt" style="width:75%;"  multiple data-toggle="tooltip" title="Add files to the application from a local path"> </input>
<button id="include_button" onclick="include_pushed()" style="width: 25%;" data-toggle="tooltip" title="Include loaded files into the application">Include</button>
</div>
<div class="row">
<p id="status"> Upload the files.</p>
</div>
<div class="row">
<label for="frequency" style="width: 33%;">Freq. (Hz):</label>
<label for="cycling_frequency" style="width: 33%;">Cyc freq. (Hz):</label>
<label for="current_units" style="width: 33%;">Units:</label>
<input type="number" step="1" min=1 name="frequency" id="frequency" style="width: 33%;"  value=500000 data-toggle="tooltip" title="Sampling frequency of the acquisition" />
<input type="number" step="1" min=1 name="cycling_frequency" id="cycling_frequency" style="width: 33%;" value=10 data-toggle="tooltip" title="Frequency at which the voltage cycle is applied"/>
<input type="text" name="current_units" id="current_units" style="width: 33%;" value="nA" data-toggle="tooltip" title="Current units of uploaded data"/>
</div>
</div>

<div class="col-6">
<div style = "text-align: center">
<label id="slider_label" for="plot_slider" ></label>
</div>
<div style = "text-align: center">
<button id="previous_button" onclick="previous_pushed()" data-toggle="tooltip" title="Change to previous file">< Prev.</button>
<input type="range" class="custom-range w-25" id="file_slider" min="1" max="1" value="1" step = "1" onchange="slider_changed()">
<button id="next_button" onclick="next_pushed()" data-toggle="tooltip" title="Change to next file">Next ></button>
</div>
<div style = "text-align: center; margin-top:10px">
<img src="/Images/HL_Icon.png" alt="Hashemi Lab Icon" width="375" height="125">
</div>
</div>

<div class="col">
<div class="row">
<button id="invert_sign_button" onclick="invert_pushed()" data-toggle="tooltip" title="Invert the sign of the current values in the voltammograms">Invert</button>
&nbsp;
<button id="invert_sign_button" onclick="background_subtraction_button_pushed()" data-toggle="tooltip" title="Background subtraction of capacitative current">Back. sub.</button>
&nbsp;
<button onclick="snr_button_pushed()" data-toggle="tooltip" title="Open signal-to-noise ratio window.">SNR</button>
&nbsp;
<button id="reset_button" onclick="reset_pushed()"  data-toggle="tooltip" title="Reset the application">Reset</button>
</div>
<div class="row" style="margin-top:5px">
<button id="surface" class="type_of_plot_selection" data-toggle="tooltip" title="Type of graph: 3D surface">3D</button>
&nbsp;
<button id="heatmap" class="type_of_plot_selection" style="background-color:#3f51b5; color:white;" data-toggle="tooltip" title="Type of graph: 2D heatmap">2D</button>
&nbsp;
<button id="contour" class="type_of_plot_selection" data-toggle="tooltip" title="Type of graph: contour plot">Contour</button>
&nbsp;
<select id="color_selection_button" style="float: right;" onchange="color_palette_changed()" data-toggle="tooltip" title="Select the color palette used for the color plot.">
<option value="Custom">Custom</option>
<option value="Parula">Parula</option>
<option value="Jet">Jet</option>
<option value="Hot">Hot</option>
<option value="YlOrRd">YlOrRd</option>
<option value="YlGnBu">YlGnBu</option>
<option value="RdBu">RdBu</option>
<option value="Picnic">Picnic</option>
<option value="Greys">Greys</option>
<option value="Greens">Greens</option>
<option value="Electric">Electric</option>
<option value="Earth">Earth</option>
<option value="Bluered">Bluered</option>
<option value="Blackbody">Blackbody</option>
</select>
</div>

<div class="row" style="margin-top:5px">
<button id="graph_point_selection" class="graph_point_selection" data-toggle="tooltip" title="Select horizontal traces from the color plot &#x0a; by interactively clicking on the graph">
Graph selection<input type="checkbox" hidden id="graph_selection_checkbox"></button>
&nbsp;
<button id="kinetic_calibration_button" onclick="kinetic_calibration_button_pushed()" disabled  data-toggle="tooltip" title="Calibration of color plot accounting for mass diffusivity">Kinetic calibration</button>
</div>
<div class="row" style="margin-top:5px">
<button id="graph_configuration" data-toggle="tooltip" title="Open graph configuration panel." onclick="open_graph_configuration_window()">Graph config.</button>
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
<h5>Export Panel</h5>
<hr>
<button id="filtered_download_button" class="download_type_button" style="background-color:#3f51b5; color:white;"  data-toggle="tooltip" title="Export filtered color plots">Color plot</button>
<button id="calibration_download_button" class="download_type_button" data-toggle="tooltip" title="Export calibrated data" >Calibration</button>
<button style="margin-top:5px;" onclick="export_pushed()" style="float:right;" data-toggle="tooltip" title="Download selected data as XLSX">Export</button>
<select id="export_format" style="float: right;" data-toggle="tooltip" title="Select format to export color plot. Calibrations are always exported to XLSX.">
<option value="txt">TXT</option>
<option value="xlsx">XLSX</option>
</select>
<hr>
<button style="margin-top:5px;" onclick="open_kinetic_analysis_pushed()" data-toggle="tooltip" title="Open Michaelis Menten application with the selected trace obtained from the calibrations" >Open Reuptake Analysis</button>
<select id="kinetic_select_type_button" style="float: right;" data-toggle="tooltip" title="Select concentration trace to open kinetic analysis">
<option value="one_reuptake">One reuptake</option>
<option value="two_reuptakes">Two reuptakes</option>
</select>
<select id="kinetic_select_signal_button" style="float: right;" data-toggle="tooltip" title="Select concentration trace to open kinetic analysis">
<option value="average">Average</option>
</select>
</div>

<div class="col"> <div class="position:relative">
<h5>
Filtering Panel
<button class="filter_selection text-right" id="2dfft_button" style="font-size:16px;float:right;" data-toggle="tooltip" title="Fourier transform Butterworth 2D low-pass filtering">2D FFT</button>
<button class="filter_selection text-right" id="convolution_button" style="background-color:#3f51b5; color:white; font-size:16px; float:right;" data-toggle="tooltip" title="2D convolution smoothing">Conv.</button>
</h5>
<hr>
<button onclick="apply_filtration_pushed()" data-toggle="tooltip" title="Apply selected filtration to the signal">Filter</button>
<button onclick="apply_changes_pushed()" style="float:right;" data-toggle="tooltip" title="Apply filtration changes to the stored signal. &#x0a;Use to save the filtration.">Apply changes</button>

<div id="convolution_panel" style="margin-top:5px;">
<label  for="convolution_sigma" style="width:49%">Gaussian STD (px):</label>
<label for="convolution_repetitions" style="width:49%">Repetitions:</label>
<input style="width:49%" type="number" step="1" min=1 name="convolution_sigma" id="convolution_sigma" value=1   data-toggle="tooltip" title="Standard deviation of the Gaussian smoothing kernel.&#x0a;Higher STD will increase the smoothing strength." />
<input style="width:49%" type="number" step="1" min=1 name="convolution_repetitions" id="convolution_repetitions" value=1 max=5 data-toggle="tooltip" title="Number of times the convolution is applied"/>
</div>
<div id="2dfft_panel" style="display: none; margin-top:5px;">
<label for="horizontal_fft_slider" style="width:35%"> X cutoff (%):</label>
<input type="range" step="1" id="horizontal_fft_slider" style="width:25%" value=50 min=1 max=100 data-toggle="tooltip" title="Horizontal cutoff frequency defined as a percentage of the maximum frequency."/>
<span id="horizontal_fft_slider_number" style="width:40%">50</span>
<button onclick="config_2dfft_pushed()" style="float: right;" data-toggle="tooltip" title="Open configuration of the 2D-FFT low-pass filtering.">Config.</button>
<label for="vertical_fft_slider" style="width:35%"> Y cutoff (%):</label>
<input type="range" step="1" id="vertical_fft_slider" style="width:25%" value=50 min=1 max=100 data-toggle="tooltip" title="Vertical cutoff frequency defined as a percentage of the maximum frequency." />
<span id="vertical_fft_slider_number" style="width:40%">50</span>
<button onclick="graph_2dfft_pushed()" style="float: right;" data-toggle="tooltip" title="Graph the magnitude of the 2D FFT spectrum">Show</button>
<label for="butter_order" style="width:35%"> Order:</label>
<input type="number" step="1" id="butter_order" style="width:25%" value=2 min=1 max=20 data-toggle="tooltip" title="Order of the 2D Butterworth filter"/>
<button onclick="graph_filter_pushed()" id="show_filter_button" style="float: right;" disabled data-toggle="tooltip" title="Graph the cutoff limits of the filter.">Show filter</button>
</div>

</div> </div>
<div class="col">
<h5>Calibration Panel</h5>
<hr>
<label for="calibration_coefficient" style="width:35%"> Coefficient:</label>
<input type="number" step="1" id="calibration_coefficient" style="width:25%" value=11 min=1 max=100 data-toggle="tooltip" title="Calibration coefficient of the neurotransmitter." />
<button onclick="calibrate_button_pushed()" id="calibrate_button" style="float: right;" data-toggle="tooltip" title="Calibrate the selected trace">Calibrate</button>
<label for="concentration_units" style="width:35%"> Units:</label>
<input type="text" step="1" id="concentration_units" style="width:25%" value="nM" data-toggle="tooltip" title="Concentration units of the calibration coefficient"/>
<button onclick="nonlinear_fit_button_pushed()" id="calibrate_button" style="float: right;" data-toggle="tooltip" title="Improve exponential fit applying nonlinear optimization">Nonlinear opt.</button>
<label for="calibration_name" style="width:35%"> Name:</label>
<input type="text" step="1" id="calibration_name" style="width:25%" value="5-HT" data-toggle="tooltip" title="Name of the calibration"/>
<select id="select_signal_button" style="float: right;" data-toggle="tooltip" title="Select current trace to calibrate">
</select>
</div>
</div>
</div>

<br>

<div class = "center" style = " margin:auto; width:90%;height:500px">
<div class = "center" style = "float:left; width:50%;">
<div id="transient_graph" class = "center"></div>
<div id="iv_graph" class = "center"></div>
</div>
<div class = "center" style = "float:right; width:50%;">
<div id="ct_graph" class = "center"></div>
</div>

<div style="position:absolute;left:25%;margin-top:2.5%">
<button class="current_trace_selection" id="i-t_button" style="font-size:12px;background-color:#3f51b5; color:white;" data-toggle="tooltip" title="Show horizontal current traces">1</button>
<button class="current_trace_selection" id="i-v_button" style="font-size:12px" data-toggle="tooltip" title="Show vertical current traces">2</button>
</div>

<div style="position:absolute;left:35%;margin-top:2.5%">
<button style="font-size:12px" onclick="delete_trace_pushed()" data-toggle="tooltip" title="Delete last current trace">Delete last</button>
<button style="font-size:12px" onclick="delete_all_pushed()" data-toggle="tooltip" title="Delete all current traces">Delete all</button>
</div>

<div style="position:absolute;left:65%;margin-top:2.5%">
<button class="max_min_selection" id="max_button" style="font-size:12px;background-color:#3f51b5; color:white;"  data-toggle="tooltip" title="Toggle to select the maximum point in the graph">Max</button>
<button class="max_min_selection" id="min_button" style="font-size:12px" data-toggle="tooltip" title="Toggle to select the minimum point in the graph">Min</button>
</div>

<div style="position:absolute;left:75%;margin-top:2.5%">
<button style="font-size:12px" onclick="previous_concentration_clicked()" data-toggle="tooltip" title="Graph previous concentration trace"> < </button>
<button style="font-size:12px" onclick="next_concentration_clicked()" data-toggle="tooltip" title="Graph next concentration trace"> > </button>
</div>

<div style="position:absolute;left:80%;margin-top:2.5%">
<button style="font-size:12px" onclick="delete_concentration_trace_pushed()" data-toggle="tooltip" title="Delete last calibration">Delete last</button>
<button style="font-size:12px" onclick="delete_all_concentration_pushed()" data-toggle="tooltip" title="Delete all calibrations">Delete all</button>
</div>
</div>
<div>
<p class="footdash">Application created by The Hashemi Lab, Imperial College London & University of South Carolina.</p>
</div>
</div>

<div id="kinetic_calibration_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<div class = "col">
<label for="valency_of_reaction" style="width:59%">Valency (e<sup>-</sup>):</label>
<input style="width:30%" type="number" step="1" min=1 max=10 id="valency_of_reaction" value=2 data-toggle="tooltip" title="Number of electrons of the faradaic reaction"/>
<label for="electrode_length" style="width:59%">Electrode length (μm):</label>
<input style="width:30%" type="number" step="1" min=1 id="electrode_length" onchange="calculate_surface()" value=150 data-toggle="tooltip" title="Electrode length to calculate electrode surface"/>
<label for="electrode_width" style="width:59%">Electrode width (μm):</label>
<input style="width:30%" type="number" step="1" min=1 id="electrode_width" onchange="calculate_surface()" value=7 data-toggle="tooltip" title="Electrode width to calculate electrode surface"/>
<label for="electrode_surface" style="width:59%">Electrode surface (μm<sup>2</sup>):</label>
<input style="width:30%" type="number" min=1 step=1 value=3337.16 id="electrode_surface" data-toggle="tooltip" title="Electrode surface">

</div>
<div class = "col">
<label for="absorption_strength" style="width:59%">Absorption (cm):</label>
<input style="width:30%" type="number" step="1" min=0 id="absorption_strength" value=0.0055 data-toggle="tooltip" title="Electrode absorption strength "/>
<label for="diffusion_coefficient" style="width:59%">Diffusion coef. (cm<sup>2</sup>/s):</label>
<input style="width:30%" type="number" step="1" min=0 id="diffusion_coefficient" value=0.000002 data-toggle="tooltip" title="Diffusion coefficient of the neurotransmitter"/>
<label for="kinetic_calibration_name" style="width:59%">Name:</label>
<input style="width:30%" type="text" id="kinetic_calibration_name" value="5-HT" data-toggle="tooltip" title="Name of the calibration"/>

</div>
</div>
<div class="row">
<div class="col">
<label for="kinetic_start_integration" style="width:59%">Start (samples): </label>
<input style="width:30%" type="number" id="kinetic_start_integration" value=0 data-toggle="tooltip" title="Cyclic voltammgram sample from where the integration starts "/>
</div>
<div class="col">
<label for="kinetic_end_integration" style="width:59%">End (samples): </label>
<input style="width:30%" type="number" id="kinetic_end_integration" value=3000 data-toggle="tooltip" title="Cyclic voltammgram sample from where the integration ends " />
</div>
</div>
<br>
<p style="text-align:center">
<button style="width:15%;" onclick="kinetic_calibration_pushed()" data-toggle="tooltip" title="Apply kinetic calibration.">Calibrate</button>
<button style="width:20%;" onclick="kinetic_show_limits_pushed()" data-toggle="tooltip" title="Show integration limits in the graph.">Show limits</button>
<button style="width:15%;" onclick="kinetic_calibration_close_pushed()" data-toggle="tooltip" title="Close window.">Close</button>
</p>
</div>
</div>

<div id="background_subtraction_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<div class="col">
<label for="background_start_sample" style="width:59%">Start (samples): </label>
<input style="width:30%" type="number" id="background_start_sample" value=0 data-toggle="tooltip" title="First cyclic voltammogram from where the average is calculated "/>
</div>
<div class="col">
<label for="background_end_sample" style="width:59%">End (samples): </label>
<input style="width:30%" type="number" id="background_end_sample" value=10 data-toggle="tooltip" title="Last cyclic voltammogram from where the average is calculated "/>
</div>
</div>
<br>
<p style="text-align:center">
<button style="width:15%;" onclick="background_subtraction_apply_pushed()" data-toggle="tooltip" title="Apply background subtraction">Apply</button>
<button style="width:20%;" onclick="background_subtraction_show_pushed()" data-toggle="tooltip" title="Show limits of background subtraction in the graph">Show</button>
<button style="width:15%;" onclick="background_subtraction_close_pushed()" data-toggle="tooltip" title="Close window">Close</button>
</p>
</div>
</div>

<div id="snr_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<div class="col">
<label for="snr_start_sample" style="width:59%">Start (samples): </label>
<input style="width:30%" type="number" id="snr_start_sample" value=0 data-toggle="tooltip" title="First cyclic voltammogram from where noise is estimated. "/>
</div>
<div class="col">
<label for="snr_end_sample" style="width:59%">End (samples): </label>
<input style="width:30%" type="number" id="snr_end_sample" value=10 data-toggle="tooltip" title="Last cyclic voltammogram from where the noise is estimated. "/>
</div>
</div>
<div class = "row">
<div class="col">
<p style="text-align:center">SNR: <span id="snr_value"></span></p>
</div>
</div>
<br>
<p style="text-align:center">
<button style="width:15%;" onclick="calculate_snr_button_pushed()" data-toggle="tooltip" title="Close window.">Calculate</button>
<button style="width:15%;" onclick="snr_close_button_pushed()" data-toggle="tooltip" title="Close window.">Close</button>
</p>
</div>
</div>

<div id="2dfft_config_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<div class="col">
<label for="2dfft_height_padding" style="width:59%">Height pad. (ratio): </label>
<input style="width:30%" type="number" id="2dfft_height_padding" value=0.20 min=0 max=1 data-toggle="tooltip" title="Ratio of padding respect to total height before filtering. "/>
</div>
<div class="col">
<label for="2dfft_width_padding" style="width:59%">Width pad. (ratio): </label>
<input style="width:30%" type="number" id="2dfft_width_padding" value=0.20 min=0 max=1 data-toggle="tooltip" title="Ratio of padding respect to total width before filtering. "/>
</div>
</div>
<div class = "row">
</div>
<br>
<p style="text-align:center">
<button style="width:15%;" onclick="config_2dfft_close_pushed()" data-toggle="tooltip" title="Close window.">Close</button>
</p>
</div>
</div>

<div id="graph_configuration_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<div class="col">
<label for="graph_min_color" style="width:24%">Max colorbar: </label>
<input style="width:24%" type="number" id="max_colour_value" data-toggle="tooltip" title="Minimum current value in the color plot"/>
<label for="graph_max_color" style="width:25%">Min colorbar: </label>
<input style="width:24%" type="number" id="min_colour_value" data-toggle="tooltip" title="Maximum current value in the color plot"/>
<br>
<p style="text-align:center">
<button style="width:15%;" onclick="apply_graph_configuration_changes()" data-toggle="tooltip" title="Apply changes.">Apply</button>
<button style="width:15%;" onclick="close_graph_configuration_window()" data-toggle="tooltip" title="Close window.">Close</button>
</p>
</div>
</div>
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



function color_palette_changed(){
color_palette = _('color_selection_button').value;
fscv_data.change_color_palette(color_palette, "main_graph");
};

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

$(document).on("click", '.current_trace_selection', function(){
$('.current_trace_selection').css('background-color','');
$('.current_trace_selection').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
if (this.id == "i-t_button"){$('#transient_graph').show(); $('#iv_graph').hide()}
else{$('#transient_graph').hide(); $('#iv_graph').show()};
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
fscv_data = new HL_FSCV_DATA(loaded_data.data_array[file_index-1],_('current_units').value, parseFloat(_('frequency').value),
parseFloat(_('cycling_frequency').value), loaded_data.names_of_files[file_index-1], plot_type, color_palette);
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
fscv_data = new HL_FSCV_DATA(loaded_data.data_array[file_index-1],_('current_units').value, parseFloat(_('frequency').value),
parseFloat(_('cycling_frequency').value), loaded_data.names_of_files[file_index-1], plot_type, color_palette);
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
fscv_transient.add_trace(fscv_data.current.array[pindex[0]], parseFloat(_('cycling_frequency').value), "transient_graph", fscv_data.name_of_file);
fscv_iv.add_trace(arrayColumn(fscv_data.current.array, pindex[1]), parseFloat(_('frequency').value), "iv_graph", fscv_data.name_of_file);
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
//Convolution filtering.
fscv_filtering.apply_convolution(fscv_data, parseFloat(_('convolution_sigma').value), parseInt(_('convolution_repetitions').value));
} else {
fscv_filtering.apply_2dfft_filtration(fscv_data, "main_graph",  parseFloat(_('frequency').value), parseFloat(_('cycling_frequency').value),
parseInt(_('horizontal_fft_slider').value), parseInt(_('vertical_fft_slider').value), parseInt(_('butter_order').value),
parseFloat(_('2dfft_height_padding').value), parseFloat(_('2dfft_width_padding').value));
_("show_filter_button").disabled = true;
};
fscv_data.graph_color_plot("main_graph");
};
function graph_2dfft_pushed(){
_("show_filter_button").disabled = false;
fscv_filtering.get_2dfft(fscv_data, "main_graph", parseFloat(_('frequency').value), parseFloat(_('cycling_frequency').value), parseFloat(_('2dfft_height_padding').value), parseFloat(_('2dfft_width_padding').value));
};
function graph_filter_pushed(){
fscv_filtering.graph_filter("main_graph", parseInt(_('horizontal_fft_slider').value),parseInt(_('vertical_fft_slider').value));
};
function apply_changes_pushed(){
loaded_data.data_array[file_index-1] = fscv_data.current.array;
}
function calibrate_button_pushed(){
if( _('select_signal_button').value != ""){
$('#kinetic_select_signal_button').append($('<option>', {value:fscv_concentration.counter, text:_('calibration_name').value+'('+String(fscv_concentration.counter+1)+')'}));
fscv_concentration.calibrate_trace("ct_graph", _('select_signal_button').value, fscv_transient, parseFloat(_('cycling_frequency').value),
parseFloat(_('calibration_coefficient').value), _('concentration_units').value, _('calibration_name').value);
};
};
function previous_concentration_clicked(){
if(fscv_concentration.graph_index !== 0){--fscv_concentration.graph_index; fscv_concentration.plot_graph("ct_graph")};
};
function next_concentration_clicked(){
if(fscv_concentration.graph_index < fscv_concentration.counter - 1){++fscv_concentration.graph_index; fscv_concentration.plot_graph("ct_graph")};
};
function delete_concentration_trace_pushed(){
fscv_concentration.remove_trace("ct_graph");
$('#kinetic_select_signal_button').find('[value='+fscv_concentration.counter+']').remove();
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
fscv_concentration.change_max_and_min_values("ct_graph", pindex, type, parseFloat(_('cycling_frequency').value));
}};

function background_subtraction_button_pushed(){
_('background_subtraction_modal_window').style.display = "block";
};
function background_subtraction_close_pushed(){
_('background_subtraction_modal_window').style.display = "none";
}

function background_subtraction_show_pushed(){
if (plot_type == 'surface'){fscv_data.change_type_of_plot("heatmap", "main_graph")};
fscv_data.show_limits("main_graph", 0, fscv_data.time.array.length, parseFloat(_('background_start_sample').value/_('cycling_frequency').value),
parseFloat(_('background_end_sample').value/_('cycling_frequency').value));
};

function background_subtraction_apply_pushed(){
fscv_data = new HL_FSCV_DATA(loaded_data.data_array[file_index-1],_('current_units').value, parseFloat(_('frequency').value),
parseFloat(_('cycling_frequency').value), loaded_data.names_of_files[file_index-1], plot_type, color_palette);
fscv_data.background_subtraction("main_graph", parseInt(_('background_start_sample').value), parseInt(_('background_end_sample').value));
};

function nonlinear_fit_button_pushed(){
fscv_concentration.get_nonlinear_exponential_fit();
fscv_concentration.plot_graph("ct_graph");
}

function kinetic_calibration_button_pushed(){
_('kinetic_calibration_modal_window').style.display = "block";
};

function kinetic_calibration_close_pushed(){
_('kinetic_calibration_modal_window').style.display = "none";
};

function snr_button_pushed(){
_('snr_modal_window').style.display = "block";
};

function snr_close_button_pushed(){
_('snr_modal_window').style.display = "none";
};

function config_2dfft_pushed(){
_('2dfft_config_modal_window').style.display = "block";
};

function config_2dfft_close_pushed(){
_('2dfft_config_modal_window').style.display = "none";
};


function calculate_snr_button_pushed(){
fscv_data.get_snr(parseInt(_('snr_start_sample').value), parseInt(_('snr_end_sample').value), 'snr_value');
};

function kinetic_show_limits_pushed(){
if (plot_type == 'surface'){fscv_data.change_type_of_plot("heatmap", "main_graph")};
fscv_data.show_limits("main_graph", parseInt(_("kinetic_start_integration").value), parseInt(_("kinetic_end_integration").value),
fscv_data.cycling_time.array[0], fscv_data.cycling_time.array[fscv_data.cycling_time.array.length-1]);
};

function kinetic_calibration_pushed(){
fscv_concentration.kinetic_calibrate_trace("ct_graph", fscv_data, parseFloat(_('frequency').value), parseFloat(_('cycling_frequency').value),
parseInt(_('kinetic_start_integration').value),_('kinetic_end_integration').value, _('concentration_units').value, _('kinetic_calibration_name').value,
parseFloat(_('diffusion_coefficient').value), parseFloat(_('absorption_strength').value), parseFloat(_('electrode_surface').value), parseInt(_('valency_of_reaction').value));
}

function open_kinetic_analysis_pushed(){
fscv_concentration.calculate_average_trace();
let input_trace = new HL_FSCV_ARRAY(), time_array, type;
if (_('kinetic_select_type_button').value == 'one_reuptake'){type = 'FSCVMichaelisMenten1.php'}
else{type = 'FSCVMichaelisMenten2.php'};
var mm_window = window.open(encodeURI(type), "");
if (_('kinetic_select_signal_button').value == 'average'){input_trace = fscv_concentration.average_concentration, time_array = fscv_concentration.time.array[0]}
else {
input_trace.array = fscv_concentration.concentration.array[_('kinetic_select_signal_button').value];
input_trace.units = fscv_concentration.concentration.units[_('kinetic_select_signal_button').value];
input_trace.name = fscv_concentration.concentration.name; time_array = fscv_concentration.time.array[_('kinetic_select_signal_button').value];
};
mm_window.input_trace = input_trace;
mm_window.time_array = time_array;
};

function calculate_surface(){
var h = parseFloat(_("electrode_length").value);
var d = parseFloat(_("electrode_width").value);
if (h>0 && d>0) {
var surface= Math.PI*Math.pow(d/2, 2)+2*Math.PI*(d/2)*h;
surface = surface.toFixed(2);
_('electrode_surface').value = surface;
}};

function export_pushed(){
if (getComputedStyle(_("calibration_download_button"))['background-color'] == 'rgb(63, 81, 181)'){fscv_concentration.export_calibration()}
else{fscv_data.export_data(_('export_format').value)};
};

function open_graph_configuration_window(){
_('graph_configuration_modal_window').style.display = "block";
};

function close_graph_configuration_window(){
_('graph_configuration_modal_window').style.display = "none";
};

function apply_graph_configuration_changes(){
fscv_data.change_colorbar_limits("main_graph",parseFloat(_("min_colour_value").value),parseFloat(_("max_colour_value").value));
};

</script>

<script>
// Create loaded data object and declare varibles used in the dashboard.
var loaded_data = new HL_LOAD_DATA("status");
var file_index = 1;
var plot_type = 'heatmap';
var color_palette = 'Custom';
//Initialise blank data objects.
var fscv_data = new HL_FSCV_DATA([[0]], _('current_units').value, parseFloat(_('frequency').value),
parseFloat(_('cycling_frequency').value), 'Blank', plot_type, color_palette);
var fscv_transient = new HL_FSCV_1D_DATA(_('current_units').value, parseFloat(_('cycling_frequency').value), "i-t Curve");
var fscv_iv = new HL_FSCV_1D_DATA(_('current_units').value, parseFloat(_('frequency').value), "i-V Curve");
var fscv_concentration = new HL_FSCV_CONCENTRATION(_('concentration_units').value);
var fscv_filtering = new HL_FILTERING(_('current_units').value);
// Assign callback to read the data from the input.
_("FSCVfiles").addEventListener('change', loaded_data.read_files);
// Initialise blank plot on main graph, transient graph, iV graph and concentration.
fscv_data.initialise_graph("main_graph");
fscv_transient.initialise_graph("transient_graph");
fscv_iv.initialise_graph("iv_graph");
fscv_concentration.initialise_graph("ct_graph");
// Hide iv_graph
_('iv_graph').style.display="none";
</script>

</body>
</html>
