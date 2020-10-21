<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Documentation</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="Styling/w3.css">
<script src='https://cdn.plot.ly/plotly-latest.min.js'>
<script src="https://kit.fontawesome.com/828d573e3a.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://kit.fontawesome.com/828d573e3a.js"></script>
<script type="text/javascript" src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script type="text/javascript" id="MathJax-script" async
  src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js">
</script>
<style>

.topnav {
  overflow: hidden;
  background-color: #333;

}

.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;

  width:25%;
  text-align: center;

}

.topnav a:visited {
  background-color: #ddd;
  color: white;
}

.topnav a:focus {
  background-color: #3f51b5;
  color: white;
}


.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #3f51b5;
  color: white;
}


.topnav .icon {
  display: none;
}
@media screen and (max-width: 600px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }

}
</style>

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


  <style type="text/css">
  .tg  {border-collapse:collapse;border-spacing:0;}
  .center {
  margin-left: auto;
  margin-right: auto;
}
.centerdiv {
  margin: auto;
  width: 50%;
  border: 3px solid #3f51b5;
  padding: 10px;
}
  .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
    overflow:hidden;padding:10px 5px;word-break:normal;}
  .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
    font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
  .tg .tg-c4ww{background-color:#cbcefb;text-align:center;vertical-align:top}
  .tg .tg-pbtr{background-color:#ffccc9;font-weight:bold;text-align:center;vertical-align:top}
  .tg .tg-3l34{background-color:#9aff99;font-weight:bold;text-align:center;vertical-align:top}
  .tg .tg-8m8h{background-color:#cbcefb;font-weight:bold;text-align:center;vertical-align:top}
  .tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
  .tg .tg-cmwg{background-color:#ffccc9;text-align:center;vertical-align:top}
  .tg .tg-8gdt{background-color:#9aff99;text-align:center;vertical-align:top}
  .tg .tg-kt43{background-color:#fffc9e;font-weight:bold;text-align:center;vertical-align:top}
  .tg .tg-hafo{background-color:#fffc9e;text-align:center;vertical-align:top}
  </style>
<link rel="shortcut icon" href="cv.png"/>

</head>
<body>
  <div class="topnav" id="myTopnav">
    <a href="#home" id="home">Home</a>
    <a href="#FSCVVisual"  id="FSCVVisual">FSCV Visual</a>
    <a href="#CONV"  id="CONV">Kinetic Calibration</a>
    <a href="#ELECT"  id="ELECT">Electrode Calibration</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
     <i class="fa fa-bars"></i>
    </a>
  </div>



<div class="homeW" style = "margin:30px 2%;">
<h1 class="w3-xxxlarge w3-text-indigo" ><b>Documentation</b></h1>
<hr style="width:800px;border:3px solid #3f51b5;" class="w3-round";>
<p align=”justify”  >The main objective of the documentation given here is to provide FSCV Datalab users a general description of the dashboards and the algorithms implemented in each of the dashboards. This documentation also describes the data input formats and structure required to use the web application, as well as the technical requirements of FSCV Datalab. The aim of the application is to provide data analysis automatic tools to scientists inexperienced in the use of program-based computing environments.
  It is initially designed for <a href="https://en.wikipedia.org/wiki/Monoamine_neurotransmitter">monoamine neurotransmitter</a>
   voltammetric measurements with <a href="https://en.wikipedia.org/wiki/Fast-scan_cyclic_voltammetry">Fast Scan Cyclic Voltammetry (FSCV)</a>. The algorithms are designed and trained with Histamine release and Serotonin inhibition simultaneous measurements in rodents premammillary nucleus <a href="/home.php#references"> [1]</a>, although any neurotransmitter release FSCV data can be suitable given that the format and structure of the files are maintained.
  The general requirements of the uploaded files are as follows:
</p>
<ul>
  <li>All files must be uploaded in Comma Separated Values (<b>.csv</b>) format, Excel Spreadsheet (<b>.xlsx</b>) or tabulated Plain Text file (<b>.txt</b>) with a structure defined by the specific dashboard</li>
  <li>At the time of writing, the algorithm does not have <b>error handling</b> for broken files or files with a different structure to the one provided in the documentation</li>
  <li>The web application is currently run on a F1-micro virtual machine: it is encouraged to upload files sizes below <b>15 Mb</b>, being <b>32 Mb</b> the file size limit</li>
    <li>The html files together with css style and javascript functions are optimized to be used in Google Chrome (v84.0.4147.105) on Windows machines. Some functionalities of the dashboards might return errors when using a different web browser.</li>
</ul>
To find out more about the data structure and algorithms of the specific dashboards, click on the top navigation bar.
<p align=”justify”> The web application is currently in development and any suggestions, bugs or errors will be welcomed. Do not hesitate to contact through the <a onclick="ContactWindow()">contact form</a>, email or any other social platform available.
</p>


 </div>

 <div class="FSCVV" style="display: none;margin:30px 2%;">
  <h1 class="w3-xxxlarge w3-text-indigo" ><b>FSCV Visual</b></h1>

  <hr style="width:800px;border:3px solid #3f51b5;" class="w3-round"; >
  <h1 class="w3-large w3-text-indigo" ><b>FSCV Colorplot</b> &emsp; <a href="3D-colorplot.csv" type="csv" download="ExampleFiles/3D-colorplot.csv">
  <i class="fas fa-file-csv"></i></a> &emsp; <a href="3Dcolorplot.txt" type="txt" download="ExampleFiles/3Dcolorplot.txt"><i class="fa fa-file-text" aria-hidden="true"></i></a></h1>
  <p align=”justify”> The FSCV colorplot dashboard allows the three dimensional representation of the faradaic current measured in cyclic voltammetry (Z axis) respect to voltage applied in each cycle (Y axis) and the time for each cycle (X axis). Table 1 represents the structure required by the algorithm in order to distinguish effectively the data. Cells marked in green represent time at which each voltammogram cycle is taken. Cells marked in blue represent the voltage values for each voltammogram. Cells marked in yellow represent the 2D faradaic current sampled for the whole experiment. The blank cell on the top-left corner represents the (1,A) cell on an Excel spreadsheet or csv file. A csv template can be downloaded <a href="3D-colorplot.csv" type="csv" download="ExampleFiles/3D-colorplot.csv">here</a> and encouraged to avoid errors. Alternatively, a Plain Text txt file can be also uploaded. In that case, the time, voltage and current arrays of values are separated by a "&" marker. All three arrays have their values separated by tab entries. A txt template with the specific structure of the data can be found <a href="3Dcolorplot.txt" type="txt" download="ExampleFiles/3Dcolorplot.txt">here</a>.
  </p>

  <table class="tg center" style="margin-left: auto;
  margin-right: auto;">
  <thead>
    <tr>
      <th class="tg-c3ow"></th>
      <th class="tg-3l34">Time (s)</th>
      <th class="tg-8gdt">0</th>
      <th class="tg-8gdt">0.1</th>
      <th class="tg-8gdt">0.2</th>
      <th class="tg-8gdt">0.3</th>
      <th class="tg-8gdt">0.4</th>
      <th class="tg-8gdt">0.5</th>
      <th class="tg-8gdt">0.6</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="tg-8m8h">Voltage (V)</td>
      <td class="tg-kt43">Current (nA)</td>
      <td class="tg-c3ow"></td>
      <td class="tg-c3ow"></td>
      <td class="tg-c3ow"></td>
      <td class="tg-c3ow"></td>
      <td class="tg-c3ow"></td>
      <td class="tg-c3ow"></td>
      <td class="tg-c3ow"></td>
    </tr>
    <tr>
      <td class="tg-c4ww">-0.5092</td>
      <td class="tg-c3ow"></td>
      <td class="tg-hafo">0.005220418</td>
      <td class="tg-hafo">0.005827037</td>
      <td class="tg-hafo">0.004548263</td>
      <td class="tg-hafo">0.003209593</td>
      <td class="tg-hafo">0.002175521</td>
      <td class="tg-hafo">0.003116362</td>
      <td class="tg-hafo">0.002547905</td>
    </tr>
    <tr>
      <td class="tg-c4ww">-0.5104004</td>
      <td class="tg-c3ow"></td>
      <td class="tg-hafo">0.005470237</td>
      <td class="tg-hafo">0.006063761</td>
      <td class="tg-hafo">0.004732272</td>
      <td class="tg-hafo">0.003357741</td>
      <td class="tg-hafo">0.00229136</td>
      <td class="tg-hafo">0.003174449</td>
      <td class="tg-hafo">0.002575986</td>
    </tr>
    <tr>
      <td class="tg-c4ww">-0.5116008</td>
      <td class="tg-c3ow"></td>
      <td class="tg-hafo">0.005723832</td>
      <td class="tg-hafo">0.006303415</td>
      <td class="tg-hafo">0.004918814</td>
      <td class="tg-hafo">0.003508545</td>
      <td class="tg-hafo">0.002409712</td>
      <td class="tg-hafo">0.003231962</td>
      <td class="tg-hafo">0.002602608</td>
    </tr>
    <tr>
      <td class="tg-c4ww">-0.5128012</td>
      <td class="tg-c3ow"></td>
      <td class="tg-hafo">0.005981091</td>
      <td class="tg-hafo">0.006545888</td>
      <td class="tg-hafo">0.005107815</td>
      <td class="tg-hafo">0.003661963</td>
      <td class="tg-hafo">0.002530554</td>
      <td class="tg-hafo">0.00328886</td>
      <td class="tg-hafo">0.002627724</td>
    </tr>
    <tr>
      <td class="tg-c4ww">-0.5140016</td>
      <td class="tg-c3ow"></td>
      <td class="tg-hafo">0.006241895</td>
      <td class="tg-hafo">0.006791068</td>
      <td class="tg-hafo">0.005299203</td>
      <td class="tg-hafo">0.00381795</td>
      <td class="tg-hafo">0.002653862</td>
      <td class="tg-hafo">0.003345107</td>
      <td class="tg-hafo">0.002651288</td>
    </tr>
    <tr>
      <td class="tg-c4ww">-0.515202</td>
      <td class="tg-c3ow"></td>
      <td class="tg-hafo">0.006506122</td>
      <td class="tg-hafo">0.007038835</td>
      <td class="tg-hafo">0.005492898</td>
      <td class="tg-hafo">0.003976458</td>
      <td class="tg-hafo">0.002779608</td>
      <td class="tg-hafo">0.003400664</td>
      <td class="tg-hafo">0.002673256</td>
    </tr>
    <tr>
      <td class="tg-c4ww">-0.5164024</td>
      <td class="tg-c3ow"></td>
      <td class="tg-hafo">0.006773646</td>
      <td class="tg-hafo">0.007289069</td>
      <td class="tg-hafo">0.005688823</td>
      <td class="tg-hafo">0.004137436</td>
      <td class="tg-hafo">0.00290776</td>
      <td class="tg-hafo">0.003455496</td>
      <td class="tg-hafo">0.002693583</td>
    </tr>
  </tbody>


  </table>
<p style="text-align: center;">Table 1: illustration of the required .csv structure to obtain the 3D colorplot. </p>
<br>
<p style="justify"> After successfully uploading the file, which is notified by the software, the dashboard can be opened from the mainpage. A new window will emerge showing a representation of the signal similar to that given by the interactive plot in Figure 1. This 3D plot is developed with the <a href="https://plotly.com/">Plotly software package</a> in Javascript. Please visit their website for demonstrations on how to use the plot user interface. The plotted data in this plot is only used for illustration purposes and it is provided by Plotly. </p>
<ul>
<li><b>Top control buttons </b></li>
</ul>
<p style="justify">A control panel at the top of the dashboard allows to change the color palette of the colorplot and also change the type of plot from the default 3D surface to 2D heatmap or 2D countour. Additionally, the 2D current values can be inverted to switch between positive oxidation (IUPAC convention) or negative oxidation (USA convention) <a href="/home.php#references">[2]</a>. A final button of the head control panel allows to reset the dashboard, which is useful when the colorplot has been overfiltered or the user wants to get back to the initial stage of the application. Note that any selected transient or i-V plot will be also erased. The top calibration panel also allows to download a screenshot of the dashboard in pdf format. However, notice that the pdf rendering is not optimized and structures in the html file such as buttons, graphs axis and others might not be represented as in the web browser. An example can be downloaded <a href="example1.pdf" type="pdf" download="ExampleFiles/example1.pdf">
here</a>. The dashboard can also be stored as an html file and associated files by pressing right click → save as... and save as Web Page, Complete. In this case, the save is heavier but the dashboard can be opened in a web browser and is identical to that of the web application, although the interactive tools do not work.</p>
<div  class="FSCVV centerdiv" style="display: none; width:550px;height:450px;" id='plot3D'></div>
<p style="text-align: center;">Figure 1: illustration of the Plotly 3D figure of the uploaded data present in the FSCV Colorplot dashboard. </p>
<br>
<p style="justify">Finally, the top control panel also has a graph selection slider, which activates a javascript function that detects clicked points in the colorplot graph. This will automatically extract the horizontal 1D transient and the vertical cyclic voltammogram that match in that point. The user can select as many signals as required and the algorithm will detect if two same points have been clicked so that the same trace is not plotted twice. The selected 1D transients and cyclic voltammograms will be plotted in two parallel XY cartesian axes below the colorplot. Each of the axes has two buttons that allow the removal of the last added trace or to erase all the traces from the plot. Notice that selected traces cannot be recovered after removing them from the plot.</p>
<ul>
<li><b>Filtration Panel </b></li>
</ul>

<p style="justify"> The filtration panel of the FSCV colorplot dashboard allows the smoothing of the 2D matrix of faradaic current values. This is a useful tool when the colorplot has unwanted high frequency noise. The filtering panel allows two different types of filtering: 2D convolution smoothing or 2D FFT low pass filtering. Both operations are performed with the <a href="https://opencv.org/">Open Computer Vision</a> software package in Javascript. The 2D array of faradaic current values is considered as an image with temporal dimensions.</p>

<p style="justify"> The 2D convolution filtering obtains the 2D convolution between a kernel and the 2D current matrix from the colorplot. This operation is defined by Equation 1 and illustrated in Figure 2. The indexes i and j represent a location in the 2D current signal while m and n represent a location in the kernel matrix.  The user can choose between a uniform kernel and a Gaussian kernel, as well as the size of the square kernel in pixels and how many times the convolution operation is applied between the kernel and the colorplot. Once the parameters are set, the button "Apply" will convolute the colorplot with the kernel. Larger kernels will require longer computation time, and their smoothing effect over the signal will be stronger. To convolve the values at the edges of the 2D current matrix, the reflection of the matrix is used to fill the kernel pixels that lay out of the matrix. </p>
<div>
<div style=" float: left;width: 50%;">
<p style="text-align: center;"> $$ y\left[i,j\right]=\sum_{m=-\infty}^\infty\sum_{n=-\infty}^\infty h\left[m,n\right] \cdot x\left[i-m,j-n\right] $$ </p>
<p style="text-align: center;">  $$Uniform\ 3x3:\ h[m,n] = \frac{1}{9}\begin{bmatrix}1 & 1 &1\\1 & 1 &1 \\ 1 & 1 &1\end{bmatrix} $$ $$ Gaussian\ 3x3:\ h[m,n] = \frac{1}{16}\begin{bmatrix}1 & 2 &1\\2 & 4 &2 \\1 & 2 &1 \end{bmatrix}$$ </p>
<p style="text-align: center;">Equation 1: mathematical formulation of 2-D convolution between a kernel, h[m,n] and image, x[i,j] and 3x3 examples of kernels used in the dashboard.</p>
</div>
<div style=" float: right;width: 50%;">
<img src="Images/convimage.gif" alt="Illustration of 2D convolution" style="width:243px;height:243px; display:block;margin:auto;">
<p style="text-align: center;">Figure 2: illustration of the 2D convolution operation between the kernel (dark blue) and the 2D current matrix (blue) to give the resulting image (grey). Figure obtained from <a href="/home.php#references">[3]</a>.</p>
</div>
<p>  </p>
</div>
<p style="justify; margin:5px"> The 2D FFT low pass filtering obtains the 2D Fast Fourier Transform of the signal. Equation 2 shows the mathematical operation, where x[m,n] represents the 2D current matrix, and u and v represent the vertical and horizontal temporal frequencies of the signal. In the dashboard, the magnitude of the 2D spectrum in logarithmic scale (dBs) can be plotted in the colorplot axes by clicking. An example of such can be seen in Figure 3. The spectrum is also shifted so that the centre of the plot holds the low frequency components. The filtration panel allows the introduction of the percentage of spectrum from both vertical and horizontal axes to remain after the filtration. Alternatively, if the spectrum is plotted the user can activate the "Graph Selection" option in the top panel and click a cutoff point in any of the quadrants of the spectrum. The lower the percentage that remains in the spectrum, the stronger the filtration, as only some low frequency components will remain in the signal. After the cropping, the smoothed image is retrieved by applying the Inverse Fast Fourier Transform to the 2D spectrum. </p>
<p style="text-align: center;"> $$ F[u_{k},v_{l}] = \sum_{m=0}^{M-1} \sum_{n=0}^{N-1} x[m,n] e^{-ju_{k}m}e^{-jv_{l}n}, \ u_{k} = \frac{2 \pi k}{M}, \ v_{l} = \frac{2 \pi l}{N}$$ </p>
<p style="text-align: center;">Equation 2: general mathematical formulation of the 2D Discrete Fourier Transform.</p>
<p style="justify">In general, convolution filtering is computationally faster than 2D FFT cropping with Open Computer Vision algorithms, although the results might not be optimal and the filtering process is less intuitive. Additionally, when visualizing the 2D DFT spectrum the user can notice of high frequency noise peaks that are not present in clean signals and filter them out, while 2D convolution requires a "trial and error" approach. </p>
<img src="Images/plotFFTExample.svg" alt="2D FFT Example plot" style="width:750px;height:500px; display:block;margin:auto;">
<p style="text-align: center;">Figure 3: 2D FFT magnitude spectrum of a FSCV colorplot of Histamine release and Serotonin inhibition in rodents premammillary nucleus <a href="/home.php#references"> [1]</a>.</p>
<ul>
<li><b>Calibration Panel </b></li>
</ul>


<p style="justify"> The calibration panel allows to perform traditional postcalibration to the 1D transients extracted from the colorplot. This process consists simply in applying a calibration factor to the current traces to convert them to neurotransmitter concentration traces (e.g. [5-HT](nM) = K(nM/nA)·Current(nA)). In order to perform the traditional calibration, the calibration coefficient and its units are required. Additionally, the user decides the traces from the 1D transient axes that need to be calibrated. Once all the input parameters are introduced, the "Apply" button will perform the calibration, as well as find the peak of the trace, the area under the curve and the half-life of the neurotransmitter. This calculations are identical to those performed in the 1D Transient dashboard and will be described below. The calibrated concentration transients will be plotted in one of the cartesian axis below the control panels. There are two calibration cartisian axes available, although they can be overwritten by applying consecutive calibrations. Although overwritten in the plots, the calibrated traces and the parameters calculated for each of them will in the exported csv file produced in the Export panel.</p>
<ul>
<li><b>Export Panel </b></li>
</ul>

<p style="justify"> The export panel allows to retrieve the calibrated 1D transients together with the calculated peaks, area and exponential decay parameters of the neurotransmitter uptake. All the calibrated traces, independently of being in the plots, will be written to the export file. The user can also choose to retrieve the full colorplot by clicking the option in the radio button. This functionality allows to use the dashboard as a colorplot filtering tool and retrieve the smoothed colorplot afterwards. </p>

<h1 class="w3-large w3-text-indigo" ><b>1D Transient</b> &emsp; <a href="1D-transient.csv" type="csv" download="ExampleFiles1D-transient.csv">
<i class="fas fa-file-csv"></i></a></h1>

<p align=”justify”> The 1D Transient dashboard allows the cartesian representation of the faradaic current or calibrated concentration over the length of the experiment. Commonly (but not uniquely), 1D Transients are formed by stacking the peak current values of all the cyclic voltammograms recorded in an experiment. Table 2 represents the structure of the csv/xlsx file required by the algorithm in order to distinguish efficiently the data. Cells marked in green represent time at which each voltammogram cycle is taken. Cells marked in blue represent the current or concentration traces. Each column represents a different trace. Each trace must represent an independent sampling of the neurotransmitter release/inhibition for the calculated statistical parameters to be accurate. There is not a set limit for the number of traces that can be uploaded to the dahsboard, although it is recommended to be no more than 15 traces for speed requirements. Cells marked in blue represent the units of the X and Y axis. These are required for plotting purposes and also for the algorithms to check that the units of the data are correct. The 'Time (s)' cell on the top-left corner represents the (1,A) cell on an Excel spreadsheet. A csv template can be downloaded <a href="1D-transient.csv" type="csv" download="ExampleFiles/1D-transient.csv">here</a> and encouraged to avoid errors. It is important that all the columns of the file are next to each other so the algorithm does not misinterpret a blank line as a null trace.
</p>


<table class="tg center" style="margin-left: auto;
margin-right: auto;">
<thead>
  <tr>
    <th class="tg-3l34">Time (s)</th>
    <th class="tg-pbtr">HA.1</th>
    <th class="tg-pbtr">HA.2</th>
    <th class="tg-pbtr">HA.3</th>
    <th class="tg-8m8h">X Units:</th>
    <th class="tg-8m8h">Y Units:</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg-8gdt">0</td>
    <td class="tg-cmwg">0.397694425</td>
    <td class="tg-cmwg">0.549746978</td>
    <td class="tg-cmwg">0.476303475</td>
    <td class="tg-c4ww">Time (s)</td>
    <td class="tg-c4ww">Concentration (M)</td>
  </tr>
  <tr>
    <td class="tg-8gdt">0.1</td>
    <td class="tg-cmwg">0.390419923</td>
    <td class="tg-cmwg">0.55247056</td>
    <td class="tg-cmwg">0.464125748</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="tg-8gdt">0.2</td>
    <td class="tg-cmwg">0.371472528</td>
    <td class="tg-cmwg">0.550220165</td>
    <td class="tg-cmwg">0.45878113</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="tg-8gdt">0.3</td>
    <td class="tg-cmwg">0.350134342</td>
    <td class="tg-cmwg">0.548216393</td>
    <td class="tg-cmwg">0.449847633</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="tg-8gdt">0.4</td>
    <td class="tg-cmwg">0.332350734</td>
    <td class="tg-cmwg">0.553417783</td>
    <td class="tg-cmwg">0.438879853</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="tg-8gdt">0.5</td>
    <td class="tg-cmwg">0.311118324</td>
    <td class="tg-cmwg">0.5395976</td>
    <td class="tg-cmwg">0.413699215</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="tg-8gdt">0.6</td>
    <td class="tg-cmwg">0.292025293</td>
    <td class="tg-cmwg">0.508936745</td>
    <td class="tg-cmwg">0.394186375</td>
    <td></td>
    <td></td>
  </tr>
</tbody>
</table>
 <p style="text-align: center;">Table 2: illustration of the required .csv structure to obtain the 1D Transient plot. </p>
 <br>
 <p style="justify"> After successfully uploading the file, which is notified by the software, the dashboard can be opened from the mainpage. A new window will emerge showing a representation of the signal similar to that in Figure 4. The plots produced in the 1D Transient dashboard are developed with the <a href="https://apexcharts.com/">Apexcharts software package</a> in Javascript. Please visit their website for demonstrations on how to use the plot user interface. The plotted data in the documentation has only illustration purposes. A different feature of the 1D Transient dashboard respect to the FSCV Colorplot dashboard is that it is fully automatic. All the parametric measurements and numerical fittings to the signals are performed while the dashboard loads. The loading time of the 1D Transient dashboard can take up to 30 seconds due to the iterative nature of the Michaelis-Menten ODE fitting. Following, a description of each of the panels in the dashboard can be found.</p>

 <div class="FSCVV centerdiv" style="display: none; width:550px;height:460px;" id='plot1D'></div>
 <p style="text-align: center;">Figure 4: illustration of the XY plot of the uploaded data present in the 1D Transient dashboard. </p>

 <ul>
 <li><b>Summary Table </b></li>
 </ul>
<p style="justify"> The summary table gathers some of the main parameters calculated for each of the traces and the average trace, as well as the standard deviation of each of the parameters. Notice that this standard deviation determines the variability of the measured parameter over the traces (standard deviation of the repetitions), and not the standard deviation of the parameters themselves, which is included in the expotable csv file when applicable. The area under the curve of the traces is calculated using the <a href="https://web.stanford.edu/group/sisl/k12/optimization/MO-unit4-pdfs/4.2simpsonintegrals.pdf">Simpson's rule</a> with <a href="https://www.scipy.org/">SciPy</a> library in Python 3.7. Using the same Python library, an algorithm designed to detect the release/inhibition peak of traces finds the peak value for each of the traces, as well as for the average. In order to be able to use Python's data analysis libraries, the dashboard communicates through API calls with a Python runtime server that provides the functions. Finally, the summary table also contains the half-life of the neurotransmitter traces from the detected peak to where concentration/current crosses 0. The exponential decay fitting process is further explained in the Exponential fit section of the dashboard.</p>

<ul>
<li><b>Standard Deviation and First Gradient </b></li>
</ul>

<p style="justify"> The 1D Transient dashboard calculates and plots the standard deviation over time of the traces uploaded by the user. After that, the average standard deviation is calculated as the square root of the average variance. This average standard deviation give information about how dispersed the traces are overall, while the standard deviation over time gives information about the time at which the variance between traces is higher. Additionally, the gradient of the average trace is estimated as the second order central differences with Python's <a href="https://numpy.org/doc/stable/reference/generated/numpy.gradient.html" >Numpy library</a>. Visualizing the gradient trace over time is useful to study the rate of change of neurotransmitter concentration over time, and it is also used to model the Release Rate function of the Michaelis Menten ODE. Equation 3 shows the mathematical representation used to estimate the gradient in the 1D Trasient dashboard <a href="home.php#references">[4]</a>.</p>
<p style="justify">$$ f_{i}'[x_{i}] = \frac{f[x_{i+1}]-f[x_{i-1}]}{2h} + \mathcal{O}[h^{2}]$$</p>
<p style="text-align: center;">Equation 4: general mathematical formulation of the standard second order central differences.</p>

<ul>
<li><b>Exponential Fit </b></li>
</ul>
<p style="justify">One of the most common parameters measured in neurochemical dynamics is the half-life of the chemical: this is the time it takes for the concentration of that substance to fall to half of its initial value. As FSCV data is only able to detect changes of concentration and not basal levels of the neurotransmitter, that initial value is 0. After the release/inhibition of a neurotransmitter, the return to the initial value usually follows a single exponential decay. In some cases, it follows two exponential decays, one related to a fast uptake of the chemical and the other to a slower uptake of the chemical. However, in the majority of the cases this can be approximated by a simple exponential decay curve as given by Equation 5. The half-life is calculated in the dashboard from the exponential parameter K as given by the mentioned equation. Additionally, the standard deviation for each of the parameters of the regression fit are calculated and available in the exportable csv. Notice that the r-square parameter is also calculated for the exponential regression. However, it is widely known that its use is not recommended for non-linear regressions. The standard error of the estimate, also provided, is a more adequate parameter to estimate the goodness of fit of the exponential function. </p>
<p style="justify">$$ C(t) = C_{0}e^{-Kt}, \quad t½ = \frac{ln(2)}{K}$$</p>
<p style="text-align: center;">Equation 5: mathematical formulation for the exponential decay curve fitted to the traces and half-life of the decay.</p>
<p style="justify">It is essential to mention that the standard deviation of the half-life is commonly estimated in the literature as the standard deviation of the K parameter. However, this lacks of accuracy as K and t½ are not the same parameter and do not have the same units. Here, the standard deviation of t½ is calculated from the propagation of uncertainty produced by the variance of K, given by Equation 6. This is a good approximation as long as the standard deviation of K remains low <a href="home.php#references">[5]</a>. </p>
<p style="justify">$$ (\Delta U_{t½})^2 = (\frac{\partial f(K)}{\partial t½} )^{2}(\Delta U_{K})^2 $$</p>
<p style="text-align: center;">Equation 6: mathematical formulation for the propagation of uncertainty between two dependent experimental parameters.</p>
<ul>
<li><b>Michaelis Menten Model </b></li>
</ul>
<p style="justify"> Michaelis Menten models are one of the best known approaches to study neurochemical kinetics associated with enzymatic reactions. In the case of FSCV neurochemical data in vivo, the substrate is the neurotransmitter in the extracellular space, while there are several physiological processes that model the concentration of the neurotransmitter, such as:
  <ul>
  <li>Vesicular release of the neurotransmitter </li>
  <li>Autoreceptors inhibition of release</li>
  <li>Influence of other neurotransmitters</li>
  <li>Metabolization</li>
  <li>Diffusion in/out of the synaptic cleft </li>
  <li>Reuptake into neuronal terminals </li>
  <li>Reuptake into glia cells</li>
  </ul>
  Modelling each of these processes to undertand how they change the concentration of a determined neurotransmitter in the synaptic space has proven to be challenging for the case of histaminergic modulation of 5-HT concentration <a href="home.php#references">[1]</a>, and not ready to be implemented in an automatic algorithm due to the high variability of FSCV traces. The 1D Transient dashboard fits a simplified differential equation model <a href="home.php#references">[6]</a> with two uptake processes (fast and slow) shown in Equation 7. This differential equation has a release rate parameter (R(t)), which models the rate of vesicular release of the neurotransmitter, and a negative feedback parameter (1-A(t)), which models the autoreceptors inhibition of the release. The rest of the parameters in the equation are common Michaelis Menten kinetic parameters, being α and β the dominance of the uptake processes, so that α + β = 1. The differential equation is fitted to the signal using <a href="https://www.scipy.org/" >SciPy</a> and <a href="https://lmfit.github.io/lmfit-py/" >Lmfit</a> libraries in  Python 3.7. Expected initial kinetic parameters are passed to the algorithm, as well as an estimation of R(t) and A(t). The algorithm find the closer solution of the differential equation to the experimental data iteratively using the Levenberg–Marquardt algorithm <a href="home.php#references">[7]</a>. This process is computationally hard, which means the loading of the dashboard might take up to 30 seconds and the Michaelis Menten model might not optimally fit the experimental signal. The release rate function has been optimized to fit hippocampal histamine release transients and it may not fit well neurochemical traces from a different neurotransmitter of different nature.</p>
  <p style="justify">$$ \frac{dC(t)}{dt} = R(t)(1-A(t))-\alpha\frac{V_{max}·C(t)}{K_{m}+C(t)} -\beta\frac{V_{max2}·C(t)}{K_{m2}+C(t)}$$</p>
  <p style="text-align: center;">Equation 7: Michaelis Menten differential equation with two uptake processes, a release function and autoreceptors function.</p>
<p style="justify">The Michaelis Menten fitting algorithms are currently under revision and optimization to achieve an automatic fitting to different type of neurochemical dynamics. </p>
<h1 class="w3-large w3-text-indigo" ><b> i-V plot</b>  &emsp; <a href="iV-transient.csv" type="csv" download="ExampleFiles/iV-transient.csv">
<i class="fas fa-file-csv"></i></a></h1>

 <p align=”justify”> The i-V plot dashboard allows the cartesian representation of the faradaic current depending on the voltage program applied, as well as the calculation of characteristic features in the CV and classification of faradaic peaks. Many cyclic voltammograms can be plotted at the same time. The same voltage program has to be applied for all uploaded CVs. Table 3 represents the csv structure required for the uploaded file to be correctly read. Cells marked in blue represent the voltage program applied. Cells marked in yellow represent the faradaic current registered (Y axis). Cells marked in green represent the units of the X and Y axis. The 'V' cell on the top-left corner represents the (1,A) cell on an Excel spreadsheet. A csv template can be downloaded <a href="iV-transient.csv" type="csv" download="ExampleFiles/iV-transient.csv">here</a> and encouraged to avoid errors. It is important that all the columns of the file are next to each other so the algorithm does not misinterpret a blank line as a null trace.
 </p>
 <br>

 <table class="tg center" style="margin-left: auto;
 margin-right: auto;">
 <thead>
   <tr>
     <th class="tg-8m8h">V</th>
     <th class="tg-kt43">i.1</th>
     <th class="tg-kt43">i.2</th>
     <th class="tg-3l34">X Units:</th>
     <th  class="tg-3l34">Y Units:</th>
   </tr>
 </thead>
 <tbody>
   <tr>
     <td class="tg-c4ww">-0.5092</td>
     <td class="tg-hafo">-0.07265929</td>
     <td class="tg-hafo">-0.02918729</td>
     <td class="tg-8gdt">Voltage (V)</td>
     <td class="tg-8gdt">Current (nA)</td>
   </tr>
   <tr>
     <td class="tg-c4ww">-0.5104004</td>
     <td class="tg-hafo">-0.0816152</td>
     <td class="tg-hafo">-0.03541357</td>
     <td></td>
     <td></td>
   </tr>
   <tr>
     <td class="tg-c4ww">-0.5116008</td>
     <td class="tg-hafo">-0.09093332</td>
     <td class="tg-hafo">-0.04189563</td>
     <td></td>
     <td></td>
   </tr>
   <tr>
     <td class="tg-c4ww">-0.5128012</td>
     <td class="tg-hafo">-0.1006187</td>
     <td class="tg-hafo">-0.04863628</td>
     <td></td>
     <td></td>
   </tr>
   <tr>
     <td class="tg-c4ww">-0.5140016</td>
     <td class="tg-hafo">-0.1106762</td>
     <td class="tg-hafo">-0.05563821</td>
     <td></td>
     <td></td>
   </tr>
   <tr>
     <td class="tg-c4ww">-0.515202</td>
     <td class="tg-hafo">-0.1211106</td>
     <td class="tg-hafo">-0.06290395</td>
     <td></td>
     <td></td>
   </tr>
   <tr>
     <td class="tg-c4ww">-0.5164024</td>
     <td class="tg-hafo">-0.1319264</td>
     <td class="tg-hafo">-0.07043588</td>
     <td></td>
     <td></td>
   </tr>
   <tr>
     <td class="tg-c4ww">-0.5176028</td>
     <td class="tg-hafo">-0.1431282</td>
     <td class="tg-hafo">-0.07823622</td>
     <td></td>
     <td></td>
   </tr>
 </tbody>
 </table>
 <p style="text-align: center;">Table 3: illustration of the required .csv structure to obtain the i-V plot. </p>
 <br>
 <p style="justify"> After successfully uploading the file, which is notified by the software, the visual tool can be opened from the mainpage. A new popup window will emerge showing a representation of the signal similar to that given by Figure 5. This  i-V plot is developed with the <a href="https://plotly.com/">Plotly software package</a> in Javascript. Please visit their website for demonstrations on how to use the plot user interface.The plotted data in the documentation only serves illustration purposes.</p>
 <br>

 <div class="FSCVV centerdiv" style="display: none; width:550px;height:460px;" id='plotiV'></div>
 <p style="text-align: center;">Figure 5: illustration of the i-V plot of the uploaded data present in the 1D Transient dashboard. </p>
  <ul>
  <li><b>Classification Panel</b></li>
  </ul>

   <p style="justify"> The i-V dashboard contains a graphic selection tool that allows the user to select the oxidation and reduction faradaic peaks of the cyclic voltammogram by clicking on the graph. Additionally, the user can also represent the selected faradaic peaks in the voltage programme. After that, the classification panel automatically calculates and write in a table the following parameters:
     <ul>
     <li> i<sub>pa</sub> : Anodic peak current</li>
     <li> i<sub>pc</sub> : Cathodic peak current</li>
     <li> E<sub>pa</sub> : Anodic peak potential</li>
     <li> E<sub>pc</sub> : Cathodic peak potential</li>
     <li> Δi : Anodic-Cathodic peak current difference</li>
     <li>  i<sub>pa</sub>/i<sub>pc</sub> : Anodic-Cathodic peak current ratio</li>
     <li> ΔE : Anodic-Cathodic peak voltage difference</li>
     </ul>
     The user can also calculate the AUC of the cyclic voltammogram, which is also another characteristic feature used to identify the faradaic peaks. The dashboard contains a light-weight 3 layer neural network model trained with <a href="https://www.tensorflow.org/">Tensorflow</a> and <a href="https://keras.io/">Keras</a> to identify peaks corresponding to 5-HT, DA, HA faradaic processes and pH peaks. as well as switching peaks present when the HA waveform is applied <a href="/home.php#references"> [1]</a>. Principal Component Analysis is applied to the features extracted from the cyclic voltammogram for dimensionality reduction. Two principal components are used as input to the neural network. The "Classify" button of the dashboard allows the conversion of the features extracted from the user-labelled cyclic voltammogram to the principal components used by the neural network. After that, the neural network obtains the predicted class probabilities, which are shown in the results section of the dashboard. The prediction of the dashboard is also shown and corresponds to the class with the highest probability of the prediction.
     </p>
     <ul>
     <li><b>Export Panel</b></li>
     </ul>
<p style="justify"> The export panel allows the user to download a csv file with the parametric analysis of the labelled cyclic voltammogram, as well as the class probabilities calculated by the neural network. As mentioned before, only DA release, 5-HT inhibition and release, HA release, pH peaks and certain switching peaks can currently be identified by the neural networks.   </p>
</div>







   <div class="CON" style="display: none;margin:30px 2%;">
     <h1 class="w3-xxxlarge w3-text-indigo" ><b>Kinetic Calibration</b> <a href="3D-colorplot.csv" type="csv" download="ExampleFiles/3D-colorplot.csv">
    <i class="fas fa-file-csv"></i></a> &emsp; <a href="3Dcolorplot.txt" type="txt" download="ExampleFiles/3Dcolorplot.txt"><i class="fa fa-file-text" aria-hidden="true"></i></a></h1>
     <hr style="width:800px;border:3px solid #3f51b5;" class="w3-round"; >
     <p style="justify"> The kinetic calibration section of FSCV datalab allows the deconvolution of mass transport from the estimation of the surface concentration of the neurotransmitter over time (s(t)). The effect of mass transport is represented by the electrode response function (g(t)); this is the current response of the electrode for an ideal delta release of neurotransmitter. This function is modelled by the exponential decay given by Equation 1, where A<sub>0</sub> is a scaling factor, 𝜏 is the time response of the electrode and Δt is the cycling period.</p>
     <p style="text-align: center;">  $$g(t) = A_{0} e^{-\frac{t}{\tau}}, \quad A_{0} = b\frac{\Delta t}{\tau}$$ </p>
     <p style="text-align: center;">Equation 1: mathematical formulation of the electrode response function.</p>
     <p style="justify"> Both parameters can be determined experimentally from the absorption strength of the electrode (b) and the diffusion coefficient (D) of the neurotransmitter <a href="/home.php#references"> [8]</a>, which are input parameters for the user. In the dashboard, the relationship between  D, b and 𝜏 is given by Equation 2, which represents a multivariable regression of experimental data calculated in previous work <a href="/home.php#references"> [8]</a>. </p>
     <p style="text-align: center;">  $$\tau = 601.2 \cdot \frac{1}{10^{6}\cdot D} \cdot b-0.065$$ </p>
     <p style="text-align: center;">Equation 2: Mathematical formulation of the experimental relatioship between 𝜏, b and D. </p>
     <p style="justify">It is important to notice that this relationship is measured experimentally for Dopamine in the nucleus accumbens of rodents, and the relatioship might differ when applying a different voltage programme or measuring different neurotransmitters. The kinetic calibration dashboard allows the input of FSCV data from any electroactive neurotransmitter acknowledging that further work is required to understand the kinetic differences between neurotransmitters.</p>
      <p style="justify"> The format of the data required by the dashboard is identical to that of the FSCV Color PLot dashboard, and it is given by Table 1. Cells marked in green represent time at which each voltammogram cycle is taken. Cells marked in blue represent the voltage values for each voltammogram. Cells marked in yellow represent the 2D faradaic current sampled for the whole experiment. The blank cell on the top-left corner represents the (1,A) cell on an Excel spreadsheet or csv file. A csv template can be downloaded <a href="3D-colorplot.csv" type="csv" download="ExampleFiles/3D-colorplot.csv">here</a> and encouraged to avoid errors. Alternatively, a Plain Text txt file can be also uploaded. In that case, the time, voltage and current arrays of values are separated by a "&" marker. All three arrays have their values separated by tab entries. A txt template with the specific structure of the data can be found <a href="3Dcolorplot.txt" type="txt" download="ExampleFiles/3Dcolorplot.txt">here</a>. </p>
     <table class="tg center" style="margin-left: auto;
     margin-right: auto;">
     <thead>
       <tr>
         <th class="tg-c3ow"></th>
         <th class="tg-3l34">Time (s)</th>
         <th class="tg-8gdt">0</th>
         <th class="tg-8gdt">0.1</th>
         <th class="tg-8gdt">0.2</th>
         <th class="tg-8gdt">0.3</th>
         <th class="tg-8gdt">0.4</th>
         <th class="tg-8gdt">0.5</th>
         <th class="tg-8gdt">0.6</th>
       </tr>
     </thead>
     <tbody>
       <tr>
         <td class="tg-8m8h">Voltage (V)</td>
         <td class="tg-kt43">Current (nA)</td>
         <td class="tg-c3ow"></td>
         <td class="tg-c3ow"></td>
         <td class="tg-c3ow"></td>
         <td class="tg-c3ow"></td>
         <td class="tg-c3ow"></td>
         <td class="tg-c3ow"></td>
         <td class="tg-c3ow"></td>
       </tr>
       <tr>
         <td class="tg-c4ww">-0.5092</td>
         <td class="tg-c3ow"></td>
         <td class="tg-hafo">0.005220418</td>
         <td class="tg-hafo">0.005827037</td>
         <td class="tg-hafo">0.004548263</td>
         <td class="tg-hafo">0.003209593</td>
         <td class="tg-hafo">0.002175521</td>
         <td class="tg-hafo">0.003116362</td>
         <td class="tg-hafo">0.002547905</td>
       </tr>
       <tr>
         <td class="tg-c4ww">-0.5104004</td>
         <td class="tg-c3ow"></td>
         <td class="tg-hafo">0.005470237</td>
         <td class="tg-hafo">0.006063761</td>
         <td class="tg-hafo">0.004732272</td>
         <td class="tg-hafo">0.003357741</td>
         <td class="tg-hafo">0.00229136</td>
         <td class="tg-hafo">0.003174449</td>
         <td class="tg-hafo">0.002575986</td>
       </tr>
       <tr>
         <td class="tg-c4ww">-0.5116008</td>
         <td class="tg-c3ow"></td>
         <td class="tg-hafo">0.005723832</td>
         <td class="tg-hafo">0.006303415</td>
         <td class="tg-hafo">0.004918814</td>
         <td class="tg-hafo">0.003508545</td>
         <td class="tg-hafo">0.002409712</td>
         <td class="tg-hafo">0.003231962</td>
         <td class="tg-hafo">0.002602608</td>
       </tr>
       <tr>
         <td class="tg-c4ww">-0.5128012</td>
         <td class="tg-c3ow"></td>
         <td class="tg-hafo">0.005981091</td>
         <td class="tg-hafo">0.006545888</td>
         <td class="tg-hafo">0.005107815</td>
         <td class="tg-hafo">0.003661963</td>
         <td class="tg-hafo">0.002530554</td>
         <td class="tg-hafo">0.00328886</td>
         <td class="tg-hafo">0.002627724</td>
       </tr>
       <tr>
         <td class="tg-c4ww">-0.5140016</td>
         <td class="tg-c3ow"></td>
         <td class="tg-hafo">0.006241895</td>
         <td class="tg-hafo">0.006791068</td>
         <td class="tg-hafo">0.005299203</td>
         <td class="tg-hafo">0.00381795</td>
         <td class="tg-hafo">0.002653862</td>
         <td class="tg-hafo">0.003345107</td>
         <td class="tg-hafo">0.002651288</td>
       </tr>
       <tr>
         <td class="tg-c4ww">-0.515202</td>
         <td class="tg-c3ow"></td>
         <td class="tg-hafo">0.006506122</td>
         <td class="tg-hafo">0.007038835</td>
         <td class="tg-hafo">0.005492898</td>
         <td class="tg-hafo">0.003976458</td>
         <td class="tg-hafo">0.002779608</td>
         <td class="tg-hafo">0.003400664</td>
         <td class="tg-hafo">0.002673256</td>
       </tr>
       <tr>
         <td class="tg-c4ww">-0.5164024</td>
         <td class="tg-c3ow"></td>
         <td class="tg-hafo">0.006773646</td>
         <td class="tg-hafo">0.007289069</td>
         <td class="tg-hafo">0.005688823</td>
         <td class="tg-hafo">0.004137436</td>
         <td class="tg-hafo">0.00290776</td>
         <td class="tg-hafo">0.003455496</td>
         <td class="tg-hafo">0.002693583</td>
       </tr>
     </tbody>


     </table>
     <p style="text-align: center;">Table 1: illustration of the required .csv structure to obtain the 3D colorplot. </p>
     <br>
        <p style="justify"> Before being able to open the kinetic calibration dashboard, the user is asked to provide additional parameters required to perform the calibration:
          <ul>
          <li>Sampling frequency of the acquisition (Hz). This is not to be coonfused with the frequency at which the voltage programme is applied</li>
          <li>Valency of the faradaic reaction to be calibrated (number of e<sup>-</sup>). This is required to convert the charge measured to surface concentration of the neurotransmitter </li>
          <li>Electrode surface (μm<sup>2</sup>). This is also required to estime the surface concentration of the neurotransmitter. It can be estimated in FSCV Datalab by introducing the length and diameter of the CFM. Notice, however, that this is only an approximation of the electrode surface due to porosities of the carbon surface</li>
          <li>Start sample of the cyclic voltammogram to calculate the AUC of the oxidation</li>
          <li>End sample of the cyclic voltammogram to calculate the AUC</li>
          </ul>

         </p>
     <p style="justify"> After successfully uploading the file and introducing the parameters aforementioned, the dashboard can be opened from the mainpage. A new window will emerge showing a XY plot of the oxidation charge calculated over time. This XY plot is developed with the <a href="https://plotly.com/">Plotly software package</a> in Javascript. Please visit their website for demonstrations on how to use the plot user interface. The charge trace is calculated by obtaining the AUC of the oxidation range determined by the user for each of the CVs in the colorplot. The AUC is obtained using the <a href="https://web.stanford.edu/group/sisl/k12/optimization/MO-unit4-pdfs/4.2simpsonintegrals.pdf">Simpson's rule</a>. The dashboard converts the charge trace into surface concentration applying Faraday's first law of electrolysis and dividing by the electrode surface. </p>
     <ul>
     <li><b>Deconvolution Panel</b></li>
     </ul>
      <p style="justify">A deconvolution panel applies the deconvolution of the electrode response function to the analytical surface concentration calculated by the dashboard. The deconvolution operation is performed with <a href="https://www.scipy.org/">SciPy</a> library in Python 3.7 as a division between the analytical signal spectrum and the electrode response function spectrum. This operation is illustrated in Equation 3. This deconvolution operation is an ill-posed problem [9], as both the surface concentration and the electrode response function are estimations. Additionally, large errors may arise when spectral components in the denominator are zero or close to zero. However, the concentration profile (c(t)) over time result of the deconvolution process represents a more accurate estimation of the changes in concentration in the extracellular space compared to the flow analysis calibration approach.  </p>
      <p style="text-align: center;">  $$g(t)*c(t) = s(t) \xrightarrow{\mathscr{F}} C(jw) = \frac{S(jw)}{G(jw)}$$ </p>
      <p style="text-align: center;">Equation 3: Mathematical formulation of deconvolution operation in the FT domain. </p>
      <ul>
      <li><b>Export Panel</b></li>
      </ul>
        <p style="justify">The export panel of the kinetic calibration dashboard allows the user to download a csv file containing the charge trace obtained as a result of the integration of the oxidation range in the CVs and the concentration profile result of the kinetic calibration. Notice that the export will return an error if the calibration has not been performed or has been performed incorrectly. </p>

   </div>


     <div class="ELE" style="display: none;margin:30px 2%;">
         <p style="justify">This section belongs to a standby project to improve the calibration of FSCV data obtained with Carbon Fibre Microelectrodes (CFM) by studying the different characteristics of CFM and the acquisition system used. The final purpose of the dashboard is to provide a more accurate and robust calibration and allow the use of electrodes of different sizes and characteristics. A high experimental component is required to characterize the signal coming from different carbon fibres. Due to the Covid 19 outbreak in the United Kingdom this project is currently stopped but expected to relauch in the future.</p>
     </div>








<script>
var data=[];
var Array_of_Points=[];

var tracen =  {
      name: 'Sample A',
      data: [[-0.51, -0.07],[-0.7, -3.86],[-0.51, 4.24],[-0.3, 1.78],[-0.1,3.13],[0.1, 3.8],[0.3,2.55],[0.5,-0.57],[0.7,-3.2],[0.9,-2.95],[1.05,-1.59],[0.8,-2.8],[0.6,-1.4],[0.4,-1.15],[0.2,-1.27],[0,-1.7],[-0.2,-2.7],[-0.4,-3],[-0.51,0]]
    };
data=data.concat(tracen);

var options = {
  chart: {
    height: 450,
    width: "100%",
    type: "line"
  },
  dataLabels: {
          enabled: false
        },
  series: data,
  xaxis: {
     type: 'numeric',
      title: {
          text: 'Voltage (V)'
  }},
   yaxis: {
      decimalsInFloat: 1,
      title: {
          text: 'Current (nA)'
  }},
  stroke: {
          curve: 'smooth'
        },
        grid:{
        xaxis: {
        lines: {
            show: true
        }
    },
        yaxis: {
        lines: {
            show: true
        }
    }

        }

};

var chart = new ApexCharts(document.querySelector("#plotiV"), options);

chart.render();
</script>

<script>
var data=[];
var Array_of_Points=[];

var tracen =  {
      name: 'Sample A',
      data: [[0.0833, 1.1], [0.25, 3.04], [0.5, 4.85], [1, 3.93], [2, 2.01], [4, 1.4], [6, 1.2], [8, 1.13]]
    };
data=data.concat(tracen);

var options = {
  chart: {
    height: 450,
    width: "100%",
    type: "area"
  },
  dataLabels: {
          enabled: false
        },
  series: data,
  xaxis: {
     type: 'numeric',
      title: {
          text: 'Time (s)'
  }},
   yaxis: {
      decimalsInFloat: 1,
      title: {
          text: 'Current (nA)'
  }},
  stroke: {
          curve: 'smooth'
        },
        grid:{
        xaxis: {
        lines: {
            show: true
        }
    },
        yaxis: {
        lines: {
            show: true
        }
    }

        }

};

var chart = new ApexCharts(document.querySelector("#plot1D"), options);

chart.render();
</script>




<script>
Plotly.d3.csv('https://raw.githubusercontent.com/plotly/datasets/master/api_docs/mt_bruno_elevation.csv', function(err, rows){
function unpack(rows, key) {
  return rows.map(function(row) { return row[key]; });
}

var z_data=[ ]
for(i=0;i<24;i++)
{
  z_data.push(unpack(rows,i));
}

var data = [{
           z: z_data,
           type: 'surface',
           colorbar: {len:0.5, xpad:5}
        }];

var layout = {
  autosize: false,
  width: 500,
  height: 400,
  margin: {
    l: 5,
    r: 5,
    b: 5,
    t: 5,
  }
};
Plotly.newPlot('plot3D', data, layout);
});
</script>

<script>
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
<script>
$(document).ready(function(){
    $('#home').click(function() {
      $('.FSCVV').hide();
      $('.CON').hide();
      $('.ELE').hide();
      $('.homeW').show();
    });
});

$(document).ready(function(){
    $('#FSCVVisual').click(function() {
      $('.homeW').hide();
      $('.CON').hide();
      $('.ELE').hide();
      $('.FSCVV').show();
    });
});

$(document).ready(function(){
    $('#CONV').click(function() {
      $('.homeW').hide();
      $('.FSCVV').hide();
      $('.ELE').hide();
      $('.CON').show();
    });
});

$(document).ready(function(){
    $('#ELECT').click(function() {
      $('.homeW').hide();
      $('.CON').hide();
      $('.FSCVV').hide();
      $('.ELE').show();
    });
});

function ContactWindow(){
     var myVisualWindow = window.open(encodeURI('ContactForm.php'), "ContactWindow", "width=500,height=550",'resizesable=yes');
}
</script>


</body>



     <footer class=" w3-padding-64 w3-light-grey w3-text-black w3-center">
      <p> <a href="#top" class="w3-button w3-black"><i class="fa fa-arrow-up "></i>To the top</a></p>


     <p class="w3-large">
     <a href = "mailto:sergio.mena19@imperial.ac.uk?subject = Feedback&body = Message"><i class="fa fa-envelope"></i></a>
     <a href="https://twitter.com/sermeor"><i class="fab fa-twitter"></i></a>
     <a href="https://www.linkedin.com/in/sergio-mena-ortega-a418ab120/"><i class="fab fa-linkedin-in"></i></a>
      <a href="https://teams.microsoft.com/"><img src="https://img.icons8.com/ios-filled/50/000000/microsoft-team-2019.png" width="25" height="25"/></a>

     </p>
     <p class="w3-small">Webpage developed by Sergio Mena</p>
     <p class="w3-small">MSc Biomedical Engineering Student</p>
     <p class="w3-small"><a href="https://www.hashemilab.com/">The Hashemi Lab</a></p>
     <p class="w3-small">Imperial College London</p>
     <p class="w3-small">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank" class="w3-hover-text-green">w3.css</a></p>
      </footer>
</html>
