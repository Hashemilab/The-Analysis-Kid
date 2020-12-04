<!DOCTYPE html>
<html lang="en">
<title>FSCAV Analysis</title>
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
<title>FSCAV Analysis</title>
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
<h1>FSCAV Analysis</h1>
</div>
<br>
<div style = "margin:auto; width: 90%;">
<div class="row" style="margin:auto;">
<div class="col-4">
<div class="row">
<input type="file" name="FSCAVfiles" id="FSCAVfiles" accept=".xls,.xlsx,.csv,.txt" style="width:75%;"  multiple data-toggle="tooltip" title="Add files to the application from a local path"> </input>
<button>
<a id="include_button" onclick="include_pushed()" style="width: 25%;" data-toggle="tooltip" title="Include loaded files into the application">Include</a>
</button>
</div>
<div class="row">
<p id="status"> Upload the files.</p>
</div>
<div class="row">
<label for="frequency" style="width: 33%;">Freq. (Hz):</label>
<label for="current_units" style="width: 33%;">Units:</label>
<label for="neurotransmitter" style="width: 33%;">Molecule:</label>
<input type="number" step="1" min=1 name="frequency" id="frequency" style="width: 33%;"  value=500000 data-toggle="tooltip" title="Sampling frequency of the acquisition" />
<input type="text" name="current_units" id="current_units" style="width: 33%;" value="nA" data-toggle="tooltip" title="Current units of uploaded data"/>
<select id="select_neurotransmitter" style="width: 33%;" data-toggle="tooltip" title="Select molecule to calibrate">
<option value="serotonin" selected>5-HT</option>
<option value="dopamine">DA</option>
</select>

</div>
<br>
<div class="row">
<button onclick="invert_pushed()" data-toggle="tooltip" title="Invert the sign of the current values in the voltammogram">Invert</button>
&nbsp;
<button id="graph_point_selection" class="graph_point_selection" data-toggle="tooltip" title="Select horizontal traces from the color plot &#x0a; by interactively clicking on the graph">
Graph selection<input type="checkbox" hidden id="graph_selection_checkbox">
</button>
&nbsp;
<button onclick="reset_pushed()" data-toggle="tooltip" title="Reset the application">Reset</button>

</div>
<div class="row" style="margin-top:5px">
<button onclick="peak_configuration_button_pushed()" data-toggle="tooltip" title="Peak detection configuration">Peak detection config.</button>
</div>
</div>


<div class="col-8">
<div class = "center" style = "float:right; width:100%;">
<div id="cv_graph" class = "cv_graph center" style="width:100%; height:80vh;"></div>
<div id="concentration_graph" class = "center" style="width:100%; height:80vh;"></div>
</div>
<div style="position:absolute;left:50%;margin-top:2.5%">
<button class="graph_selection" id="cv_graph_button" style="font-size:12px;background-color:#3f51b5; color:white;" data-toggle="tooltip" title="Toggle to show the current traces">1</button>
<button class="graph_selection" id="concentration_graph_button" style="font-size:12px" data-toggle="tooltip" title="Toggle to show predicted concentrations">2</button>
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

</div>
</div>
<br>
<p style="text-align:center">
<button onclick="include_pushed()" style="width:15%;" data-toggle="tooltip" title="Close the window">Recalculate</button>
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
if (this.id == "cv_graph_button"){$('.cv_graph').show(); $('#concentration_graph').hide(); fscav_data.cv_plot_state = 'block'; fscav_data.concentration_plot_state = 'none'}
else  {$('.cv_graph').hide(); $('#concentration_graph').show(); fscav_data.cv_plot_state = 'none'; fscav_data.concentration_plot_state = 'block'};
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

function graph_selection_changed(id){
graph_selected_point = id;
};

function include_pushed(){
if(loaded_data.data_array !== [] ){
fscav_data = new HL_FSCAV_DATA(loaded_data.data_array, loaded_data.names_of_files, parseFloat(_('frequency').value), _('current_units').value, 'V', _('select_neurotransmitter').value, parseInt(_('peak_width').value));
fscav_data.plot_graph('cv_graph');
};
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

function previous_cv_clicked(){if(fscav_data.graph_index>0){--fscav_data.graph_index; fscav_data.plot_graph('cv_graph')}};
function next_cv_clicked(){if(fscav_data.graph_index<fscav_data.number_of_files-1){++fscav_data.graph_index; fscav_data.plot_graph('cv_graph')}};

function peak_configuration_button_pushed(){_('peak_configuration_modal_window').style.display = "block"};
function peak_configuration_close_pushed(){_('peak_configuration_modal_window').style.display = "none";}
</script>

<script>
// Initialise variables.
var loaded_data = new HL_LOAD_DATA("status");
var fscav_data = new HL_FSCAV_DATA([[0]],['Blank'], parseFloat(_('frequency').value), _('current_units').value, 'V', _('select_neurotransmitter').value, parseInt(_('peak_width').value));
var graph_selected_point = 'min1';
// Assign callback to read the data from the input.
_("FSCAVfiles").addEventListener('change', loaded_data.read_files);
//Initialise graphs.
fscav_data.initialise_graph('cv_graph'); fscav_data.initialise_graph('concentration_graph');
// Hide concentration_graph
_('concentration_graph').style.display="none";
</script>
</body>
</html>
