<!DOCTYPE html>
<html lang="en">
<title>The Analysis Kid</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Styling/w3.css">
<script src="JavaScriptPackages/fontawesome-828d573e3a.js"></script>
<script type="text/javascript" src="JavaScriptPackages/shim.min.js"></script>
<script type="text/javascript" src="JavaScriptPackages/DashboardMethods.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
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
<h3 class="w3-padding-64"><b>The Analysis<br>Kid</b> </h3>
</div>
<div class="w3-bar-block">
<a href="#top" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="fa fa-home w3-large"></i> Home</a>
<a href="#about" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="fa fa-list" aria-hidden="true"></i> About</a>
<a href="#applications" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="fas fa-chart-line w3-large"></i> Applications</a>
<a href="#documentation" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="fa fa-file-text-o" aria-hidden="true"></i> Documentation</a>
<a href="#contact" onclick="ContactWindow()" class="w3-bar-item w3-button w3-hover-white"><i class="fas fa-paper-plane w3-large"></i> Contact Us</a>
</div>

</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-indigo w3-xlarge w3-padding">
<a href="javascript:void(0)" class="w3-button w3-indigo w3-margin-right" onclick="w3_open()">☰</a>
<span>The Analysis Kid</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

<!-- Header -->
<div class="w3-container" style="margin-top:80px" id="about">
<h1 href="#top" class="w3-jumbo"><b>The Analysis Kid</b> <img style ="float:right" src="/Images/HL_Icon.png" alt="Hashemi Lab Icon" width="375" height="125"></h1>

<h1 class="w3-xxxlarge w3-text-indigo"><b>About.</b></h1>
<hr style="width:800px;border:3px solid #3f51b5" class="w3-round">
<p style="text-align:justify;text-justify: inter-word;"> The Analysis Kid is a web application created by <a href="https://www.hashemilab.com/">The Hashemi Lab</a> with calibration and data analysis tools for fast-scan cyclic voltammetry (FSCV) signals of electroactive molecules.
This is achieved by providing a series of open-source and user-friendly applications that allow visualization, filtering, calibration and analysis of neurochemical signals.
A brief description of the applications can be found below, as well as <a href="#documentation">documentation</a> to get started with the applications.
<p style="text-align:justify;text-justify: inter-word;">The applications have been fully tested on desktop applications of Google Chrome v86, Microsoft Edge v87 and Mozilla Firefox v83.
The use of the applications in any other browser might generate errors and it is not recommended. The web application is in continuous development and any suggestions or bug reports will be welcomed.  Do not hesitate to contact through the contact form, email, The Hashemi Lab twitter or any other social platform available.  </p>
</p>
</div>



<!-- Modal for  videos on click-->
<div id="modal01" class="w3-modal" style="padding-top:0" onclick="this.style.display='none'">
<span class="w3-button w3-xxlarge w3-display-topright w3-white">×</span>
<div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
<iframe id = "video" width="80%" height="500" allowfullscreen=true style="text-align:center;display:block;margin: 0 auto;border-style:none;"></iframe>
<p id="caption" style="color:white"></p>
</div>
</div>

<!-- Applications -->
<div class="w3-container" id="applications" style="margin-top:75px">
<h1 class="w3-xxxlarge w3-text-indigo"><b>Applications.</b></h1>
<hr style="width:800px;border:3px solid #3f51b5" class="w3-round">

<div class="w3-row-padding" id="fscv_analysis">
<div class="w3-half w3-margin-bottom w3-center">
<ul class="w3-ul w3-light-grey">
<li class="w3-indigo w3-xlarge w3-padding-32">FSCV Analysis</li>
<li class="w3-padding-16" style="text-align:justify;text-justify: inter-word;"> FSCV Analysis allows to upload one or more acquisitions in .txt, .csv or .xlsx format.
The application has a user-friendly pipeline to allow visualization, filtering, calibration and analysis of several FSCV signals. Find out more in the <a href="#documentation">documentation</a>. </li>
<li class="w3-padding-16"> <a class="w3-button w3-indigo w3-padding-large w3-hover-black" onclick="FSCVWindow()"> Open application</a> </li>
<li class="w3-padding-16" style="text-align:justify;text-justify: inter-word;"> The Michaelis Menten reuptake analysis can be opened from the FSCV Analysis application. Alternatively, it can also be accessed from the link below by uploading the export file provided by the FSCV Analysis. Find out how to do this in the video tutorials.</li>
<li class="w3-padding-16"> <a class="w3-button w3-indigo w3-padding-large w3-hover-black" onclick="FSCVMichaelisMenten()"> Open reuptake analysis</a>
<select id="reuptake_type" style="float: right;" data-toggle="tooltip" title="Select the number of reuptake mechanisms.">
<option value="one_reuptake">One reuptake</option>
<option value="two_reuptakes">Two reutakes</option>
</select>
</li>
</ul>
</div>
<div class="w3-half w3-margin-bottom w3-center">
<ul class="w3-ul w3-light-grey">
<li class="w3-indigo w3-xlarge w3-padding-32">FSCAV Analysis</li>
<li class="w3-padding-16" style="text-align:justify;text-justify: inter-word;"> FSCAV Analysis allows to upload one or more acquisitions in .txt, .csv or .xlsx format.
The application allows a fast and user-friendly calibration of 5-HT basal measurements. Find out more in the <a href="#documentation">documentation</a>. </li>
<li class="w3-padding-16"> <a class="w3-button w3-indigo w3-padding-large w3-hover-black" onclick="FSCAVWindow()"> Open application</a> </li>
</ul>
</div>
</div>
</div>

