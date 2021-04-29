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
<script src="TensorFlowModels/ModelClass.js"></script>

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
<button onclick="peak_configuration_button_pushed()" data-toggle="tooltip" title="Configuration of peak detection.">Config.</button>
&nbsp;
<button onclick="integration_configuration_button_pushed()" data-toggle="tooltip" title="Configuration of type of model and graphd.">Peak det.</button>
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
<button onclick="fit_button_pushed()" data-toggle="tooltip" title="Fit the signal parameters to the concentration labels.">Fit</button>&nbsp;
<button id="show_fitting_button" onclick="show_fitting_button_pushed()" data-toggle="tooltip" title="Regraph the calculated fitting.">Show fit</button>
</div>
<div class="row" style="margin-top:5px">
<span id="fit_state_text"></span>
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
&nbsp;
<button id="show_charge_button" onclick="show_charge_button_pushed()" style="width: 30%;" data-toggle="tooltip" title="Show calculated charge trace.">Show Charge</button>
</div>
</div>
<div id="export_panel">
<div class="row" style="margin-top:5px">
<button onclick="export_button_pushed()"  data-toggle="tooltip" title="Export data as XLSX.">Export to XLSX</button>
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



<div>
<p class="footdash">Application created by The Hashemi Lab, Imperial College London & University of South Carolina.</p>
</div>
</div>

<div id="peak_configuration_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<div class="col">
<label for="linear_fit_plot_type" style="width:59%">Plot type:</label>
<select id="linear_fit_plot_type" style="float: right;width:39%" data-toggle="tooltip" title="type of graph to be shown for the linear fit.">
<option value="regression_plot_type">Regression</option>
<option value="true_predicted_plot_type">True vs. Predicted</option>
</select>
</div>
<div class="col">
<label for="peak_width" style="width:59%">Model type:</label>
<select id="model_type_selection" style="float: right;width:39%" data-toggle="tooltip" title="Model used to fit the calibration signals to the concentration labels">
<option value="linear_fit" data-toggle="tooltip" title="Linear fit between calculated charge and concentration labels.">Linear fit</option>
<option value="shallow_neural_networks" data-toggle="tooltip" title="Use of a shallow neural network (SNN). &#x0a;Fit the concentration labels to several parameters from FSCAV signals.">SNN</option>
</select>
<label for="export_tf_model_button" style="width:59%">TensorFlow model:</label>
<button id="export_tf_model_button" onclick="export_tf_model()" data-toggle="tooltip" title="Export the tensorflow NN model.">Export model</button>
</div>
</div>
<hr style="width:100%;text-align:left;margin-left:0;">
<div class="row">
<div class="col">
<label for="epochs" style="width:59%">Epochs:</label>
<input style="width:30%" type="number" step="1" min=1 max = 5000 id="epochs" value=500 data-toggle="tooltip" title="Number of iterations for the SNN to learn the calibration data."/>
<label for="learning_rate" style="width:59%">Learning rate:</label>
<input style="width:30%" type="number" step="0.001" min=0 id="learning_rate" value=0.001 data-toggle="tooltip" title="Learning rate of the fitting."/>
<label for="layer_size" style="width:59%">Layer size:</label>
<input style="width:30%" type="number" step="0.01" min=1 id="layer_size" value=64 data-toggle="tooltip" title="Number of neurons per layer."/>
<label for="std_noise" style="width:59%">STD noise:</label>
<input style="width:30%" type="number" step="0.01" id="std_noise" value=0.1 min=0 max=1 data-toggle="tooltip" title="Standard deviation of gaussian noise added to the signals to train the SNN.&#x0a;Allows to reduce overfitting when increasing the number of epochs."/>
</div>
<div class="col">
<label for="patience" style="width:59%">Patience:</label>
<input style="width:30%" type="number" step="1" min=0 id="patience" value=10 data-toggle="tooltip" title="Number of iterations for the SNN to stop the fitting if the metrics do not improve."/>
<label for="min_delta" style="width:59%">Min. delta:</label>
<input style="width:30%" type="number" step="0.01" min=0 id="min_delta" value=0.01 data-toggle="tooltip" title="Minimum required improvement of the loss for the SNN to keep training."/>
<label for="dropout_rate" style="width:59%">Dropout rate:</label>
<input style="width:30%" type="number" step="0.1" id="dropout_rate" value=0.2 min=0 max=1 data-toggle="tooltip" title="Dropout rate of units in the SNN during training.&#x0a;Allows to reduce overfitting, although it will likely require more iterations to converge."/>
<label for="snn_type_selection" style="width:59%">SNN type:</label>
<select id="snn_type_selection" style="float: right;width:39%" data-toggle="tooltip" title="Select the type of neural network to be used when fitting and estimating the data.">
<option value="single_electrode" data-toggle="tooltip" title="SNN fitted to postcalibration from single electrode.">Single electrode</option>
<option value="multiple_electrodes" data-toggle="tooltip" title="SNN fitted to postcalibration from single electrode after pretraining with postcalibration database.">Pretrained</option>
<option value="whole_cv" data-toggle="tooltip" title="SNN does not require electrode postcalibration, only trained with postcalibration database.">Whole CV</option>
</select>


