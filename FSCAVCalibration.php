<!DOCTYPE html>
<html lang="en">
<title>FSCAV Calibration</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="JavaScriptPackages/plotly-latest.min.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script src="JavaScriptPackages/DashboardMethods.js"></script>
<script src="JavaScriptPackages/ArrayMethods.js"></script>
<script src="JavaScriptPackages/tf.min.js"></script>
<script src="JavaScriptPackages/xlsx.full.min.js"></script>
<script src = "OOP/HLClasses.js"></script>
<script src = "OOP/FSCAVClass.js"></script>
<script src = "OOP/LOADClass.js"></script>

<head>
<title>FSCAV Calibration</title>
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
<h1>FSCAV Calibration</h1>
</div>
<br>
<div style = "margin:auto; width: 90%;">
<div class="row" style="margin:auto;">
<div class="col-4">
<div class="row">
<button onclick="invert_pushed()" data-toggle="tooltip" title="Invert the sign of the current values in the voltammogram">Invert</button>
&nbsp;
<button id="graph_point_selection" class="graph_point_selection" data-toggle="tooltip" title="Select horizontal traces from the color plot &#x0a; by interactively clicking on the graph">
Graph selection<input type="checkbox" hidden id="graph_selection_checkbox">
</button>
&nbsp;
<button onclick="reset_pushed()" data-toggle="tooltip" title="Reset the application">Reset</button>
&nbsp;
<button onclick="peak_configuration_button_pushed()" data-toggle="tooltip" title="Configuration of peak limits detection and type of model.">Config.</button>
</div>
<div class="row" style="margin-top:5px">
<button class="fit_predict_selection" id="fit_button_selection" style=";background-color:#3f51b5; color:white;" data-toggle="tooltip" title="Switch to fitting panel">Fitting Panel</button>
&nbsp;
<button class="fit_predict_selection" id="predict_button_selection" data-toggle="tooltip" title="Switch to prediction panel">Prediction Panel</button>
</div>
<div id="fitting_panel">
<br>
<h5>Fitting Panel</h5>
<hr>
<div class="row">
<input type="file" id="FSCAVfiles_fit" accept=".xls,.xlsx,.csv,.txt" style="width:70%;"  multiple data-toggle="tooltip" title="Add files to the application from a local path"> </input>
<button id="add_button_fit" onclick="add_pushed_fit()" style="width: 11%;" data-toggle="tooltip" title="Add loaded files into the application">Add</button>
&nbsp;
<button id="finish_button_fit" onclick="finish_pushed_fit()" style="width: 17%;" data-toggle="tooltip" title="Finish loading files and include them into the application">Finish</button>
</div>

<div class="row">
<p id="status_fit"> Upload the files.</p>
</div>

<div class="row">
<label for="frequency" style="width: 24%;">Freq. (Hz):</label>
<label for="current_units" style="width: 24%;">Curr. units:</label>
<label for="concentration_label" style="width: 24%;">Conc.:</label>
<label for="concentration_units" style="width: 24%;">Conc. units:</label>
<input type="number" step="1" min=1 name="frequency" id="frequency" style="width: 24%;"  value=500000 data-toggle="tooltip" title="Sampling frequency of the acquisition" />
<input type="text" id="current_units" style="width: 24%;" value="nA" data-toggle="tooltip" title="Current units of uploaded data"/>
<input type="number"  id="concentration_label" style="width: 24%;" value=10 data-toggle="tooltip" title="Concentration of the uploaded files."/>
<input type="text"  id="concentration_units" style="width: 24%;" value='nM' data-toggle="tooltip" title="Concentration units of uploaded data."/>
</div>
<br>
<div class="row">
<button onclick="fit_button_pushed()" data-toggle="tooltip" title="Fit the signal parameters to the concentration labels.">Fit</button>
</div>
</div>
<div id="prediction_panel" style="display:none">
<br>
<h5>Prediction Panel</h5>
<hr>
<div class="row">
<input type="file" id="FSCAVfiles_predict" accept=".xls,.xlsx,.csv,.txt" style="width:70%;"  multiple data-toggle="tooltip" title="Add files to the application from a local path"> </input>
<button id="add_button_predict" onclick="add_pushed_predict()" style="width: 11%;" data-toggle="tooltip" title="Add loaded files into the application">Add</button>
&nbsp;
<button id="finish_button_predict" onclick="finish_pushed_predict()" style="width: 17%;" data-toggle="tooltip" title="Finish loading files and include them into the application">Finish</button>
</div>
<div class="row">
<p id="status_predict"> Upload the files.</p>
</div>
<div class="row">
<button id="predict_button" onclick="predict_button_pushed()" style="width: 17%;" data-toggle="tooltip" title="Predict concentration from uploaded signals. Notice that the fitting is required to provide predictions.">Predict</button>
</div>
</div>


