<!DOCTYPE html>
<html lang="en">
<title>FSCV Analysis</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="JavaScriptPackages/plotly-latest.min.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script src="JavaScriptPackages/DashboardMethods.js"></script>
<script src="JavaScriptPackages/nouislider.min.js"></script>
<script src="JavaScriptPackages/ArrayMethods.js"></script>
<script src="JavaScriptPackages/tf.min.js"></script>
<script src="JavaScriptPackages/xlsx.full.min.js"></script>
<script src = "OOP/FSCVClasses.js"></script>
<script src = "OOP/LOADClass.js"></script>
<script src = "OOP/MMClass.js"></script>

<head>
<title>Michaelis Menten Analysis</title>
<link rel="shortcut icon" href="Images/cv.png"/>
<link type="text/css" rel="stylesheet" href="Styling/styles.css"/>
<link rel="stylesheet" href="Styling/bootstrap.min.css"/>
<link rel="stylesheet" href="Styling/nouislider.min.css" >

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
<h1>Michaelis Menten Analysis</h1>
</div>
<br>
<div style = "margin:auto; width: 90%;">
<div class="row">
<div class="col-4">
<div class="row">
<input type="file" name="FSCVfiles" id="FSCVfiles" accept=".xls,.xlsx,.csv,.txt" style="width:75%;"> </input>
<button>
<a id="include_button" onclick="include_pushed()" style="width: 25%;">Include</a>
</button>
</div>
<div class="row">
<p id="status"> Upload the files.</p>
</div>
<div class="row">
<div class="eq-c">
<div class="fraction"> <span class="fup">d S(t)</span> <span class="bar">/</span> <span class="fdn">dt</span> </div>
 = R(t) · (1-A(t)) - &alpha; · <div class="fraction"> <span class="fup">V<sub>max1</sub> · S(t)</span> <span class="bar">/</span> <span class="fdn">K<sub>m1</sub> + S(t)</span> </div>
- &beta; · <div class="fraction"> <span class="fup">V<sub>max2</sub> · S(t)</span> <span class="bar">/</span> <span class="fdn">K<sub>m2</sub> + S(t)</span> </div>
</div>
</div>
<div class="row">
<label for="alpha" style="width: 16.6%;">&alpha; :</label>
<label for="vmax_1" style="width: 16.6%;">V<sub>max1</sub> :</label>
<label for="km_1" style="width: 16.6%;">K<sub>m1</sub> :</label>
<label for="beta" style="width: 16.6%;">&beta; :</label>
<label for="vmax_2" style="width: 16.6%;">V<sub>max2</sub> :</label>
<label for="km_2" style="width: 16.6%;">K<sub>m2</sub> :</label>
<input type="number" step="1" min=0 max=1 id="alpha" style="width: 16.6%;"  value=1 onchange="values_changed()" />
<input type="number" step="1" min=1  id="vmax_1" style="width: 16.6%;" value=150 onchange="values_changed()" />
<input type="number" id="km_1" style="width: 16.6%;" value=15 onchange="values_changed()" />
<input type="number" step="1" min=0 max=1 id="beta" style="width: 16.6%;"  value=1 onchange="values_changed()" />
<input type="number" step="1" min=1  id="vmax_2" style="width: 16.6%;" value=500 onchange="values_changed()" />
<input type="number" id="km_2" style="width: 16.6%;" value=50 onchange="values_changed()" />
</div>
<br>
<button onclick="add_break_release_button_pushed()">Add</button>
&nbsp;
<button onclick="remove_break_release_button_pushed()">Del</button>
<div id="release_rate_slider" style="width:70%;float:right; margin-top:1.5%"></div>
<br><br>
<div id="release_rate_list"> R(t): <input type="number" id="release_rate_slider_input_1" style="width:18%" value=0 onchange="values_changed()" /></div>
<br>
<button onclick="add_break_autoreceptors_button_pushed()">Add</button>
&nbsp;
<button onclick="remove_break_autoreceptors_button_pushed()">Del</button>
<div id="autoreceptors_slider" style="width:70%;float:right; margin-top:1.5%"></div>
<br><br>
<div id="autoreceptors_list">A(t): <input type="number" id="autoreceptors_slider_input_1" style="width:18%" value=0 onchange="values_changed()" /></div>
<br>
<button onclick="optimisation_button_pushed()">Optimisation</button>
</div>

<div class="col-8">
<div class = "center" style = "float:right; width:100%;">
<div id="ct_graph" class = "center" style="width:100%; height:80vh;"></div>
<div id="release_graph" class = "center" style="width:100%; height:80vh;"></div>
</div>
<div style="position:absolute;left:50%;margin-top:2.5%">
<button class="graph_selection" id="ct_graph_button" style="font-size:12px;background-color:#3f51b5; color:white;">1</button>
<button class="graph_selection" id="release_graph_button" style="font-size:12px">2</button>
</div>
</div>

