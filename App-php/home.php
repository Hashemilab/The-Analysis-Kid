<!DOCTYPE html>
<html lang="en">
<title>Analysis Kid</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Styling/w3.css">
<link rel="stylesheet" href="Styling/progressbar.css">
<script src="JavaScriptPackages/fontawesome-828d573e3a.js"></script>
<script type="text/javascript" src="JavaScriptPackages/shim.min.js"></script>
<script lang="javascript" src="JavaScriptPackages/xlsx.full.min.js"></script>
<script lang="javascript" src="JavaScriptPackages/jszip.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>

<?php
use google\appengine\api\mail\Message;
?>

<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
.w3-half img:hover{opacity:1}
input[type=number] {
border: 0px solid black;
border-radius: 6px;
background-color: #F0F0F0;
}
input[type=text] {
border: 0px solid black;
border-radius: 6px;
background-color: #F0F0F0;
}
.se-pre-con {
position: fixed;
left: 0px;
top: 0px;
width: 100%;
height: 100%;
z-index: 9999;
background: url("Images/loading.gif") center no-repeat #eff4f7;
}
.br2 {
height:1px;
}
</style>

<script>
$(window).on('load', function () {
$(".se-pre-con").fadeOut("slow");
});
</script>

<head>
<link rel="shortcut icon" href="Images/cv.png"/>
</head>

<body>
<div id="loading" class="se-pre-con"></div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-indigo w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
<a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
<div class="w3-container">
<h3 class="w3-padding-64"><b>FSCV<br>Datalab</b></h3>
</div>
<div class="w3-bar-block">
<a href="#top" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="fa fa-home w3-large"></i> Home</a>
<a href="#about" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="fa fa-list" aria-hidden="true"></i> About</a>
<a href="#dashboards" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="fas fa-chart-line w3-large"></i> Dashboards</a>
<a href="Documentation.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="fa fa-file-text-o" aria-hidden="true"></i> Documentation</a>
<a href="#references" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="fa fa-book" aria-hidden="true"></i> References</a>
<a href="#acknowledgments" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="fa fa-users" aria-hidden="true"></i> Acknowledgments</a>
</div>
<br>
<br>
&emsp;&emsp; &thinsp;&thinsp;&thinsp; <a href="#contact" onclick="ContactWindow()" class="w3-bar-item w3-center w3-button w3-hover-white">Contact Us <i class="fas fa-paper-plane w3-large"></i></a>

</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-indigo w3-xlarge w3-padding">
<a href="javascript:void(0)" class="w3-button w3-indigo w3-margin-right" onclick="w3_open()">☰</a>
<span>Analysis Kid</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