</div>

<dv class="col-8">
<div class = "center" style = "float:right; width:100%;">
<div id="cv_graph" class = "cv_graph center" style="width:100%; height:80vh;"></div>
<div id="fit_graph" class = "center" style="width:100%; height:80vh;"></div>
</div>
<div style="position:absolute;left:50%;margin-top:2.5%">
<button class="graph_selection" id="cv_graph_button" style="font-size:12px;background-color:#3f51b5; color:white;" data-toggle="tooltip" title="Toggle to show the current traces">1</button>
<button class="graph_selection" id="fit_graph_button" style="font-size:12px" data-toggle="tooltip" title="Toggle to show predicted concentrations">2</button>
</div>

<div class ="cv_graph" style="position:absolute;left:43%;margin-top:2.5%">
<button style="font-size:12px" onclick="previous_cv_clicked()" data-toggle="tooltip" title="Graph previous current trace"> < </button>
<button style="font-size:12px" onclick="next_cv_clicked()" data-toggle="tooltip" title="Graph next current trace"> > </button>
</div>

<div  id = "cv_point_selection" class="cv_graph" style="position:absolute;left:25%;margin-top:2.5%">
<button class="max_min_selection" id="min1" style="font-size:12px;background-color:#3f51b5; color:white;" data-toggle="tooltip" title="Toggle to select the minimum point in the graph">Min 1</button>
<button class="max_min_selection" id="max" style="font-size:12px"  data-toggle="tooltip" title="Toggle to select the maximum point in the graph">Max</button>
<button class="max_min_selection" id="min2" style="font-size:12px" data-toggle="tooltip" title="Toggle to select the minimum point in the graph">Min 2</button>
</div>
</div>


</div>
</div>


<div>
<p class="footdash">Application created by The Hashemi Lab, Imperial College London & University of South Carolina.</p>
</div>
</div>

<div id="peak_configuration_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<div class="col">
<label for="peak_width" style="width:59%">Peak prom. (samples):</label>
<input style="width:30%" type="number" step="1" min=0 id="peak_width" value=20 data-toggle="tooltip" title="Peak prominence: number of neighbour samples &#x0a;considered to assign local minima/maxima "/>
</div>
<div class="col">
<label for="peak_width" style="width:59%">Model type:</label>
<select id="model_type_selection" style="float: right;" data-toggle="tooltip" title="Model used to fit the calibration signals to the concentration labels">
<option value="linear_fit">Linear fit</option>
<option value="shallow_neural_networks">SNN</option>
</select>
</div>
</div>
<br>
<p style="text-align:center">
<button onclick="recalculate_pushed()" style="width:15%;" data-toggle="tooltip" title="Close the window">Recalculate</button>
<button onclick="peak_configuration_close_pushed()" style="width:15%;" data-toggle="tooltip" title="Close the window">Close</button>
</p>
</div>
</div>