</div>
</div>
<br>
<p style="text-align:center">
<button onclick="peak_configuration_close_pushed()" style="width:15%;" data-toggle="tooltip" title="Close the window">Close</button>
</p>
<p style="font-size:10px">
Shallow neural networks (SNN) pretrained with post calibrations from other electrodes are trained with a learning rate of 0.001 and a layer size of 64 neurons.
The layer size cannot be changed when selecting the SNN multielectrode fitting model. Changing it will have no effect over the SNN. Changing the learning rate will only affect future training with the imported signals.
</p>
</div>
</div>


<div id="integration_configuration_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<div class="col">
<label for="peak_width" style="width:59%">Peak prom. (samples):</label>
<input style="width:30%" type="number" onchange = "recalculate_pushed()" step="1" min=0 id="peak_width" value=20 data-toggle="tooltip" title="Peak prominence: number of neighbour samples &#x0a;considered to automatically find integration points. "/>
</div>
</div>
<hr style="width:100%;text-align:left;margin-left:0;">
<div class="row">
<div class="col">
<label for="interval_signal_type" style="width:59%">Signal type:</label>
<select id="interval_signal_type" style="float: right;width:39%" data-toggle="tooltip" title="Signals to apply the manual integration points">
<option value="fitting_signals" data-toggle="tooltip" title="Apply manual integrations points to fitting cyclic voltammograms.">Fitting</option>
<option value="prediction_signals" data-toggle="tooltip" title="Apply manual integration points to prediction cyclic voltammograms.">Prediction</option>
</select>

<label for="first_interval_point" style="width:33%">Min 1 (sample):</label>
<input style="width:33%" type="number" step="1" min=0 id="first_interval_point" value=60 data-toggle="tooltip" title="Sample value for first integration limit. "/>
<button onclick="interval_point_changed(this)" id="first_interval_point_button" style="width:15%;float: right;" data-toggle="tooltip" title="Apply value to first interval limit.">Apply</button>

<label for="max_point" style="width:33%">Max (sample):</label>
<input style="width:33%" type="number" step="1" min=0 id="max_point" value=200 data-toggle="tooltip" title="Sample value for maximum amplitude point. "/>
<button onclick="interval_point_changed(this)" id="max_point_button" style="width:15%;float: right;" data-toggle="tooltip" title="Apply value to maximum amplitude point">Apply</button>

<label for="second_interval_point" style="width:33%">Min 2 (sample):</label>
<input style="width:33%" type="number" step="1" min=0 id="second_interval_point" value=350 data-toggle="tooltip" title="Sample value for second integration limit. "/>
<button onclick="interval_point_changed(this)" id="second_interval_point_button" style="width:15%;float: right;" data-toggle="tooltip" title="Apply value to second interval limit">Apply</button>