<!-- Header -->
<div class="w3-container" style="margin-top:80px" id="about">
<h1 href="#top" class="w3-jumbo"><b>Analysis Kid</b></h1>
<h1 class="w3-xxxlarge w3-text-indigo"><b>About.</b></h1>
<hr style="width:800px;border:3px solid #3f51b5" class="w3-round">
<p  align=”justify”> Analysis Kid is a web application that offers a data analysis tool for Fast Scan Cyclic Voltammetry (FSCV) signals of real-time measurement of neurotransmitter dynamics in
vitro and in vivo. This is achieved by providing a series of open-source and user-friendly dashboards with automatic algorithms that analise FSCV neurochemical data both qualitatively and quantitatively.
The general description of the implemented dashboards at the time of writing can be found below. Extensive information of the algorithms and technical requirements for each of the dashboards can be found in the documentation <a href ="Documentation.php" target="_blank">here</a>.
<p  align=”justify”>The web application is currently in development and any suggestions, bugs or errors will be welcomed. Error handling is also in development and the application might be irresponsive to specific errors.
Do not hesitate to contact through the contact form, email or any other social platform available.  </p>
</p>
<h2 class="w3-large w3-text-indigo"><b>FSCV Visual</b></h2>
<p  align=”justify”>The purpose of FSCV Visual is to provide fundamental tools to analise FSCV data in its three main different formats:
<ul>
<li><b>FSCV Color Plot</b></li>
</ul>
This data dashboard allows the visualization of stacked cyclic voltammograms (CVs) obtained throughout a whole experiment in a 2D matrix, which can be plotted as a 3D surface plot,
a heatmap or a contour plot. A filtering panel is provided to smooth the 2D current matrix by 2D convolution or low-pass filtering in the 2D FFT domain. The dashboard also allows to manually select individual
1D current-time transients and CVs and convert the traces to concentration. A export panel allows to retrieve of the calibrated transients and/or the filtered FSCV color plot.
<ul>
<li><b>1D Transient of neurotransmitter release </b></li>
</ul>
1D Transients are the horizontal lines of the FSCV color plot, usually taken for the peak faraic currents of the stack of CVs. They represent the concentration dynamics of the neurotransmitter throughout the experiment.
This dashboard allows the visualization of multiple current-time or concentration-time traces. The dashboard also includes automatic peak finding for each of the traces, as well as a calculation of area under the curve (AUC).
Additionally, an exponential decay is automatically fitted to the post-peak recovery of the concentration trace, from which the half-life (t½) of the neurotransmitter is estimated. Finally, another principal feature of the dashboard
is the calculation of the average 1D transient and the automatic iterative fiting of a Michaelis Menten ordinary differential equation to the average trace. All the parameters calculated over the traces and their statistical analysis can be exported in a csv file.
<ul>
<li><b>Cyclic Voltammogram of neurotransmitter faradaic reaction </b></li>
</ul>
The i-V plot dashboard allows the visualisation, analysis and classification of faradaic peaks in a CV. The user can upload several CVs obtained with the same voltage waveform.
After that, an interactive graphic tool allows the user selection of two points in the CV that represent the faradaic oxidation and reduction peaks. The dashboard then will automatically calculate a series of features from the cyclic voltammogram
that identify the faradaic reaction. A pre-trained light-weight neural network model is then used to classify the selected faradaic event. Currently, only 5-HT, HA, DA, pH changes and certain capacitive switching peaks are recognised by the neural network.
The features of the CV, together with the class probabilities calculated by the neural network can be exported by the user as a csv file.
</p>
<h2 class="w3-large w3-text-indigo"><b>Kinetic Calibration</b></h2>
The traditional flow-cell analysis calibration approach to convert current traces to concentration oversimplifies the nature of the faradaic reaction taking place at the electrode surface. The kinetic calibration section of Analysis Kid allows the deconvolution
of mass transport from the estimation of the surface concentration of the neurotransmitter over time to obtain a more accurate concentration profile. The user is required to input the range of samples in the cyclic voltammograms that correspond to the oxidation of the neurotransmitter,
as well as experimental kinetic parameters described in the <a href="Documentation.php">documentation</a> of the dashboard.
<h2 class="w3-large w3-text-indigo"><b>Electrode Calibration</b></h2>
This section belongs to a standby project to improve the calibration of FSCV data obtained with Carbon Fibre Microelectrodes (CFM) by studying the different characteristics of CFM and the acquisition system used. The final purpose of the dashboard is to provide a more accurate and robust
calibration and allow the use of electrodes of different sizes and characteristics. A high experimental component is required to characterize the signal coming from different carbon fibres. Due to the Covid 19 outbreak in the United Kingdom this project is currently stopped but expected to relauch in the future.
</div>



<!-- Modal for full size images on click-->
<div id="modal01" class="w3-modal w3-white" style="padding-top:0" onclick="this.style.display='none'">
<span class="w3-button w3-white w3-xxlarge w3-display-topright">×</span>
<div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
<img id="img01" class="w3-image">
<p id="caption"></p>
</div>
</div>

<!-- Dashboards -->
<div class="w3-container" id="dashboards" style="margin-top:75px">
<h1 class="w3-xxxlarge w3-text-indigo"><b>Dashboards.</b></h1>
<hr style="width:800px;border:3px solid #3f51b5" class="w3-round">