<div class="w3-container" id="documentation" style="margin-top:75px">
<h1 class="w3-xxxlarge w3-text-indigo"><b>Documentation.</b></h1>
<hr style="width:800px;border:3px solid #3f51b5" class="w3-round">
<br>

<h4 class=" w3-text-indigo"><b> Example Files </b></h4>
<div class="w3-row-padding">
<div class="w3-col m4 w3-margin-bottom">
<img src="Images/da.png" alt="DA" style="width:50%">
<div class="w3-container">
<h3><b>Dopamine (DA)</b></h3>
<p class="w3-opacity">3,4-dihydroxyphenethylamine</p>
<p><b>FSCV: </b></p>
<p>
<a href="ExampleFiles/fscv_da_example.txt" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_txt_file_example" data-toggle="tooltip" title="Download FSCV txt file example of dopamine."><i class="fas fa-file-alt"></i></button></a>
<a href="ExampleFiles/fscv_da_example.csv" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_csv_file_example" data-toggle="tooltip" title="Download FSCV csv file example of dopamine."><i class="fas fa-file-csv"></i></button></a>
<a href="ExampleFiles/fscv_da_example.xlsx" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_xlsx_file_example" data-toggle="tooltip" title="Download FSCV xlsx file example of dopamine."><i class="fas fa-file-excel"></i></button></a>
</p>

<p><b>Reuptake analysis: </b></p>
<p>
<a href="ExampleFiles/fscv_da_reuptake_example.xlsx" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_txt_file_example" data-toggle="tooltip" title="Download concentration vs time xlsx file example of dopamine for reuptake analysis."><i class="fas fa-file-excel"></i></button></a>
</p>


</div>
</div>
<div class="w3-col m4 w3-margin-bottom">
<img src="Images/5ht.png" alt="5-HT" style="width:46%">
<div class="w3-container">
<h3><b>Serotonin (5-HT)</b></h3>
<p class="w3-opacity">5-hydroxytryptamine</p>
<p><b>FSCV: </b></p>
<p>
<a href="ExampleFiles/fscv_5ht_example.txt" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_txt_file_example" data-toggle="tooltip" title="Download FSCV txt file example of serotonin."><i class="fas fa-file-alt"></i></button></a>
<a href="ExampleFiles/fscv_5ht_example.csv" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_csv_file_example" data-toggle="tooltip" title="Download FSCV csv file example of serotonin."><i class="fas fa-file-csv"></i></button></a>
<a href="ExampleFiles/fscv_5ht_example.xlsx" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_xlsx_file_example" data-toggle="tooltip" title="Download FSCV xlsx file example of serotonin."><i class="fas fa-file-excel"></i></button></a>
</p>
<p><b>FSCAV: </b></p>
<p>
<a href="ExampleFiles/fscav_example.txt" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_txt_file_example" data-toggle="tooltip" title="Download FSCV txt file example."><i class="fas fa-file-alt"></i></button></a>
<a href="ExampleFiles/fscav_example.csv" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_csv_file_example" data-toggle="tooltip" title="Download FSCV csv file example."><i class="fas fa-file-csv"></i></button></a>
<a href="ExampleFiles/fscav_example.xlsx" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_xlsx_file_example" data-toggle="tooltip" title="Download FSCV xlsx file example."><i class="fas fa-file-excel"></i></button></a>
</p>
</p>
</div>
</div>
<div class="w3-col m4 w3-margin-bottom">
<img src="Images/ha.png" alt="HA" style="width:50%">
<div class="w3-container">
<h3><b>Histamine (HA)</b></h3>
<p class="w3-opacity">2-(1H-imidazol-4-yl)ethanamine</p>
<p><b>FSCV: </b></p>
<p>
<a href="ExampleFiles/fscv_ha_example.txt" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_txt_file_example" data-toggle="tooltip" title="Download FSCV txt file example of histamine."><i class="fas fa-file-alt"></i></button></a>
<a href="ExampleFiles/fscv_ha_example.csv" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_csv_file_example" data-toggle="tooltip" title="Download FSCV csv file example of histamine."><i class="fas fa-file-csv"></i></button></a>
<a href="ExampleFiles/fscv_ha_example.xlsx" download><button class="w3-button w3-indigo w3-hover-black" name="fscv_xlsx_file_example" data-toggle="tooltip" title="Download FSCV xlsx file example of histamine."><i class="fas fa-file-excel"></i></button></a>
</p>
</div>
</div>
</div>

