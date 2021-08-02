<!DOCTYPE html>
<html lang="en">
<title>FSCV Calibration</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="JavaScriptPackages/plotly-latest.min.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script src="JavaScriptPackages/DashboardMethods.js"></script>
<script src="JavaScriptPackages/ArrayMethods.js"></script>
<script src="JavaScriptPackages/xlsx.full.min.js"></script>
<script src = "OOP/HLClasses.js"></script>
<script src = "OOP/LOADClass.js"></script>
<script src = "OOP/FSCVClasses.js"></script>

<head>
<title>FSCV Calibration</title>
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
<h1>FSCV Calibration</h1>
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
<button onclick="peak_detection_configuration_button_pushed()" data-toggle="tooltip" title="Configuration of peak detection and model used.">Config.</button>
</div>
<div id="fitting_panel">
<br>
<h5>Fitting Panel</h5>
<hr>
<div class="row">
<input type="file" id="FSCVfiles_fit" accept=".xls,.xlsx,.csv,.txt" style="width:70%;"  multiple data-toggle="tooltip" title="Add files to the application from a local path"> </input>
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
<label for="model_type" style="width:59%">Model type:</label>
<select id="model_type_selection" style="float: right;width:39%" data-toggle="tooltip" title="Model used to fit the calibration signals to the concentration labels">
<option value="linear_fit" data-toggle="tooltip" title="Linear fit between calculated charge and concentration labels.">Linear fit</option>
<option value="quadratic_fit" data-toggle="tooltip" title="Quadratic between calculated charge and concentration labels.">Quadratic fit</option>
</select>
</div>
<hr style="width:100%;text-align:left;margin-left:0;">
<div class="col">
<label for="peak_width" style="width:59%">Peak prom. (samples):</label>
<input style="width:30%" type="number" onchange = "recalculate_pushed()" step="1" min=0 id="peak_width" value=20 data-toggle="tooltip" title="Peak prominence: number of neighbour samples &#x0a;considered to automatically find integration points. "/>
</div>
</div>
<br>
<p style="text-align:center">
<button onclick="peak_detection_configuration_close_pushed()" style="width:15%;" data-toggle="tooltip" title="Close the window">Close</button>
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
fscv_data_fit.cv_plot_state = 'block'; fscv_data_fit.fit_plot_state = 'none';
}
else  {
$('.cv_graph').hide(); $('#fit_graph').show();
fscv_data_fit.cv_plot_state = 'none'; fscv_data_fit.fit_plot_state = 'block';
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


function add_pushed_fit(){
if(loaded_data_fit.data_array?.length){
loaded_data_fit.order_files_by_name();
fscv_data_fit.read_data_from_loaded_files(loaded_data_fit.data_array, loaded_data_fit.names_of_files, parseFloat(_('concentration_label').value));
loaded_data_fit.reset_loaded_data();
_('status_fit').innerHTML = 'Added succesfully.';
};
};

function finish_pushed_fit(){
if(fscv_data_fit.current.array?.length){
fscv_data_fit.data_loading_finished(parseFloat(_('peak_width').value));
_('add_button_fit').disabled = true; _('finish_button_fit').disabled = true;
fscv_data_fit.plot_graph('cv_graph');
};
};

function reset_pushed(){
location.reload();
};
function invert_pushed(){
fscv_data_fit.invert_current_values('cv_graph');
};
function graph_clicked(evtObj){
if(_('graph_selection_checkbox').checked && evtObj.points.length != 0){
// Get index of clicked point.
let pindex = evtObj.points[0].pointIndex;
// Assign clicked point.
fscv_data_fit.change_points(pindex);
fscv_data_fit.plot_graph('cv_graph');
};
};

function fit_button_pushed(){
_('fit_state_text').innerHTML = 'Fitting...';
if(_('model_type_selection').value =='linear_fit'){fscv_data_fit.get_linear_fit('fit_graph', 'fit_state_text', _('linear_fit_plot_type').value)}
else{fscv_data_fit.get_quadratic_fit('fit_graph', 'fit_state_text', _('linear_fit_plot_type').value)}
};

function show_fitting_button_pushed(){
if(_('model_type_selection').value =='linear_fit' && fscv_data_fit.linear_fit_parameters?.length){fscv_data_fit.get_linear_fit_metrics('fit_graph', _('linear_fit_plot_type').value)};
};

function export_button_pushed(){fscv_data_fit.export_to_xlsx()};

function previous_cv_clicked(){if(fscv_data_fit.graph_index>0){--fscv_data_fit.graph_index; fscv_data_fit.plot_graph('cv_graph')}};
function next_cv_clicked(){if(fscv_data_fit.graph_index<fscv_data_fit.number_of_files-1){++fscv_data_fit.graph_index; fscv_data_fit.plot_graph('cv_graph')}};

function peak_detection_configuration_button_pushed(){_('peak_configuration_modal_window').style.display = "block";};
function peak_detection_configuration_close_pushed(){_('peak_configuration_modal_window').style.display = "none";};

function interval_point_changed(obj){
fscv_data_fit.manual_change_points(_("max_point").value);
fscv_data_fit.plot_graph("cv_graph");
};

function recalculate_pushed(){
fscv_data_fit.detect_max_peak(peak_width);
fscv_data_fit.plot_graph('cv_graph');
};

</script>

<script>
// Initialise variables.
var loaded_data_fit = new HL_LOAD_DATA("status_fit");
var fscv_data_fit = new HL_FSCV_DATA_CALIBRATION(parseFloat(_('frequency').value), _('current_units').value, _('concentration_units').value, 'fit');
// Assign callback to read the data from the inputs.
_("FSCVfiles_fit").addEventListener('change', loaded_data_fit.read_files);
//Initialise graphs.
fscv_data_fit.initialise_graph('cv_graph');
fscv_data_fit.initialise_graph('fit_graph');
// Hide fit_graph
_('fit_graph').style.display="none";

</script>
</body>
</html>