<div class="w3-row-padding" id="fscv">
<div class="w3-half w3-margin-bottom w3-center">
<ul class="w3-ul w3-light-grey">
<form id="upload_form" enctype="multipart/form-data" method="post">
<li class="w3-indigo w3-xlarge w3-padding-32">FSCV Visual</li>
<li class="w3-padding-16"> <input type="file" name="file1" id="file1" onchange="uploadFile('file1','progressBar1','status1')"><br> </li>
<li class="w3-padding-16">  <progress id="progressBar1" value="0" max="100" style="width:200px;"></progress><p id="status1"> Upload a compatible file before opening the dashboard.</p> </li>
<li class="w3-padding-16">
<br>
<label for="FSCVColorplot"><input type="radio" id="FSCVColorplot" name="typeofplot" value="FSCVColorplot">FSCV Color Plot</label>
<br>
<br>
<label for="SingleTransient"><input type="radio" id="SingleTransient" name="typeofplot" value="SingleTransient">1D Transient</label>
<br>
<br>
<label  for="CVPlot"><input  type="radio" id="CVPlot" name="typeofplot" value="CVPlot">i-V plot</label>
<br>
<br>
</li>
<li class="w3-padding-16"> <a class="w3-button w3-indigo w3-padding-large w3-hover-black" onclick="VisualWindow(DataArray)"> Open Dashboard</a> </li>
<li class="w3-padding-16"> Documentation on file format, algorithms and type of plot can be found <a href ="Documentation.php" target="_blank">here</a>.</li>
</form>
</ul>
</div>



<div class="w3-half w3-margin-bottom w3-center" >
<ul class="w3-ul w3-light-grey">
<form id="upload_form2" enctype="multipart/form-data" method="post">
<li class="w3-indigo w3-xlarge w3-padding-32"> Kinetic Calibration</li>
<li class="w3-padding-16"> <input type="file" name="file2" id="file2" onchange="uploadFile('file2','progressBar2','status2');"><br> </li>
<li class="w3-padding-16">  <progress id="progressBar2" value="0" max="100" style="width:200px;"></progress><p id="status2"> Upload a compatible file before opening the dashboard.</p> </li>
<li class="w3-padding-16"><p style="margin:1px;"><label for="n3">&#8226; Sampling Frequency (Hz): &nbsp;&nbsp; </label>
<input type="number" step="1" name="n3" id="n3" style="width: 70px;" value=500000 /> Hz </p>
<p style="margin:1px;"><label for="n4">&#8226; Valency of faradaic reaction (n): &nbsp;&nbsp; </label>
<input type="number" step="1" name="n4" id="n4" style="width: 70px;" value=2 /> e<sup>-</sup> </p>
<p style="margin:1px;"><label for="n5">&#8226; Electrode surface (n): &nbsp;&nbsp; </label>
<input type="number" step="1" name="n5" id="n5" style="width: 70px;" value=3300 /> μm<sup>2</sup> </p>
</li>
<li class="w3-padding-16">
<p style="margin:1px;"><label for="n6">&#8226; Start sample AUC: &nbsp;&nbsp; </label>
<input type="number" step="1" name="n6" id="n6" style="width: 70px;" value="<?php echo htmlspecialchars($_POST['n4']);?>"/></p>
<p style="margin:1px;"><label for="n7">&#8226; End sample AUC: &nbsp;&nbsp; </label>
<input type="number" step="1" name="n7" id="n7" style="width: 70px;" value="<?php echo htmlspecialchars($_POST['n4']);?>"/></p>
</li>
<li class="w3-padding-16"> <a class="w3-button w3-indigo w3-padding-large w3-hover-black" onclick="ConvWindow(DataArray)"> Open Dashboard</a></li>
<li class="w3-padding-16" id="deconvolution_message"> Documentation on file format, algorithms and type of plot can be found <a href ="Documentation.php" target="_blank">here</a>.</li>
</form>
</ul>
</div>

</div>

<div class="w3-row-padding">
<div class="w3-half w3-margin-bottom w3-center">
<ul class="w3-ul w3-light-grey">
<li class="w3-dark-grey w3-xlarge w3-padding-32">Electrode Calibration</li>
<li class="w3-padding-16"><p><label for="n1">&#8226; Electrode length (h): &nbsp;&nbsp;&nbsp;&nbsp; </label>
<input type="number" step="0.01" name="n1" id="n1" style="width: 70px;" value="<?php echo htmlspecialchars($_POST['n1']);?>"/> µm</li>
<li class="w3-padding-16"><label for="n2">&#8226; Carbon fibre diametre (d): &nbsp;&nbsp;&nbsp;&nbsp; </label>
<input type="number" step="0.01" name="n2" id="n2" style="width: 70px;" value="<?php echo htmlspecialchars($_POST['n2']);?>" /> µm</li>
<li class="w3-padding-16"><button class="w3-button w3-indigo w3-padding-large w3-hover-black" onclick="surf_calculation()"> Calculate</button></li>
<li class="w3-padding-16" id="surface"> Introduce the electrode length and diameter of your experiment.</li>
</ul>
</div>
<img src="Images/vertip.svg" alt="CFM sketch of diameter and length" style="width:400px;height:400px;border:0;" onclick="onClick(this)">
</div>