</div>
</div>
<br>
<p style="text-align:center">
<button onclick="integration_configuration_close_pushed()" style="width:15%;" data-toggle="tooltip" title="Close the window">Close</button>
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
loaded_data_fit.order_files_by_name();
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
loaded_data_predict.order_files_by_name();
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
if(_('model_type_selection').value =='linear_fit' && fscav_data_fit.linear_fit_parameters?.length){fscav_data_predict.predict_from_linear_fit('fit_graph', fscav_data_fit.linear_fit_parameters)}
else if(_('model_type_selection').value =='shallow_neural_networks'){
if(_('snn_type_selection').value != 'whole_cv' && fscav_data_fit.snn_model){fscav_data_predict.predict_from_snn('fit_graph', fscav_data_fit.snn_model, fscav_data_fit.normalised_dataset, fscav_data_fit.normalised_labels)}
else if(_('snn_type_selection').value == 'whole_cv'){
fscav_data_predict.predict_from_snn_whole_cv_model('fit_graph', parseFloat(_('std_noise').value), parseFloat(_('dropout_rate').value))};
};
};

function fit_button_pushed(){
_('fit_state_text').innerHTML = 'Fitting...';
if(_('model_type_selection').value =='linear_fit'){fscav_data_fit.get_linear_fit('fit_graph', 'fit_state_text', _('linear_fit_plot_type').value)}
else if(_('model_type_selection').value =='shallow_neural_networks'){fscav_data_fit.get_snn_fit('fit_graph', parseInt(_('epochs').value), parseFloat(_('learning_rate').value), parseInt(_('layer_size').value), parseInt(_('patience').value),
parseFloat(_('min_delta').value), parseFloat(_('dropout_rate').value), parseFloat(_('std_noise').value), 'fit_state_text', _("SNN_type_selection").value)}
};

function show_fitting_button_pushed(){
if(_('model_type_selection').value =='linear_fit' && fscav_data_fit.linear_fit_parameters?.length){fscav_data_fit.get_linear_fit_metrics('fit_graph', _('linear_fit_plot_type').value)}
else if(_('model_type_selection').value =='shallow_neural_networks' && fscav_data_fit.snn_model){fscav_data_fit.get_snn_fitting_metrics('fit_graph')};
};

function show_charge_button_pushed(){
if(fscav_data_predict.auc?.length){fscav_data_fit.export_to_xlsx(fscav_data_predict.show_predict_charge('fit_graph'));};
};


function export_button_pushed(){fscav_data_fit.export_to_xlsx(fscav_data_predict);};

function export_tf_model(){if(fscav_data_fit.snn_model){fscav_data_fit.snn_model.save('downloads://my-model')}};

function previous_cv_clicked(){if(fscav_data.graph_index>0){--fscav_data.graph_index; fscav_data.plot_graph('cv_graph')}};
function next_cv_clicked(){if(fscav_data.graph_index<fscav_data.number_of_files-1){++fscav_data.graph_index; fscav_data.plot_graph('cv_graph')}};

function peak_configuration_button_pushed(){_('peak_configuration_modal_window').style.display = "block";};
function peak_configuration_close_pushed(){_('peak_configuration_modal_window').style.display = "none";};

function integration_configuration_button_pushed(){_('integration_configuration_modal_window').style.display = "block";};
function integration_configuration_close_pushed(){_('integration_configuration_modal_window').style.display = "none";};

function interval_point_changed(obj){
if(_('interval_signal_type').value =='fitting_signals' && fscav_data_fit.current.array?.length){
manual_change_integration_point(obj, fscav_data_fit);
}
else if (_('interval_signal_type').value =='prediction_signals' && fscav_data_predict.current.array?.length){
manual_change_integration_point(obj, fscav_data_predict);
};
};

function manual_change_integration_point(obj, data){
if(obj.id =="first_interval_point_button"){data.manual_change_points(_("first_interval_point").value, obj.id)}
else if(obj.id=="max_point_button"){data.manual_change_points(_("max_point").value, obj.id)}
else if(obj.id=="second_interval_point_button"){data.manual_change_points(_("second_interval_point").value, obj.id)};
data.plot_graph("cv_graph");
};

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

</script>
</body>
</html>
