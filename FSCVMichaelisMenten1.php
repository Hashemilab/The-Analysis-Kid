<!DOCTYPE html>
<html lang="en">
<title>Reuptake Analysis</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<script src="JavaScriptPackages/plotly-latest.min.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script src="JavaScriptPackages/DashboardMethods.js"></script>
<script src="JavaScriptPackages/ArrayMethods.js"></script>
<script src="JavaScriptPackages/tf.min.js"></script>
<script src="JavaScriptPackages/xlsx.full.min.js"></script>
<script src = "OOP/HLClasses.js"></script>
<script src = "OOP/FSCVClasses.js"></script>
<script src = "OOP/LOADClass.js"></script>
<script src = "OOP/MMClass1.js"></script>

<head>
<title>Kinetic Analysis</title>
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
<div class="header" style="height:10vh;">
<h1>Kinetic Analysis</h1>
</div>
<br>
<div style = "margin:auto; width: 90%;">
<div class="row">
<div class="col-4">
<div class="row">
<input type="file" name="FSCVfiles" id="FSCVfiles" accept=".xls,.xlsx,.csv,.txt" style="width:75%;" data-toggle="tooltip" title="Add file to the application from a local path"> </input>
<button>
<a id="include_button" onclick="include_pushed()" style="width: 25%;" data-toggle="tooltip" title="Include loaded data into the application">Include</a>
</button>
</div>
<div class="row">
<p id="status"> Upload the files.</p>
</div>
<br>
<div class="row">
<label for="vmax" style="width: 25%;">V<sub>max</sub> :</label>
<label for="km" style="width: 25%;">K<sub>m</sub> :</label>
<label for="stim_freq" style="width: 25%;">f (Hz) :</label>
<label for="release_constant" style="width: 25%;">[S<sub>p</sub>] :</label>
<input type="number" step=0.1 min=1  id="vmax" style="width: 25%;" value=2 onchange="values_changed()" data-toggle="tooltip" title="Maximum rate of reuptake"/>
<input type="number" step=0.1 id="km" style="width: 25%;" value=0.2 onchange="values_changed()" data-toggle="tooltip" title="Michaelis constant of reuptake"/>
<input type="number" step=0.1 id="stim_freq" style="width: 25%;" value=60 onchange="values_changed()" data-toggle="tooltip" title="Stimulation frequency"/>
<input type="number" step=0.1 id="release_constant" style="width: 25%;" value=0.1 onchange="values_changed()" data-toggle="tooltip" title="Release constant"/>
</div>
<br>
<div class="row">
<label for="stimulation_start" style="width: 75%;">Start of stimulation (s) :</label>
<input type="number" step=1 id="stimulation_start" style="width: 25%;" value=5 onchange="values_changed()" data-toggle="tooltip" title="Stimulation starting time"/>
<label for="number_of_pulses" style="width: 75%;">Number of pulses :</label>
<input type="number" step=1 id="number_of_pulses" style="width: 25%;" value=100 onchange="values_changed()" data-toggle="tooltip" title="Number of stimulation pulses"/>
</div>
<br>
<div>
<button onclick="optimisation_button_pushed()" data-toggle="tooltip" title="Open configuration for the automatic optimization of parameters">Optimization</button>
<button onclick="export_as_xlsx_pushed()" data-toggle="tooltip" title="Export reuptake analysis as XLSX">Export as XLSX</button>
<button onclick="info_pushed()" data-toggle="tooltip" title="Information on the reuptake kinetics.">Info</button>
<button onclick="reset_pushed()" data-toggle="tooltip" title="Reset the application">Reset</button>
</div>
</div>

<div class="col-8">
<div class = "center" style = "float:right; width:100%;">
<div id="ct_graph" class = "center" style="width:100%; height:80vh;"></div>
<div id="release_graph" class = "center" style="width:100%; height:80vh;"></div>
</div>
<div style="position:absolute;left:50%;margin-top:2.5%">
<button class="graph_selection" id="ct_graph_button" style="font-size:12px;background-color:#3f51b5; color:white;" data-toggle="tooltip" title="Toggle to show the concentration trace">1</button>
<button class="graph_selection" id="release_graph_button" style="font-size:12px" data-toggle="tooltip" title="Toggle to show the release rate">2</button>
</div>
</div>

</div>
</div>
<div>
<p class="footdash">Application created by The Hashemi Lab, Imperial College London & University of South Carolina.</p>
</div>
</div>

<div id="optimisation_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<div class="col">
<p> Parameters to optimise: </p>
<label for="vmax_check" style="width:42%">V<sub>max</sub> (min, max) : </label>
<input type="number" id="vmax_min" step=0.1 min=0 style="width: 23%;" value=0 onchange="values_changed()" data-toggle="tooltip" title="Optimization min limit of Vmax"/>
<input type="number" id="vmax_max" step=0.1 min=0 style="width: 23%;" value=100 onchange="values_changed()" data-toggle="tooltip" title="Optimization max limit of Vmax" />
<input type="checkbox" id="vmax_check"  style="width:5%"/>
<label for="km_check" style="width:42%">K<sub>m</sub> (min, max) : </label>
<input type="number" id="km_min" step=0.1 min=0 style="width: 23%;" value=0 onchange="values_changed()" data-toggle="tooltip" title="Optimization min limit of Km" />
<input type="number" id="km_max" step=0.1 min=0 style="width: 23%;" value=100 onchange="values_changed()" data-toggle="tooltip" title="Optimization max limit of Km" />
<input type="checkbox" id="km_check"  style="width:5%"/>
<label for="release_constant_check" style="width:42%">[S<sub>p</sub>] (min, max) : </label>
<input type="number" id="release_constant_min" step=0.1 min=0 style="width: 23%;" value=0 onchange="values_changed()" data-toggle="tooltip" title="Optimization min limit of release constant" />
<input type="number" id="release_constant_max" step=0.1 min=0 style="width: 23%;" value=1 onchange="values_changed()" data-toggle="tooltip" title="Optimization max limit of release constant" />
<input type="checkbox" id="release_constant_check"  style="width:5%"/>
</div>
<div class="col">
<p> Options: </p>
<label for="epochs" style="width:59%">Epochs: </label> <input type="number" min=1 max=5000 value=500 id="epochs" style="width:39%" data-toggle="tooltip" title="Number of iterations of the algorithm" />
<label for="learning_rate" style="width:59%">Learning rate: </label>  <input type="number" min=0 max=1  step=0.001 value=0.001 id="learning_rate" style="width:39%" data-toggle="tooltip" title="Step of change for each iteration"/>
</div>
</div>
<br>
<p style="text-align:center">
<button style="width:15%;" onclick="optimisation_optimise_button_pushed()" data-toggle="tooltip" title="Apply optimization of the selected parameters">Optimise</button>
<button style="width:15%;" onclick="optimisation_close_button_pushed()" data-toggle="tooltip" title="Close window">Close</button>
</p>
</div>
</div>