<div class="w3-row-padding" id="fscav">
<div class="w3-half w3-margin-bottom w3-center">
<ul class="w3-ul w3-light-grey">
<form id="upload_form3" enctype="multipart/form-data" method="post">
<li class="w3-indigo w3-xlarge w3-padding-32">FSCAV Calibration</li>
<li class="w3-padding-16"> <input type="file" name="file3" id="file3" onchange="uploadFile('file3','progressBar3','status3')"><br> </li>
<li class="w3-padding-16">  <progress id="progressBar3" value="0" max="100" style="width:200px;"></progress><p id="status3"> Upload a compatible file before opening the application.</p> </li>
<li class="w3-padding-16"> <label for="FSCAV_neurotransmitter"><input type="radio" id="FSCAV_neurotransmitter" name="FSCAV_neurotransmitter" value="5-HT" checked> 5-HT</label> </li>
<li class="w3-padding-16">
<p style="margin:1px;"><label for="n8">&#8226; Sampling Frequency (Hz): &nbsp;&nbsp; </label>
<input type="number" step="1" name="n8" id="n8" style="width: 70px;" value=500000 /> Hz </p>
<p style="margin:1px;"><label for="n9">&#8226; Voltage Units : &nbsp;&nbsp; </label>
<input type="text" name="n9" id="n9" style="width: 40px;" value="V" />
<label for="n10">&#8226; Current Units : &nbsp;&nbsp; </label>
<input type="text" name="n10" id="n10" style="width: 40px;" value="nA" /> </p>
</li>
<li class="w3-padding-16"> <a class="w3-button w3-indigo w3-padding-large w3-hover-black" onclick="FSCAVWindow(DataArray)"> Open Application</a> </li>
<li class="w3-padding-16"> Documentation on file format, algorithms and type of plot can be found <a href ="Documentation.php" target="_blank">here</a>.</li>
</form>
</ul>
</div>

<div class="w3-half w3-margin-bottom w3-center">
<ul class="w3-ul w3-light-grey">
<li class="w3-indigo w3-xlarge w3-padding-32">Links</li>
<li class="w3-padding-16"> Link to Michaelis Menten fitting application developed by Solene Dietsch.</li>
<li class="w3-padding-16"> <a class="w3-button w3-indigo w3-padding-large w3-hover-black" href="https://hashemilabapp.herokuapp.com/"  target="_blank"> Open Application</a></li>
</div>

</div>
<?php include("ProgressBar.php");?>
<?php include("parseFile.php");?>
</div>

<div class="w3-container" id="references" style="margin-top:75px">
<h1 class="w3-xxxlarge w3-text-indigo"><b>References.</b></h1>
<hr style="width:800px;border:3px solid #3f51b5" class="w3-round">
<p><cite>[1]	S. Samaranayake et al., “A voltammetric and mathematical analysis of histaminergic modulation of serotonin in the mouse hypothalamus,” J. Neurochem., pp. 374–383, Aug. 2016, doi: 10.1111/jnc.13659.
</cite></p>

<p><cite>[2]	N. Elgrishi, K. J. Rountree, B. D. McCarthy, E. S. Rountree, T. T. Eisenhart, and J. L. Dempsey, “A Practical Beginner’s Guide to Cyclic Voltammetry,” J. Chem. Educ., vol. 95, no. 2, pp. 197–206, Feb. 2018, doi: 10.1021/acs.jchemed.7b00361.</cite></p>

<p><cite>[3]	V. Dumoulin and F. Visin, “A guide to convolution arithmetic for deep learning,” Mar. 2016. </cite></p>

<p><cite>[4]	A. Quarteroni, R. Sacco, and F. Saleri, “Numerical Mathematics,” Springer, Lausanne, Switzerland, 2007. </cite></p>

<p><cite>[5]	J. Tellinghuisen, “Statistical error propagation,” J. Phys. Chem. A, vol. 105, no. 15, pp. 3917–3921, Apr. 2001, doi: 10.1021/jp003484u. </cite></p>

<p><cite>[6]	K. M. Wood, A. Zeqja, H. F. Nijhout, M. C. Reed, J. Best, and P. Hashemi, “Voltammetric and mathematical evidence for dual transport mediation of serotonin clearance in vivo,” J. Neurochem., vol. 130, no. 3, pp. 351–359, 2014, doi: 10.1111/jnc.12733. </cite></p>