</div>
</div>
<div>
<p class="footdash">Application created by The Hashemi Lab, Imperial College London.</p>
</div>
</div>

<div id="optimisation_modal_window" class="modal">
<div class="modal-content">
<div class="row">
<div class="col">
<p> Parameters to optimise: </p>
<label for="vmax1_check" style="width:59%">V<sub>max1</sub> : </label> <input type="checkbox" id="vmax1_check"  style="width:39%"/>
<label for="km1_check" style="width:59%">K<sub>m1</sub> : </label> <input type="checkbox" id="km1_check"  style="width:39%"/>
<label for="vmax2_check" style="width:59%">V<sub>max2</sub> : </label> <input type="checkbox" id="vmax2_check"  style="width:39%"/>
<label for="km2_check" style="width:59%">K<sub>m2</sub> : </label> <input type="checkbox" id="km2_check"  style="width:39%"/>
</div>
<div class="col">
<label for="epochs" style="width:59%">Epochs: </label> <input type="number" min=1 max=5000 value=500 id="epochs" style="width:39%" />
<label for="learning_rate" style="width:59%">Learning rate: </label>  <input type="number" min=0 max=1 value=0.001 id="learning_rate" style="width:39%" />
</div>
</div>
<br>
<p style="text-align:center">
<button style="width:15%;" onclick="optimisation_optimise_button_pushed()">Optimise</button>
<button style="width:15%;" onclick="optimisation_close_button_pushed()">Close</button>
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
if (this.id == "ct_graph_button"){$('#ct_graph').show(); $('#release_graph').hide()}
else{$('#ct_graph').hide(); $('#release_graph').show()};
});




function add_break_release_button_pushed(){
if(mm_concentration.release_rate_slider.start.length<5){mm_concentration.add_slider_break("release_rate_slider", "release_rate_list", "release_rate_slider")}
};
function remove_break_release_button_pushed(){
if(mm_concentration.release_rate_slider.start.length>1){mm_concentration.remove_slider_break("release_rate_slider", "release_rate_list", "release_rate_slider")};
};
function add_break_autoreceptors_button_pushed(){
if(mm_concentration.autoreceptors_slider.start.length<5){mm_concentration.add_slider_break("autoreceptors_slider", "autoreceptors_list", "autoreceptors_slider")};
};
function remove_break_autoreceptors_button_pushed(){
if(mm_concentration.autoreceptors_slider.start.length>1){mm_concentration.remove_slider_break("autoreceptors_slider", "autoreceptors_list", "autoreceptors_slider")};
};
function values_changed(){
mm_concentration.input_values_changed("ct_graph","release_graph", "release_rate_slider", "autoreceptors_slider", "release_rate_slider", "autoreceptors_slider", [_('alpha').value, _('vmax_1').value,
_('km_1').value, _('beta').value, _('vmax_2').value, _('km_2').value ], "release_rate_list", "autoreceptors_list");
};
function include_pushed(){
//get data from uploaded file.
let fscv_concentration_loaded = new HL_FSCV_CONCENTRATION();
let data_array = transpose(loaded_data.data_array[0]);
fscv_concentration_loaded.average_concentration.array = data_array[1].slice(1);
fscv_concentration_loaded.time.array = [data_array[0].slice(1)];
add_data(fscv_concentration_loaded);
};



function optimisation_button_pushed(){
_('optimisation_modal_window').style.display = "block";
}

function optimisation_close_button_pushed(){
_('optimisation_modal_window').style.display = "none";
}

function optimisation_optimise_button_pushed(){

};
</script>

<script>
//Initialise objects.
var loaded_data = new HL_LOAD_DATA("status");
var mm_concentration = new HL_MICHAELIS_MENTEN();
//Initialise graphs.
mm_concentration.initialise_graph("ct_graph");
mm_concentration.initialise_graph("release_graph");
//Add listener to loading input.
_("FSCVfiles").addEventListener('change', loaded_data.read_files);
//Initialise sliders.
noUiSlider.create(_('release_rate_slider'), mm_concentration.release_rate_slider);
_('release_rate_slider').noUiSlider.on('change', values_changed);
noUiSlider.create(_('autoreceptors_slider'), mm_concentration.autoreceptors_slider);
_('autoreceptors_slider').noUiSlider.on('change', values_changed);
//Check for signal.
if (typeof(fscv_concentration) !== 'undefined'){
add_data(fscv_concentration);
};
// Hide release_graph
_('release_graph').style.display="none";
// Define add data function.
function add_data(fscv_concentration){
mm_concentration.add_data_to_application("ct_graph", fscv_concentration, "release_graph", "release_rate_slider", "autoreceptors_slider", "release_rate_slider", "autoreceptors_slider",
[_('alpha').value, _('vmax_1').value, _('km_1').value, _('beta').value, _('vmax_2').value, _('km_2').value ], "release_rate_list", "autoreceptors_list");
};
</script>



</body>
</html>