<script>
// Calbacks
$(document).on("click", '.graph_selection', function(){
$('.graph_selection').css('background-color','');
$('.graph_selection').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
if (this.id == "cv_graph_button"){
$('.cv_graph').show(); $('#fit_graph').hide();
fscav_data_fit.cv_plot_state = 'block'; fscav_data_fit.fit_plot_state = 'none';
fscav_data_predict.cv_plot_state = 'block'; fscav_data_predict.fit_plot_state = 'none'}
else  {
$('.cv_graph').hide(); $('#fit_graph').show();
fscav_data_fit.cv_plot_state = 'none'; fscav_data_fit.fit_plot_state = 'block';
fscav_data_predict.cv_plot_state = 'none'; fscav_data_predict.fit_plot_state = 'block';
};
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

$(document).on("click", '.max_min_selection', function(){
$('.max_min_selection').css('background-color','');
$('.max_min_selection').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
graph_selection_changed(this.id);
});

$(document).on("click", '.fit_predict_selection', function(){
$('.fit_predict_selection').css('background-color','');
$('.fit_predict_selection').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
if (this.id == "fit_button_selection"){$('#fitting_panel').show(); $('#prediction_panel').hide(); switch_fscav_data_object('fit')}
else{$('#prediction_panel').show(); $('#fitting_panel').hide(); switch_fscav_data_object('predict')};
});

function graph_selection_changed(id){
graph_selected_point = id;
};

function switch_fscav_data_object(type){
if(type == 'fit'){fscav_data = fscav_data_fit} else{fscav_data = fscav_data_predict};
if(fscav_data.current.array?.length){fscav_data.plot_graph('cv_graph')} else{fscav_data.initialise_graph('cv_graph')};
};

function add_pushed_fit(){
if(loaded_data_fit.data_array?.length){
fscav_data_fit.read_data_from_loaded_files(loaded_data_fit.data_array, loaded_data_fit.names_of_files, parseFloat(_('concentration_label').value));
loaded_data_fit.reset_loaded_data();
_('status_fit').innerHTML = 'Added succesfully.';
};
};

function finish_pushed_fit(){
if(fscav_data_fit.current.array?.length){
fscav_data_fit.data_loading_finished(parseFloat(_('peak_width').value)); switch_fscav_data_object('fit');
_('add_button_fit').disabled = true; _('finish_button_fit').disabled = true;
};
};

function add_pushed_predict(){
if(loaded_data_predict.data_array?.length){
fscav_data_predict.read_data_from_loaded_files(loaded_data_predict.data_array, loaded_data_predict.names_of_files, null);
loaded_data_predict.reset_loaded_data();
_('status_predict').innerHTML = 'Added succesfully.';
};
};

function finish_pushed_predict(){
if(fscav_data_predict.current.array?.length){
fscav_data_predict.data_loading_finished(parseFloat(_('peak_width').value)); switch_fscav_data_object('predict');
_('add_button_predict').disabled = true; _('finish_button_predict').disabled = true;
};
};

function recalculate_pushed(){
fscav_data.calculate_limits_and_auc(parseFloat(_('peak_width').value));
fscav_data.plot_graph('cv_graph');
};

function reset_pushed(){
location.reload();
};
function invert_pushed(){
fscav_data.invert_current_values('cv_graph');
};
function graph_clicked(evtObj){
if(_('graph_selection_checkbox').checked && evtObj.points.length != 0){
// Get index of clicked point.
let pindex = evtObj.points[0].pointIndex;
// Assign clicked point.
fscav_data.change_points(pindex, graph_selected_point);
fscav_data.plot_graph('cv_graph');
};
};

function predict_button_pushed(){
if(_('model_type_selection').value =='linear_fit' && fscav_data_fit.linear_fit_params?.length){fscav_data_predict.predict_from_linear_fit('fit_graph', fscav_data_fit.linear_fit_params)}
else if(0 == 1){predict_from_snn()};// slot for neural network model.
};

function fit_button_pushed(){
if(_('model_type_selection').value =='linear_fit'){fscav_data_fit.get_linear_fit('fit_graph')}
else{}; // slot for neural network fitting.
}

function previous_cv_clicked(){if(fscav_data.graph_index>0){--fscav_data.graph_index; fscav_data.plot_graph('cv_graph')}};
function next_cv_clicked(){if(fscav_data.graph_index<fscav_data.number_of_files-1){++fscav_data.graph_index; fscav_data.plot_graph('cv_graph')}};

function peak_configuration_button_pushed(){_('peak_configuration_modal_window').style.display = "block"};
function peak_configuration_close_pushed(){_('peak_configuration_modal_window').style.display = "none";}
</script>

<script>
// Initialise variables.
var loaded_data_fit = new HL_LOAD_DATA("status_fit");
var loaded_data_predict = new HL_LOAD_DATA("status_predict");
var fscav_data_fit = new HL_FSCAV_DATA(parseFloat(_('frequency').value), _('current_units').value, _('concentration_units').value,  parseInt(_('peak_width').value), 'fit');
var fscav_data_predict = new HL_FSCAV_DATA(parseFloat(_('frequency').value), _('current_units').value, _('concentration_units').value,  parseInt(_('peak_width').value), 'predict');
//Assign the UI variable initially to the fit data.
var fscav_data = fscav_data_fit;
var graph_selected_point = 'min1';
// Assign callback to read the data from the inputs.
_("FSCAVfiles_fit").addEventListener('change', loaded_data_fit.read_files);
// Assign callback to read the data from the input.
_("FSCAVfiles_predict").addEventListener('change', loaded_data_predict.read_files);
//Initialise graphs.
fscav_data.initialise_graph('cv_graph'); fscav_data.initialise_graph('fit_graph');
// Hide fit_graph
_('fit_graph').style.display="none";


alert("<?php echo json_decode(shell_exec(escapeshellcmd('python3 test.py')))?>");
</script>
</body>
</html>