<p><cite>[7]	H. P. Gavin, “The Levenberg-Marquardt algorithm for nonlinear least squares curve-fitting problems,” 2019. </cite></p>

<p><cite>[8]	C. W. Atcherley, N. D. Laude, E. B. Monroe, K. M. Wood, P. Hashemi, and M. L. Heien, “Improved Calibration of Voltammetric Sensors for Studying Pharmacological Effects on Dopamine Transporter Kinetics in Vivo,” ACS Chem. Neurosci., vol. 6, no. 9, pp. 1509–1516, Jul. 2014, doi: 10.1021/cn500020s.</cite></p>

<p><cite>[9]	S. M. Riad, “The Deconvolution Problem: An Overview,” Proc.  IEEE, vol. 76, no. 1, pp. 82–85, 1986.</cite></p>
</div>

<div class="w3-container" id="acknowledgments" style="margin-top:75px">
<h1 class="w3-xxxlarge w3-text-indigo"><b>Acknowledgements.</b></h1>
<hr style="width:800px;border:3px solid #3f51b5" class="w3-round">
<h2 class="w3-large w3-text-indigo"><b>Project Acknowledgements.</b></h2>
<p style="text-align: center">My first sincere gratitude goes to Dr. Parastoo Hashemi, Senior Lecturer at Imperial College London (ICL) and supervisor of this MSc project, for her constant support, guidance and dynamism throughout the whole project. Even during Covid19 lockdown times, she has given her best to help us to keep the team connected and find the right research questions together. I also hugely thank The Hashemi Lab team at the University of South Carolina (USC) for providing the FSCV signals used to build and optimise the algorithms. Especially, I would like to thank Shane N. Berger, Graduate Student at USC for his invaluable help providing signals crucial to build the algorithms, great physiological knowledge on Histamine modulation of Serotonin and patience answering my science questions. </p>
<p style="text-align: center"> Across the pond, I would like to thank Melissa F. Hexter, PhD student at ICL for her warming welcome and support when I first joined the laboratory, as well as Solene P. Dietsch and Nathan J. Robins, MSc students at ICL, for out enriching meetings to discuss our projects.  </p>
<p style="text-align: center"> I would also like to thank the whole online programming community of StackOverflow who have offered an invaluable technical help building this website and answered many of my toughest coding questions during lockdown.</p>
<p style="text-align: center"> At last but not least, all my gratitude to my family, friends and my partner who have emotionally helped me to complete this project.</p>
<h2 class="w3-large w3-text-indigo"><b>Software Acknowledgements.</b></h2>
<p> Analysis Kid may utilize the following copyrighted software or programming libraries and therefore acknowledged: </p>
<ul>
<li><a href="https://plotly.com/">Plotly software package</a> in Javascript for the plotting of signals and interactive algorithms</li>
<li><a href="https://apexcharts.com/">Apexcharts software package</a> in Javascript for the plotting of signals and interactive algorithms</li>
<li><a href="https://www.tensorflow.org/">Tensorflow</a> and <a href="https://keras.io/">Keras</a> for the creation and training of neural networks and prediction algorithms</li>
<li><a href="https://numpy.org/" >Numpy</a>, <a href="https://www.scipy.org/" >SciPy</a>, <a href="https://lmfit.github.io/lmfit-py/" >lmfit</a> and <a href="https://pandas.pydata.org/" >Pandas</a> libraries for the data analysis and handling of signals </li>
<li><a href="https://flask.palletsprojects.com/en/1.1.x/quickstart/" >Flask</a> library for the creation of a data analysis API service in Python</li>
<li> <a href="https://www.w3schools.com/" >w3schools</a> for partial CSS styling of the website </li>
</ul>
</div>

<footer class="w3-content w3-padding-64 w3-light-grey w3-text-black w3-center">
<p> <a href="#top" class="w3-button w3-black"><i class="fa fa-arrow-up "></i>To the top</a></p>

<p class="w3-large">
<a href = "mailto:sergio.mena19@imperial.ac.uk?subject = Feedback&body = Message"><i class="fa fa-envelope"></i></a>
<a href="https://twitter.com/sermeor"><i class="fab fa-twitter"></i></a>
<a href="https://www.linkedin.com/in/sergio-mena-ortega-a418ab120/"><i class="fab fa-linkedin-in"></i></a>
<a href="https://teams.microsoft.com/"><img src="https://img.icons8.com/ios-filled/50/000000/microsoft-team-2019.png" width="25" height="25"/></a>

