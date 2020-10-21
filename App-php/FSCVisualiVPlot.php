<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script src="JavaScriptPackages/html2pdf.bundle.min.js"></script>
<script src="JavaScriptPackages/tf.min.js"></script>
<script src="JavaScriptPackages/sweetalert.min.js"></script>
<script src="JavaScriptPackages/plotly-latest.min.js"></script>
<script src="JavaScriptPackages/ArrayMethods.js"></script>
<script src="JavaScriptPackages/DashboardMethods.js"></script>
<script src="JavaScriptPackages/axios.min.js"></script>
<script src="JavaScriptPackages/exportTabletoCSV.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script type="text/javascript" id="MathJax-script" async
src="JavaScriptPackages/tex-chtml.js">
</script>

<title> i-V Dashboard</title>
<link rel="shortcut icon" href="cv.png" />
<link
rel="stylesheet"
href="Styling/bootstrap.min.css"
/>
<link
rel="stylesheet"
href="Styling/buttons.css"
/>
<link
rel="stylesheet"
href="Styling/google-css.css"
/>
<link
href="Styling/google-css.css"
rel="stylesheet"
/>

<link rel="stylesheet" href="Styling/styles.css" />
<style>
.se-pre-con {
position: fixed;
left: 0px;
top: 0px;
width: 100%;
height: 100%;
z-index: 9999;
background: url("Images/loading.gif") center no-repeat #eff4f7;
}