<br>
<h4 class=" w3-text-indigo"><b> Publications and Video Tutorials </b></h4>
<br>

<div class="w3-row-padding">
<div class="w3-col m4 w3-margin-bottom">
<img src="Images/fscv_color.png" alt="FSCV colorplot" style="width:50%">
<div class="w3-container">
<h3><b>FSCV Analysis</b></h3>

<p>
<button class="w3-button w3-indigo w3-hover-black" name="Video tutorial for FSCV Analysis" value = "https://www.youtube.com/embed/8wn4FAnMcAI" onclick="video_modal_window(this)">Watch Video</button>
</p>
<p>
<a href="https://pubs.acs.org/doi/10.1021/acsmeasuresciau.1c00003"><button class="w3-button w3-indigo w3-hover-black" >See Publication</button></a>
</p>
</div>
</div>
<div class="w3-col m4 w3-margin-bottom">
<img src="Images/fscav_color.png" alt="FSCAV colorplot" style="width:50%">
<div class="w3-container">
<h3><b>FSCAV Analysis</b></h3>

<p>
<button class="w3-button w3-indigo w3-hover-black" name="Video tutorial for FSCAV Analysis" value = "https://www.youtube.com/embed/knphV1Wfi_0" onclick="video_modal_window(this)">Watch Video</button>
</p>
<p>
<a href="https://pubs.acs.org/doi/10.1021/acsmeasuresciau.1c00060"><button class="w3-button w3-indigo w3-hover-black" >See Publication</button></a>
</p>

</div>
</div>
</div>
</div>


<footer class="w3-content w3-padding-64 w3-text-black w3-center">
<p> <a href="#top" class="w3-button w3-black"><i class="fa fa-arrow-up "></i>To the top</a></p>
<p class="w3-large">
<a href = "mailto:phashemi@imperial.ac.uk?subject = Feedback&body = Message"><i class="fa fa-envelope"></i></a>
<a href="https://twitter.com/HashemiLab"><i class="fab fa-twitter"></i></a>
</p>
<p class="w3-small"><a href="https://www.hashemilab.com/">The Hashemi Lab</a></p>
<p class="w3-small">Imperial College London & University of South Carolina</p>
<p class="w3-small">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank" class="w3-hover-text-green">w3.css</a></p>
</footer>
</div>
<div class="w3-light-grey w3-container w3-padding-32" style="height:300px; margin-top:-300px"></div>

<script>
// Script to open and close sidebar from w3.
function w3_open() {
_("mySidebar").style.display = "block";
_("myOverlay").style.display = "block";
}
function w3_close() {
_("mySidebar").style.display = "none";
_("myOverlay").style.display = "none";
}
// Modal Image Gallery
function video_modal_window(element) {
_("video").src = element.value;
_("modal01").style.display = "block";
_("caption").innerHTML = element.name;
};


// Script to open applications depending on plot selected
// Contact pop up window.
function ContactWindow(){
window.open(encodeURI('ContactForm.php'), "", "width=500,height=550",'resizesable=yes');
}

//Callback for the FSCAV Application.
function FSCAVWindow(){
window.open(encodeURI('FSCAVCalibration.php'), "");
}
// Callback for the FSCV application.
function FSCVWindow(){
window.open(encodeURI('FSCVCalibration.php'), "");
};
// Callback for the FSCV application.
function FSCVMichaelisMenten(){
if(_('reuptake_type').value == "one_reuptake"){window.open(encodeURI('FSCVMichaelisMenten1.php'), "")}
else{window.open(encodeURI('FSCVMichaelisMenten2.php'))};
};

</script>

</html>