</p>
<p class="w3-small"><a href="https://www.hashemilab.com/">The Hashemi Lab</a></p>
<p class="w3-small">Imperial College London</p>
<p class="w3-small">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank" class="w3-hover-text-green">w3.css</a></p>
</footer>
</div>


<script>
// Script to open and close sidebar from w3.
function w3_open() {
document.getElementById("mySidebar").style.display = "block";
document.getElementById("myOverlay").style.display = "block";
}
function w3_close() {
document.getElementById("mySidebar").style.display = "none";
document.getElementById("myOverlay").style.display = "none";
}
// Modal Image Gallery
function onClick(element) {
document.getElementById("img01").src = element.src;
document.getElementById("modal01").style.display = "block";
var captionText = document.getElementById("caption");
captionText.innerHTML = element.alt;
}
</script>

<script>
// Script to open Dashboards depending on plot selected
var DataArray;
function VisualWindow(DataArray) {
var plot_selected;
var typeofplot = document.getElementsByName('typeofplot');
for(i = 0; i < typeofplot.length; i++) {
if(typeofplot[i].checked)
plot_selected=typeofplot[i].value;
}
if(plot_selected=="FSCVColorplot"){
var myVisualWindow = window.open(encodeURI('FSCVisualColorPlot.php'), "");
myVisualWindow.DataArray=DataArray;
}

if(plot_selected=="SingleTransient"){
var myVisualWindow = window.open(encodeURI('FSCVisualTransient.php'), "");
myVisualWindow.DataArray=DataArray;
}
if(plot_selected=="CVPlot"){
var myVisualWindow = window.open(encodeURI('FSCVisualiVPlot.php'), "");
myVisualWindow.DataArray=DataArray;
}
}
function ContactWindow(){
var myVisualWindow = window.open(encodeURI('ContactForm.php'), "", "width=500,height=550",'resizesable=yes');
}

function ConvWindow(DataArray) {
var f=document.getElementById("n3").value;
var valency=document.getElementById("n4").value;
var surface=document.getElementById("n5").value;
var startAUC=document.getElementById("n6").value;
var endAUC = document.getElementById("n7").value;
var content_API;
if (f>0 && valency>0 && surface>0) {
var myVisualWindow2 = window.open(encodeURI('FSCVConvolution.php'), "");
myVisualWindow2.freqy = parseFloat(f);
myVisualWindow2.n = parseInt(valency);
myVisualWindow2.surface = parseFloat(surface);
myVisualWindow2.DataArray=DataArray;
myVisualWindow2.startAUC=startAUC;
myVisualWindow2.endAUC=endAUC;
}  else {document.getElementById("deconvolution_message").innerHTML = "Only positive integers and decimals are allowed.";}
}
//Callback for the FSCAV Application.
function FSCAVWindow(DataArray){
var list_of_neurotransmitters = document.getElementsByName('FSCAV_neurotransmitter');
var frequency = document.getElementById("n8").value;
var v_units = document.getElementById("n9").value;
var c_units = document.getElementById("n10").value;
for(i = 0; i < list_of_neurotransmitters.length; i++) {
if(list_of_neurotransmitters[i].checked)
neurotransmitter = list_of_neurotransmitters[i].value;
};
var myVisualWindow3 = window.open(encodeURI('FSCAVCalibration.php'), "");
myVisualWindow3.DataArray = DataArray;
myVisualWindow3.neurotransmitter = neurotransmitter;
myVisualWindow3.frequency = frequency;
myVisualWindow3.v_units = v_units;
myVisualWindow3.c_units = c_units;
}
function surf_calculation() {
var h = parseFloat(document.getElementById("n1").value);
var d = parseFloat(document.getElementById("n2").value);
if (h>0 && d>0) {
var surface= Math.PI*Math.pow(d/2, 2)+2*Math.PI*(d/2)*h;
var surface = surface.toFixed(2);
document.getElementById("surface").innerHTML ="Surface of the electrode is " + surface.bold()+ ' <b>µm<sup>2</sup></b>';
}
else {document.getElementById("surface").innerHTML = "Only positive integers and decimals are allowed.";}
}
</script>

</html>