.header {
padding: 5px;
text-align: center;
background: #3f51b5;
color: white;
font-size: 16px;
}
.footdash{ text-align: center;  color: #3f51b5;}
.equation{
font-size: 12px;
}

table{
width:100%;
height:80px;
border:1.5px solid black;
font-size: 12px;
}
th {
background: #3f51b5;
height: 40px;
font-weight: bold;
color: white;
border: 1.5px solid black;
text-align: center;
}
td {
border: 1.5px solid black;
color: black;
text-align:center;
}
table.center {
margin-left:auto;
margin-right:auto;
}
</style>
<style>
.notepad {
width: 80%;
max-width: 600px;
height: 180px;
box-shadow: 10px 10px 40px rgba(black, .15);
border-radius: 0 0 10px 10px;
overflow: hidden;
resize: none;
}

.paper {
width: 100%;
height: 180px;
min-height: 60vh;
padding: 20px 20px;
font-family: 'Titillium Web', Arial, Helvetica, sans-serif;
line-height: 32px;
outline: 0;
font-size: 14px;
color: black;
resize: none;
}

.table-hover thead tr:hover th, .table-hover tbody tr:hover td {
background-color: #eceef8;
font-weight: bold;
}

</style>
<script>
$(window).on('load', function () {
$(".se-pre-con").fadeOut("slow");
});
</script>
</head>

<body>
<div id="loading" class="se-pre-con"></div>
<div id="wrapper" style="background-color: #eff4f7">
<div class="content-area">
<div class="container-fluid">
<div class="text-right mt-3 mb-3 d-fixed">
<div class="header">
<h1 contenteditable="true">i-V Dashboard</h1>
</div>
<br>
<div style="position: absolute; right: auto;">
<button class="btn btn-primary" id="fusionexport-btn" onClick="reset_all()">
<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
<span class="btn-text">Reset Dashboard</span>
</button>
<button class="btn btn-primary">
<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
<a id="inversion" onclick="invert_cv()" style="color:white;">Invert Sign</a>
</button>
<button class="btn btn-primary" id="fusionexport-btn" onClick="downloadPDF2()">
<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
<span class="btn-text">Download as PDF</span>
</button>
</div>
<b>Graph Selection: </b>
<label class="switch">
<input type="checkbox" id="peak_selection" name="peak_selection" value="peak_selection">
<span class="slider round"></span>
</label>
</div>
<div class="main">


<div class="row mt-5 mb-4">
<div class="col-md-6">
<div class="box">
<div id="control">
<p style="font-size:20px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><b>Classification Panel</b> &nbsp;&nbsp; <button class="btn btn-primary" style=" font-size: 10px;" onclick="peak_detection()">Peak Detection</button>  &nbsp;&nbsp;<button class="btn btn-primary" style=" font-size: 10px;" onclick="show_voltage()">Show Voltage</button></p>

<p>
<label for="nsignal" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;"> &#8226; CV: &nbsp;&nbsp; </label>
<input type="number"  name="nsignal" id="nsignal" style="width:40px;font-size:12px;" value=1 min=1 max=100/>
<label for="freq" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"> &#8226; Samp. frequency (Hz): &nbsp;&nbsp; </label>
<input type="number"  name="freq" id="freq" style="width:80px;font-size:12px;" value=500000 min=0 max=100000000 />
&nbsp;&nbsp;   <button class="btn btn-primary" style=" font-size: 10px;padding-right:20px;" onclick="calculate_AUC()">Calculate AUC</button>
</p>

<table class ="table-hover" style="width:100%" id="table1">
<tr>
<th id="ip1t"> i<sub>pa</sub> </th>
<th id="ip2t"> i<sub>pc</sub> </th>
<th id="dipt">  Δi </th> <th id="divipt">i<sub>pa</sub>/i<sub>pc</sub>  </th>
<th id="ep2t"> E<sub>pa</sub> </th>
<th id="ep1t"> E<sub>pc</sub> </th>
<th id="dept"> ΔE </th><th id="AUCt"> AUC <br> </th>
</tr>
<tr>
<td contenteditable="true" id="ip1"></td>
<td contenteditable="true" id="ip2"></td>
<td contenteditable="true" id="dip"></td>
<td contenteditable="true" id="divip"></td>
<td contenteditable="true" id="ep1"></td>
<td contenteditable="true" id="ep2"></td>
<td contenteditable="true" id="dep"></td>
<td contenteditable="true" id="AUC"></td>
</tr>
</table>


<br>
<div id="Vgraph"></div>
<br>
<p style="text-align:center;">  <button class="btn btn-primary" style=" font-size: 10px;" onclick="classification()">Classify</button> </p>
<div id="hidden_table" style="display: none;"></div>
</div>
</div>
</div>
<div class="col-md-6">
<div class="box">
<div id="CVs"></div>
<div id="delete" style="margin-left:10px;position:relative;bottom:410px;left:295px;">
<button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteTrace('CVs')">Delete Last</button>
<button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteAllTrace('CVs')">Erase All</button>
</div>
</div>
</div>
</div>
<div class="row sparkboxes mt-4 mb-4">
<div class="col-md-4">
<div class="box box1">
<div id="spark1">
<div style="height: 180px;">
<p style="font-size:20px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><b>Results</b>  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; </p>
<table class ="table-hover center" style="width:80%">
<tr>
<th > p 5-HTi </th>
<th> p 5-HTr </th>
<th> p DA </th>
<th> p HA</th>
<th>p SP</th>
<th> p pH </th>
</tr>
<tr>
<td id="p5ht"></td>
<td id="p5ht2"></td>
<td id="pDA"></td>
<td id="pHA"></td>
<td id="pSP"></td>
<td id="ppH"></td>
</tr>
</table>
<p id = "neurotransmitter" style="margin:20px; font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;">· Neurotransmitter: </p>
</div>
</div></div>
</div>

<div class="col-md-4">
<div class="box box2">
<div id="spark2">
<div class="notepad">
<div class="paper" contenteditable="true">
 Write your notes here.
</div>
</div>
</div>
</div>
</div>

<div class="col-md-4">
<div class="box box3">
<div id="spark3">
<div style="height: 180px;">
<p style="font-size:20px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><b>Export Panel</b> &nbsp;&nbsp;  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <button class="btn btn-primary" style=" font-size: 10px;" onclick="export_function()"> Export to CSV </button></p>
<p style="margin:0">
<label for="namesignalsexp" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"> &#8226; Name: &nbsp;&nbsp; </label>
<input type="text"  name="namesignalsexp" id="namesignalsexp" style="width:150px;font-size:12px;" value=" e.g. 5-HT - HA Simultaneous.csv" />
<a hidden href="#" id="xx" style="">Export as CSV</a>
</p>

<p style="margin:20px; font-size:10px;color:black;font-family:Arial, Helvetica, sans-serif;">The table features, principal components and output probabilities of the neural network will be exported in the csv file.</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<p class="footdash">Dashboard created by The Hashemi Lab, Imperial College London.</p>
</div>

<script>
// Read the data
var table_text;
var ntraces=DataArray[0].length-2;
var Vcol=arrayColumn(DataArray.slice(1,DataArray.length),0);
var coln;
var frequency;
var Vtitle=DataArray[1][ntraces];
var Vunit=Vtitle.split(" ")[1];
var Ititle=DataArray[1][ntraces+1];
var Iunit=Ititle.split(" ")[1];
document.getElementById("ip1t").innerHTML += ' '+String(Iunit);
document.getElementById("ip2t").innerHTML += ' '+String(Iunit);
document.getElementById("dipt").innerHTML += ' '+String(Iunit);
document.getElementById("ep1t").innerHTML += ' '+String(Vunit);
document.getElementById("ep2t").innerHTML += ' '+String(Vunit);
document.getElementById("dept").innerHTML += ' '+String(Vunit);
document.getElementById("AUCt").innerHTML += ' '+String(Iunit)+'(ms)';
var Iarray=DataArray.slice(1,DataArray.length).map(arr => arr.slice(1,ntraces));
var Iarray_original=Iarray;
var count=0;
var Area_array=[];
var px;
var py;
var pindex;
var prev_pindex;
var prev_px=0;
var prev_py=0;
var i_peaks;
var time_array=[];
var count_voltage=false;
var predictions;

//Set the CV plot
var data=[];
var layout = {
width: 450,
height: 450,
legend: {"orientation": "h", "y":-0.3},
xaxis:{
title: Vtitle
},
yaxis:{
title: Ititle
}
};
layout.title = {
text: '<b>Cyclic Voltammograms</b>',
font: {
size: 20,
family:'Arial'
},
x: 0,
y: 1.2,
xanchor: 'left',
yanchor: 'bottom',
};
var config = {
showEditInChartStudio: true,
plotlyServerURL: "https://chart-studio.plotly.com",
displayModeBar: true,
displaylogo: false,
dragmode:'select',
modeBarButtonsToRemove: ['hoverCompareCartesian'],
toImageButtonOptions: {
format: 'svg',
filename: 'plot',
height: 600,
width: 1200,
scale: 1
}};

Plotly.newPlot('CVs', data, layout, config);
// Voltage Program plot
var data2=[];
var layout2 = {
width: 450,
height: 200,
margin: {
l: 5,
r: 5,
b: 0,
t: 25
},
showlegend: false,
annotations: [
{

x: 0.90,
y: 0.10,
xref: 'paper',
yref: 'paper',
text: '<b>Time (ms) →</b>',
showarrow: false,
arrowhead: 7
}
],
xaxis:{
showgrid: false,
zeroline: false,
visible: false
},
yaxis:{
showgrid: false,
zeroline: false,
visible: false
}
};
layout2.title = {
text: '<b>Voltage Programme</b>',
font: {
size: 12,
family:'Arial'
},
x: 0,
y: 0.9,
xanchor: 'left',
yanchor: 'bottom',
};
Plotly.newPlot('Vgraph',data2,layout2,config);
var graphDivV = document.getElementById("Vgraph");
for (var i=0;i<ntraces-1;i++){
coln=arrayColumn(Iarray,i);
Plotly.addTraces("CVs", {y: coln, x:Vcol, name:'('+String(i+1)+') '+DataArray[0][i+1]});
};
// Add a faradaic peak to graph
var myPlot = document.getElementById('CVs');
myPlot.on('plotly_click', function(data){
if(document.getElementById('peak_selection').checked) {
count=count+1;
if (count==1){
for(var i=0; i < data.points.length; i++){
px=data.points[i].x;
py=data.points[i].y;
pindex=data.points[i].pointIndex;
};
} else {
prev_px=px;
prev_py=py;
prev_pindex=pindex;
for(var i=0; i < data.points.length; i++){
px=data.points[i].x;
py=data.points[i].y;
pindex=data.points[i].pointIndex;
};
};
if (count==2){
Plotly.addTraces("CVs", {y: [py], x:[px], name:'i', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'ip'});
Plotly.addTraces("CVs", {y: [py,prev_py], x:[px,prev_px], name:'i',type: 'scatter', showlegend: false, line: {color: 'black', width:0.5, dash: 'dot'}, text:'Δip, ΔEp'});
if (graphDivV.data.length){
Plotly.addTraces("Vgraph", {y: [Vcol[pindex]], x:[time_array[pindex]], name:'E', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'Ep'});
};
// Write to the table:
write_to_table();
}
else if (count>2){
Plotly.deleteTraces("CVs", [-3,-1]);
Plotly.addTraces("CVs", {y: [py], x:[px], name:'i', type: 'scatter', type: 'scatter', showlegend: false, mode:'marker', marker: {color: 'black'},  text:'ip'});
Plotly.addTraces("CVs", {y: [py, prev_py], x:[px, prev_px], name:'i',type: 'scatter',showlegend: false, line: {color: 'black', width:0.5, dash: 'dot'},  text:'ip'});
if (graphDivV.data.length){
if (graphDivV.data.length>2){Plotly.deleteTraces("Vgraph", -2)};
Plotly.addTraces("Vgraph", {y: [Vcol[pindex]], x:[time_array[pindex]], name:'E', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'Ep'});
};
write_to_table();
} else {
Plotly.addTraces("CVs", {y: [py], x:[px], name:'i', type: 'scatter',type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'},  text:'ip'});
if (graphDivV.data.length){
Plotly.addTraces("Vgraph", {y: [Vcol[pindex]], x:[time_array[pindex]], name:'E', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'Ep'});
}};
}});

function peak_detection(){
var content_API;
var signal_number=document.getElementById("nsignal").value;
var coli=arrayColumn(Iarray,parseInt(signal_number)-1);
var current=String(coli.join(" "));
var voltage=String(Vcol.join(" "));
var data_API;
frequency = String(document.getElementById("freq").value);
var i_peaks;
var v_peaks_array=[];
var i_peaks_array=[];
var new_annotations=[];
if (frequency == ""){
Swal.fire({
icon: 'error',
title: "Frequency Error",
text: "Frequency has not been introduced. Please try again converting introducing the sampling frequency of your system."
});
return;
} else if (signal_number==""){
Swal.fire({
icon: 'error',
title: "Signal Selection Error",
text: "No cyclic voltammogram form the plot has been selected. Please try again selecting one of the cyclic voltammograms."
});
return;
};
API_dir3="https://py-dot-neurodatalab.nw.r.appspot.com/cv";
data_API=JSON.stringify({'frequency':frequency, 'current':current,'voltage':voltage});
settings_API = {
async: false,
crossDomain: true,
contentType: 'application/json; charset=utf-8',
dataType: 'text',
xhrFields: {withCredentials: true},
url: API_dir3,
data:data_API,
type: 'post'
};
$.ajax(settings_API).done(function (response_API) {
i_peaks=response_API.split(" ");
i_peaks=i_peaks.map(x => parseInt(x));
});
for (var i=0;i<i_peaks.length;i++){
v_peaks_array.push(Vcol[i_peaks[i]]);
i_peaks_array.push(coli[i_peaks[i]]);
new_annotations.push({
x: Vcol[i_peaks[i]],
y: coli[i_peaks[i]],
xref: 'x',
yref: 'y',
text: '',
showarrow: true,
bordercolor: '#3f51b5',
arrowhead: 7,
ax: 0,
ay: 0
});
};
var layout = {
width: 450,
height: 450,
legend: {"orientation": "h", "y":-0.3},
annotations:new_annotations,
xaxis:{
title: Vtitle
},
yaxis:{
title: Ititle
}
};
layout.title = {
text: '<b>Cyclic Voltammograms</b>',
font: {
size: 20,
family:'Arial'
},
x: 0,
y: 1.2,
xanchor: 'left',
yanchor: 'bottom',
};
Plotly.relayout("CVs", layout);
};

function write_to_table(){
if (prev_py>py || Math.abs(prev_py)>Math.abs(py)){
document.getElementById("ip1").innerHTML = prev_py.toFixed(2);
document.getElementById("ip2").innerHTML = py.toFixed(2);
document.getElementById("dip").innerHTML = parseFloat(prev_py-py).toFixed(2);
document.getElementById("divip").innerHTML = parseFloat(Math.abs(prev_py/py)).toFixed(2);
document.getElementById("ep1").innerHTML = prev_px.toFixed(2);
document.getElementById("ep2").innerHTML = px.toFixed(2);
document.getElementById("dep").innerHTML = parseFloat(prev_px-px).toFixed(2);
} else{
document.getElementById("ip1").innerHTML = py.toFixed(2);
document.getElementById("ip2").innerHTML = prev_py.toFixed(2);
document.getElementById("dip").innerHTML = parseFloat(py-prev_py).toFixed(2);
document.getElementById("divip").innerHTML = parseFloat(Math.abs(py/prev_py)).toFixed(2);
document.getElementById("ep1").innerHTML = px.toFixed(2);
document.getElementById("ep2").innerHTML = prev_px.toFixed(2);
document.getElementById("dep").innerHTML = parseFloat(px-prev_px).toFixed(2);
};
};
function calculate_AUC(){
frequency = parseFloat(document.getElementById("freq").value);
var signal=document.getElementById("nsignal").value;
if (frequency == ""){
Swal.fire({
icon: 'error',
title: "Frequency Error",
text: "Frequency has not been introduced. Please try again converting introducing the sampling frequency of your system."
});
return;
}else if (signal==""){
Swal.fire({
icon: 'error',
title: "Signal Selection Error",
text: "No cyclic voltammogram form the plot has been selected. Please try again selecting one of the cyclic voltammograms."
});
return;
};
for (var i=0;i<ntraces;i++){
Area_array.push(trap_auc(arrayColumn(Iarray,i), frequency));
};
document.getElementById("AUC").innerHTML = Area_array[parseInt(signal)-1].toFixed(4);
};

function show_voltage(){
frequency = parseFloat(document.getElementById("freq").value);
if (frequency == ""){
Swal.fire({
icon: 'error',
title: "Frequency Error",
text: "Frequency has not been introduced. Please try again converting introducing the sampling frequency of your system."
});
return;
} else if(count_voltage==true) {return;};
for (var i=0;i<Vcol.length;i++){
time_array.push((parseFloat(i)/frequency)*1000);
};
Plotly.addTraces("Vgraph", {y: Vcol, x:time_array});
Plotly.relayout("Vgraph",{annotations: [
{
x: 0.05,
y: 0.90,
xref: 'paper',
yref: 'paper',
text: '<b>Scan Rate: '+String(parseInt(Math.abs(Vcol[5]-Vcol[4])*frequency))+' '+Vunit+'/(s) </b>',
showarrow: false,
arrowhead: 7
},
{

x: 0.90,
y: 0.10,
xref: 'paper',
yref: 'paper',
text: '<b>Time (ms) →</b>',
showarrow: false,
arrowhead: 7
}
]});


count_voltage=true;
};
</script>

<script>
function invert_cv(){
Plotly.purge("CVs");
Iarray=Iarray.map(arr => arr.map(x => -x));
data=[];
Plotly.newPlot('CVs', data, layout, config);
for (var i=0;i<ntraces-1;i++){
coln=arrayColumn(Iarray,i);
Plotly.addTraces("CVs", {y: coln, x:Vcol, name:'('+String(i+1)+') '+DataArray[0][i+1]});
};
var myPlot = document.getElementById('CVs');
myPlot.on('plotly_click', function(data){
if(document.getElementById('peak_selection').checked) {

count=count+1;
if (count==1){
for(var i=0; i < data.points.length; i++){
px=data.points[i].x;
py=data.points[i].y;
pindex=data.points[i].pointIndex;
};
} else {
prev_px=px;
prev_py=py;
prev_pindex=pindex;
for(var i=0; i < data.points.length; i++){
px=data.points[i].x;
py=data.points[i].y;
pindex=data.points[i].pointIndex;
};
};
if (count==2){
Plotly.addTraces("CVs", {y: [py], x:[px], name:'i', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'ip'});
Plotly.addTraces("CVs", {y: [py,prev_py], x:[px,prev_px], name:'i',type: 'scatter', showlegend: false, line: {color: 'black', width:0.5, dash: 'dot'}, text:'Δip, ΔEp'});
if (graphDivV.data.length){
Plotly.addTraces("Vgraph", {y: [Vcol[pindex]], x:[time_array[pindex]], name:'E', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'Ep'});
};

// Write to the table:
write_to_table();
}
else if (count>2){
Plotly.deleteTraces("CVs", [-3,-1]);
Plotly.addTraces("CVs", {y: [py], x:[px], name:'i', type: 'scatter', type: 'scatter', showlegend: false, mode:'marker', marker: {color: 'black'},  text:'ip'});
Plotly.addTraces("CVs", {y: [py, prev_py], x:[px, prev_px], name:'i',type: 'scatter',showlegend: false, line: {color: 'black', width:0.5, dash: 'dot'},  text:'ip'});
if (graphDivV.data.length){
if (graphDivV.data.length>2){Plotly.deleteTraces("Vgraph", -2)};
Plotly.addTraces("Vgraph", {y: [Vcol[pindex]], x:[time_array[pindex]], name:'E', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'Ep'});
};
write_to_table();
} else {
Plotly.addTraces("CVs", {y: [py], x:[px], name:'i', type: 'scatter',type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'},  text:'ip'});
if (graphDivV.data.length){
Plotly.addTraces("Vgraph", {y: [Vcol[pindex]], x:[time_array[pindex]], name:'E', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'Ep'});
}};
}});
};
async function classification(){
var  class_names=['5-HT inhibition','5-HT Release','DA', 'HA', 'Switching Peak','pH'];
var Ipa=String(document.getElementById("ip1").innerHTML);
var Epa=String(document.getElementById("ep1").innerHTML);
var Area_under_curve=String(document.getElementById("AUC").innerHTML);
var Epc=String(document.getElementById("ep2").innerHTML);

var API_dir4="https://py-dot-neurodatalab.nw.r.appspot.com/cvClass";
data_API=JSON.stringify({'Ipa':Ipa, 'Epa':Epa,'AUC':Area_under_curve, 'Epc': Epc});
settings_API = {
async: false,
crossDomain: true,
contentType: 'application/json; charset=utf-8',
dataType: 'text',
xhrFields: {withCredentials: true},
url: API_dir4,
data:data_API,
type: 'post'
};
$.ajax(settings_API).done(function (response_API) {
predictions=response_API.split(" ");
});

const model = await tf.loadLayersModel('NNModel/model.json');
var a = tf.tensor1d([Number(predictions[0])]);
var b = tf.tensor1d([Number(predictions[1])]);

// Get the highest confidence prediction from our model
var result = await model.predict([a,b]).dataSync();
var neuro = class_names[indexOfMax(result)];
document.getElementById("p5ht").innerHTML = result[0].toFixed(3);
document.getElementById("p5ht2").innerHTML = result[1].toFixed(3);
document.getElementById("pDA").innerHTML = result[2].toFixed(3);
document.getElementById("pHA").innerHTML = result[3].toFixed(3);
document.getElementById("pSP").innerHTML = result[4].toFixed(3);
document.getElementById("ppH").innerHTML = result[5].toFixed(3);
document.getElementById("neurotransmitter").innerHTML += neuro;
// Write to hidden table for export
table_text =  '\
<table class ="table-hover" style="width:100%">\
';

table_text += '<tr>\
<th> ipa </th>\
<th > ipc </th>\
<th>  Δi </th>\
<th>ipa/ipc</th>\
<th> Epa</th>\
<th> Epc </th>\
<th>  ΔE </th>\
<th> AUC </th>\
</tr>\
<tr>\
<td>'+document.getElementById("ip1").innerHTML+'</td>\
<td>'+document.getElementById("ip2").innerHTML+'</td>\
<td>'+document.getElementById("dip").innerHTML+'</td>\
<td>'+document.getElementById("divip").innerHTML+'</td>\
<td>'+document.getElementById("ep1").innerHTML+'</td>\
<td>'+document.getElementById("ep2").innerHTML+'</td>\
<td>'+document.getElementById("dep").innerHTML +'</td>\
<td>'+document.getElementById("AUC").innerHTML +'</td>\
</tr>\
';

table_text += '<tr>\
<td>-</td>\
<td>-</td>\
<td>-</td>\
<td>-</td>\
<td>-</td>\
<td>-</td>\
<td>-</td>\
<td>-</td>\
</tr>\
';
table_text += '<tr>\
<td>p(5HTi)</td>\
<td>p(5HTr)</td>\
<td>p(DA)</td>\
<td>p(HA)</td>\
<td>p(SP)</td>\
<td>p(pH)</td>\
<td></td>\
<td></td>\
</tr>\
';
table_text += '<tr>\
<td>'+String(result[0])+'</td>\
<td>'+String(result[1])+'</td>\
<td>'+String(result[2])+'</td>\
<td>'+String(result[3])+'</td>\
<td>'+String(result[4])+'</td>\
<td>'+String(result[5])+'</td>\
<td></td>\
<td></td>\
</tr>\
</table>\
';

document.getElementById('hidden_table').innerHTML = table_text;
};
function export_function(){
var namesignalsexp=String(document.getElementById("namesignalsexp").value);
document.getElementById("xx").click();
}

function deleteTrace(divId){
if (count==0){Plotly.deleteTraces(divId, -1);}
else if (count==1){Plotly.deleteTraces(divId, -2);}
else{Plotly.deleteTraces(divId, -4);}
};
function deleteAllTrace(divId){
var myPlot = document.getElementById(divId);
while(myPlot.data.length>0){
Plotly.deleteTraces(divId, 0);
}
};

function reset_all(){
Iarray=Iarray_original;
count=0;
prev_px=0;
prev_py=0;
var count=0;
Area_array=[];
var pindex;
prev_pindex=0;
count_voltage=false;
Plotly.purge("Vgraph");
Plotly.purge("CVs");
document.getElementById("ip1").innerHTML = "";
document.getElementById("ip2").innerHTML = "";
document.getElementById("dip").innerHTML = "";
document.getElementById("divip").innerHTML = "";
document.getElementById("ep1").innerHTML = "";
document.getElementById("ep2").innerHTML = "";
document.getElementById("dep").innerHTML = "";
//Set the CV plot
var data=[];
var layout = {
width: 450,
height: 450,
legend: {"orientation": "h", "y":-0.3},
xaxis:{
title: Vtitle
},
yaxis:{
title: Ititle
}
};
layout.title = {
text: '<b>Cyclic Voltammograms</b>',
font: {
size: 20,
family:'Arial'
},
x: 0,
y: 1.2,
xanchor: 'left',
yanchor: 'bottom',
};
var config = {
showEditInChartStudio: true,
plotlyServerURL: "https://chart-studio.plotly.com",
displayModeBar: true,
displaylogo: false,
dragmode:'select',
modeBarButtonsToRemove: ['hoverCompareCartesian'],
toImageButtonOptions: {
format: 'svg',
filename: 'plot',
height: 600,
width: 1200,
scale: 1
}}

Plotly.newPlot('CVs', data, layout, config);
// Voltage Program plot
var data2=[];
var layout2 = {
width: 450,
height: 200,
margin: {
l: 5,
r: 5,
b: 0,
t: 25
},
showlegend: false,
annotations: [
{

x: 0.90,
y: 0.10,
xref: 'paper',
yref: 'paper',
text: '<b>Time (ms) →</b>',
showarrow: false,
arrowhead: 7
}
],
xaxis:{
showgrid: false,
zeroline: false,
visible: false
},
yaxis:{
showgrid: false,
zeroline: false,
visible: false
}
};
layout2.title = {
text: '<b>Voltage Programme</b>',
font: {
size: 12,
family:'Arial'
},
x: 0,
y: 0.9,
xanchor: 'left',
yanchor: 'bottom',
};
Plotly.newPlot('Vgraph',data2,layout2,config);
var graphDivV = document.getElementById("Vgraph");
for (var i=0;i<ntraces-1;i++){
coln=arrayColumn(Iarray,i);
Plotly.addTraces("CVs", {y: coln, x:Vcol, name:'('+String(i+1)+') '+DataArray[0][i+1]});
}
// Add a faradaic peak to graph
var myPlot = document.getElementById('CVs');
myPlot.on('plotly_click', function(data){
if(document.getElementById('peak_selection').checked) {

count=count+1;
if (count==1){
for(var i=0; i < data.points.length; i++){
px=data.points[i].x;
py=data.points[i].y;
pindex=data.points[i].pointIndex;
};
} else {
prev_px=px;
prev_py=py;
prev_pindex=pindex;
for(var i=0; i < data.points.length; i++){
px=data.points[i].x;
py=data.points[i].y;
pindex=data.points[i].pointIndex;
};
};
if (count==2){
Plotly.addTraces("CVs", {y: [py], x:[px], name:'i', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'ip'});
Plotly.addTraces("CVs", {y: [py,prev_py], x:[px,prev_px], name:'i',type: 'scatter', showlegend: false, line: {color: 'black', width:0.5, dash: 'dot'}, text:'Δip, ΔEp'});
if (graphDivV.data.length){
Plotly.addTraces("Vgraph", {y: [Vcol[pindex]], x:[time_array[pindex]], name:'E', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'Ep'});
};

// Write to the table:
write_to_table();
}
else if (count>2){
Plotly.deleteTraces("CVs", [-3,-1]);
Plotly.addTraces("CVs", {y: [py], x:[px], name:'i', type: 'scatter', type: 'scatter', showlegend: false, mode:'marker', marker: {color: 'black'},  text:'ip'});
Plotly.addTraces("CVs", {y: [py, prev_py], x:[px, prev_px], name:'i',type: 'scatter',showlegend: false, line: {color: 'black', width:0.5, dash: 'dot'},  text:'ip'});
if (graphDivV.data.length){
if (graphDivV.data.length>2){Plotly.deleteTraces("Vgraph", -2)};
Plotly.addTraces("Vgraph", {y: [Vcol[pindex]], x:[time_array[pindex]], name:'E', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'Ep'});
};
write_to_table();
} else {
Plotly.addTraces("CVs", {y: [py], x:[px], name:'i', type: 'scatter',type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'},  text:'ip'});
if (graphDivV.data.length){
Plotly.addTraces("Vgraph", {y: [Vcol[pindex]], x:[time_array[pindex]], name:'E', type: 'scatter',showlegend: false, mode:'marker', marker: {color: 'black'}, text:'Ep'});
}};
}});

};
</script>

</div>

</html>