<div id="information_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<p style="margin:5px; width:100%;"> The equation used by the software is the following: </p>
<div class="eq-c" style="border-style: solid;margin:auto;">
<div class="fraction"> <span class="fup">d S(t)</span> <span class="bar">/</span> <span class="fdn">dt</span> </div>
 = f[S<sub>p</sub>] - <div class="fraction"> <span class="fup">V<sub>max</sub></span> <span class="bar">/</span> <span class="fdn">K<sub>m</sub>/S(t) + 1</span> </div></div>
</div>
<p style="margin:5px"> f is the frequency of stimulation, [S<sub>p</sub>] is the release rate constant (amount of released neurotransmitter per stimulation), S(t) is the concentration
of neurotransmitter in the extracellular space and V<sub>max</sub> and K<sub>m</sub> are common Michaelis Menten reuptake parameters.</p>
<p style="margin:5px"> The imported concentration units will determine [S<sub>p</sub>], V<sub>max</sub> and K<sub>m</sub> units. Time units are set to seconds.</p>
<br>
<p style="text-align:center">
<button style="width:15%;" onclick="info_close_pushed()" data-toggle="tooltip" title="Close window">Close</button>
</p>
</div>
</div>


<script>
// Application callbacks.
$(document).on("click", '.graph_selection', function(){
$('.graph_selection').css('background-color','');
$('.graph_selection').css('color','');
$(this).css('background-color','#3f51b5');
$(this).css('color','white');
if (this.id == "ct_graph_button"){  $('#ct_graph').show(); $('#release_graph').hide(); mm_concentration.concentration_plot_state = 'block'; mm_concentration.release_plot_state = 'none'}
else  {$('#ct_graph').hide(); $('#release_graph').show(); mm_concentration.concentration_plot_state = 'none'; mm_concentration.release_plot_state = 'block'}
});

function values_changed(){
mm_concentration.input_values_changed("ct_graph", "release_graph", parseFloat(_('stimulation_start').value), parseInt(_('number_of_pulses').value),
parseFloat(_('stim_freq').value), parseFloat(_('release_constant').value), parseFloat(_('vmax').value), parseFloat(_('km').value));
};

function include_pushed(){
//get data from uploaded file.
let data_array = transpose(loaded_data.data_array[0]);
input_trace = new HL_FSCV_ARRAY(data_array[1].slice(1), '', 'Concentration');
time_array = data_array[0].slice(1);
add_data(input_trace, time_array);
};

function optimisation_button_pushed(){
_('optimisation_modal_window').style.display = "block";
}

function optimisation_close_button_pushed(){
_('optimisation_modal_window').style.display = "none";
}

function optimisation_optimise_button_pushed(){
mm_concentration.optimisation_parameters(parseInt(_('epochs').value), parseFloat(_('learning_rate').value), [_('vmax_check').checked, _('km_check').checked,
_('release_constant_check').checked], ['vmax', 'km', 'release_constant'], [parseFloat(_('vmax_min').value), parseFloat(_('km_min').value),
parseFloat(_('release_constant_min').value)], [parseFloat(_('vmax_max').value), parseFloat(_('km_max').value),
parseFloat(_('release_constant_max').value)]);
values_changed();
};

function export_as_xlsx_pushed(){
mm_concentration.export_kinetic_parameters();
};

function info_pushed() {
_('information_modal_window').style.display = "block";
};

function info_close_pushed(){
_('information_modal_window').style.display = "none";
};

function reset_pushed(){
location.reload();
};
</script>

<script>
//Initialise objects.
var loaded_data = new HL_LOAD_DATA("status");
var mm_concentration = new HL_MICHAELIS_MENTEN1();
var input_trace, time_array;
//Initialise graphs.
mm_concentration.initialise_graph("ct_graph");
mm_concentration.initialise_graph("release_graph");
//Add listener to loading input.
_("FSCVfiles").addEventListener('change', loaded_data.read_files);
//Check for signal.
if (typeof(input_trace) !== 'undefined'){
add_data(input_trace, time_array);
};
// Hide release_graph
_('release_graph').style.display="none";
// Define add data function.
function add_data(input_trace, time_array){
mm_concentration.add_data_to_application("ct_graph", "release_graph", input_trace, time_array,  parseFloat(_('stimulation_start').value), parseInt(_('number_of_pulses').value),
parseFloat(_('stim_freq').value), parseFloat(_('release_constant').value), parseFloat(_('vmax').value), parseFloat(_('km').value));
};
</script>
</body>
</html>
