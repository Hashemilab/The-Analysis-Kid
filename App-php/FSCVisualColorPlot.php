<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
    <script src="JavaScriptPackages/html2pdf.bundle.min.js"></script>
    <script src="JavaScriptPackages/sweetalert.min.js"></script>
    <script src="https://kit.fontawesome.com/828d573e3a.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script type="text/javascript" id="MathJax-script" async
      src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js">
    </script>

    <title>FSCV Color Plot Dashboard</title>
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
    input[type='range'] {
      vertical-align: middle;
    }
    input[type='radio'] {
      vertical-align: -1px;
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
.footdash{ text-align: center;  color: #3f51b5;}
    .header {
      padding: 5px;
      text-align: center;
      background: #3f51b5;
      color: white;
      font-size: 16px;
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
    .notepad {
      width: 80%;
      max-width: 600px;
      height: 180px;
      box-shadow: 10px 10px 40px rgba(black, .15);
      border-radius: 0 0 10px 10px;
      overflow: hidden;
      resize: none;

    }




    </style>
    <style>
    table{
      width:100%;
      height:400px;
      border:1.5px solid black;
       font-size: 12px;
       text-align: center;

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
              <h1 contenteditable="true">FSCV Color Plot Dashboard</h1>
            </div>
            <br>
            <div style="position: absolute; left: auto;">
            <b>Colorscale: </b>
            <button  class="btn btn-primary a">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <a id="Traditional" type="radio" onclick="color_palette(this.id)" style="color:white;">Custom</a>
            </button>
            <button  class="btn btn-primary a">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <a  id="Viridis" type="radio" onclick="color_palette(this.id)" style="color:white;">Viridis</a>
            </button>
            <button  class="btn btn-primary a">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <a id="Jet" type="radio" onclick="color_palette(this.id)" style="color:white;">Jet</a>
            </button> </div>
            <button class="btn btn-primary" id="fusionexport-btn" onClick="reset_all()">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <span class="btn-text">Reset Dashboard</span>
            </button>
            <button class="btn btn-primary">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <a id="inversion" onclick="invert_colorplot()" style="color:white;">Invert Sign</a>
            </button>
            <button class="btn btn-primary" id="fusionexport-btn" onClick="downloadPDF()">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <span class="btn-text">Download as PDF</span>
            </button>
            <p></p>
            <div style="position: absolute; left: auto;">
            <b>Plot type: </b>
            <button  class="btn btn-primary b">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <a  id="surface" onclick="type_of_plot(this.id)" style="color:white;">3D</a>
            </button>
            <button  class="btn btn-primary b">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <a  id="heatmap" onclick="type_of_plot(this.id)" style="color:white;">2D</a>
            </button>
            <button class="btn btn-primary b">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <a id="contour" onclick="type_of_plot(this.id)" style="color:white;">Contour</a>
            </button>
            </div>
            <b>Graph Selection: </b>
            <label class="switch">
<input type="checkbox" id="signal_selection" name="signal_selection" value="signal_selection">
<span class="slider round"></span>
</label>
          </div>

          <div class="main">
            <div class="row mt-5 mb-4">
              <div class="col-md-60">
                <div class="boxbig">
                  <div id="bar"></div>
                  <div style="display: none;" id="FFTVisual">
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-4 mb-4">
              <div class="col-md-6">
                <div class="box">
                  <div id="transient1"></div>
                  <div id="delete" style="margin-left:10px;position:relative;bottom:410px;left:295px;">
     <button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteTrace('transient1')">Delete Last</button>
     <button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteAllTrace('transient1')">Erase All</button>
 </div>


                </div>
              </div>
              <div class="col-md-6">
                <div class="box">
                  <div id="iV1"></div>
                  <div id="delete" style="margin-left:10px; margin-bottom:10px; position:relative;bottom:410px;left:295px;">
     <button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteTrace('iV1')">Delete last</button>
     <button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteAllTrace('iV1')">Erase All</button>
                </div>
                </div>
              </div>
            </div>
            <div class="row sparkboxes mt-4 mb-4">
              <div class="col-md-4">
                <div class="box box1">
                  <div id="spark1">
                    <div style="height: 180px;">
                    <p style="font-size:20px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><b>Filtering Panel</b> <button class="btn btn-primary c" style=" font-size: 10px;" id="CONselect">Convolution</button> <button class="btn btn-primary c" style=" font-size: 10px;" id="FFTselect">2D FFT</button></p>
                    <div id="CONVDiv">
                    <p style="margin:0;">
                      <label for="reps" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Repetitions: &nbsp;&nbsp;</label>
                    <input type="number" step="1" name="reps" id="reps" style="width:40px;font-size:12px;" value=1 min=1 max=5 />&nbsp;&nbsp;
                    </p>
                    <p style="margin:0;">
                    <label for="ksize" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Size (px): &nbsp;&nbsp;</label>
                    <input type="number" step="2" name="ksize" id="ksize" style="width:40px;font-size:12px;" value=3 min=3/>
                    </p>
                    <p style="margin:0">
                      <label  style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Kernel: &nbsp;&nbsp;</label>
                    <label for="Gaussian" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><input type="radio" id="gauss" name="typeofkernel" value="Gaussian"> Gaussian </label> <label for="Uniform" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><input type="radio" id="uniform" name="typeofkernel" value="Uniform"> Uniform</label>
                    </p>
                    <button class="btn btn-primary" id="ConvButton" style=" font-size: 10px; margin:0 auto;display:block;" onclick="convolution_function()" disabled>Apply</button>
                  </div>
                  <div style="display: none;" id="FFTDiv">
                    <p style="margin:0;">

                    </p>
                    <p style="margin:0">
                    <label for="hsize" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Horizontal axis (%): &nbsp;&nbsp;</label>
                    <input type="range" step="1" name="hsize" id="hsize" style="width:80px;font-size:12px;" value=50 min=1 max=100 /> <span id="slider1" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"></span>
                    </p>
                    <p style="margin:0">
                    <label for="vsize" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Vertical axis (%): &nbsp;&nbsp;</label>
                    <input type="range" step="1" name="vsize" id="vsize" style="width:80px;font-size:12px;" value=50 min=1 max=100 /> <span id="slider2" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"></span>
                    </p>
                    <p style="margin:0">
                    <label for="sampfrequency" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Sampling frequency (Hz): &nbsp;&nbsp;</label>
                    <input type="number" step="1" name="samplingfrequency" id="samplingfrequency" style="width:80px;font-size:12px;" value=500000 min=1 max=10000000/>
                    </p>
                    <p style="text-align: center;"> <button class="btn btn-primary" id="FFTSpectrum" style=" font-size: 10px; margin:0 auto;" onclick="get_2DFFT()">View 2D FFT</button> <button class="btn btn-primary" id="FFTSpectrum" style=" font-size: 10px; margin:0 auto;" onclick="close_2DFFT()">Close 2D FFT</button> <button class="btn btn-primary" style=" font-size: 10px; margin:0 auto;" onclick="FFT_function()">Apply</button> </p>

                  </div>
                </div>
                   </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box box2">
                  <div id="spark2"> <div style="height: 180px;">
<p style="font-size:20px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><b>Calibration Panel</b>  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <button class="btn btn-primary" style=" font-size: 10px;" onclick="calibration_function()">Calibrate</button></p>

  <p style="margin:0">
    <label for="CalCoeff" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Calibration Coefficient (K): &nbsp;&nbsp;</label>
  <input type="number" step="0.01" name="CalCoeff" id="CalCoeff" style="width:70px;font-size:12px;" value="11" />&nbsp;&nbsp;
  </p>
  <p style="margin:0">
    <label for="CalCoeffUnit" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"> &#8226; Coefficient Units: &nbsp;&nbsp; </label>
    <input type="text"  name="CalCoeffUnit" id="CalCoeffUnit" style="width:70px;font-size:12px;" value="e.g. nM/nA"/>
 </p>
  <p style="margin:0">
    <label for="nsignals" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"> &#8226; Signals: &nbsp;&nbsp; </label>
    <input type="text"  name="nsignals" id="nsignals" style="width:70px;font-size:12px;" value=" e.g. 1, 2" />
 </p>
 <p style="margin:0">
   <label for="namesignals" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"> &#8226; Name: &nbsp;&nbsp; </label>
   <input type="text"  name="namesignals" id="namesignals" style="width:150px;font-size:12px;" value=" e.g. 5-HT inhibition" />
</p>


                  </div>
                </div> </div>
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
  <p style="margin:0">
    <label  style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Data to export: &nbsp;&nbsp;</label>
  <label for="3d_colorplot" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><input type="radio" id="3d_colorplot" name="typeofdata" value="3d_colorplot"> Colorplot </label> <label for="calibrated_signals" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><input type="radio" id="calibrated_signals" name="typeofdata" value="calibrated_signals"> Calibration</label>
  </p>
       <p style="margin:20px; font-size:10px;color:black;font-family:Arial, Helvetica, sans-serif;">All calibrated signals will be exported to the .csv file. Peaks, area and exponential decay fitting are calculated for each of the traces.</p>
                    </div>
                  </div>
                </div>
                </div>
              </div>


            <div class="row mt-4 mb-4">
              <div class="col-md-6">
                <div class="box">
                  <div id="calibration1"></div>
                  <div id="delete" style="margin-left:10px;position:relative;bottom:410px;left:295px;">
     <button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteTrace('calibration1')">Delete Last</button>
     <button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteAllTrace('calibration1')">Erase All</button>
                  </div>
                  <div id="hidden_table" style="display: none;"></div>

                </div>
              </div>

              <div class="col-md-6">
                <div class="box">
                  <div id="calibration2"></div>
                  <div id="delete" style="margin-left:10px;position:relative;bottom:410px;left:295px;">
     <button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteTrace('calibration2')">Delete Last</button>
     <button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteAllTrace('calibration2')">Erase All</button>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
      <p class="footdash">Dashboard created by The Hashemi Lab, Imperial College London.</p>
    </div>
    <script src="JavaScriptPackages/axios.min.js"></script>
    <script src="JavaScriptPackages/exportTabletoCSV.js"></script>
    <script src="JavaScriptPackages/opencv.js" type="text/javascript"></script>




    <script>
    //Ajax call for the buttons
    $(document).on("click", '.a', function(){
    $('.a').removeClass("active");
    $(this).toggleClass("active");
    });
    $(document).on("click", '.b', function(){
    $('.b').removeClass("active");
    $(this).toggleClass("active");
    });
    $(document).on("click", '.c', function(){
    $('.c').removeClass("active");
    $(this).toggleClass("active");
    });

    $('#FFTselect').click(function() {
    $('#CONVDiv').hide()
    $('#FFTDiv').show()
    });
    $('#CONselect').click(function() {
    $('#FFTDiv').hide()
    $('#CONVDiv').show()
    });

    var slider1 = document.getElementById("hsize");
    var output1 = document.getElementById("slider1");
    output1.innerHTML = slider1.value;

    slider1.oninput = function() {
      output1.innerHTML = this.value;
    };

    var slider2 = document.getElementById("vsize");
    var output2 = document.getElementById("slider2");
    output2.innerHTML = slider2.value;

    slider2.oninput = function() {
      output2.innerHTML = this.value;
    };


    // Table entries and variables

    var button_layer_1_height = 1
    var annotation_offset = 0.04
    var w_colorscale = [[0.0, 'rgb(0, 0, 240)'],[0.2478, 'rgb(0, 2, 39)'], [0.3805, 'rgb(245, 213, 1)'],[0.65555, 'rgb(168, 98, 0)'],[0.701, 'rgb(76, 2, 69)'],[0.7603, 'rgb(0, 182, 136)'],[0.7779, 'rgb(0, 138, 30)'], [1.0, 'rgb(1, 248, 1)']];
    var color_of_plot=w_colorscale;
    var plot_type='surface';
    var list_of_plotsT=[];
    var list_of_plotsV=[];
    var Array_of_Peaks=[];
    var Array_of_ypeaks=[];
    var Array_of_xpeaks=[];
    var x_points;
    var nx=1;
    var ny=1;
    var calib_num=1;
    var Array_for_table=[];
    var maxpoint;
    var returned_current=0;
    var num_of_calibrations=1;
    var magnitude_spectrum;
    var magnitude_array;

    var content_API;
    var sign;
    var current_title=DataArray[1][1];
    var current_units = (DataArray[1][1].split(' '))[1];
    var con_units;
    var time_units=DataArray[0][1].split(' ')[1];



    function arrayColumn(arr, n) {
      return arr.map(x=> x[n]);
    }

    DataArrayz=DataArray.slice(2,DataArray.length+1).map(function(row){return row.slice(2,DataArray[0].length+1);});
    DataArrayx0=DataArray[0].slice(2,DataArray[0].length+1);
    DataArrayx=[];
    for(i = 0; i < DataArrayz.length; i++) {
       DataArrayx.push(DataArrayx0);
     }
    DataArrayy=arrayColumn(DataArray,0).splice(2,DataArray.length+1);
    var originalDataArrayz=DataArrayz;
    var time_array=DataArrayx[0];
    var Vlength=DataArrayy.length;

    var freqx=parseInt(1/(parseFloat(DataArrayx[0][1])-parseFloat(DataArrayx[0][0])));
    var freqy;
    var V1=parseInt(Math.floor(Vlength/4)-1);
    var V2=parseInt(Math.floor((Vlength/4)*2)-1);
    var V3=parseInt(Math.floor((Vlength/4)*3)-1);
    var V4=parseInt(Math.floor(Vlength)-1);

    var data = [{
            z: DataArrayz,
            x:DataArrayx,
            type:plot_type,
            colorscale:color_of_plot,
            colorbar: {len:0.5, xpad:30, title:current_title}
    }]



    var layout = {
        margin: {t: 80, b: 25, l: 25, r: 25},
        autosize: true,
        width: 1000,
        height: 600,
        scene: {
            xaxis:{
                title: DataArray[0][1],
                gridcolor: 'rgb(255, 255, 255)',
                zerolinecolor: 'rgb(255, 255, 255)',
                showbackground: true, //Changed this
                showgrid:true, //Added this
                backgroundcolor:'rgb(230, 230,230)',

            },
            yaxis: {
                title: DataArray[1][0],
                gridcolor: 'rgb(255, 255, 255)',
                zerolinecolor: 'rgb(255, 255, 255)',
                showbackground: true, //Changed this
                showgrid:true, //Added this
                backgroundcolor: 'rgb(230, 230, 230)',
                tickmode:'array',
                nticks: 5,
                tickvals: [0,(DataArrayy.length/4),(DataArrayy.length/4)*2,(DataArrayy.length/4)*3,DataArrayy.length],
                ticktext: [parseFloat(DataArrayy[0]).toFixed(2),parseFloat(DataArrayy[V1]).toFixed(2),parseFloat(DataArrayy[V2]).toFixed(2),parseFloat(DataArrayy[V3]).toFixed(2),parseFloat(DataArrayy[V4]).toFixed(2)]
              },
            zaxis: {
                title: DataArray[1][1],
                gridcolor: 'rgb(255, 255, 255)',
                zerolinecolor: 'rgb(255, 255, 255)',
                showbackground: true, //Changed this
                showgrid:true, //Added this
                backgroundcolor: 'rgb(230, 230,230)'
            },
            aspectratio: {x: 1, y: 1, z: 0.7},
            aspectmode: 'manual'
      }
    }
    layout.title = {
    //  text: '<b>3D Surface</b>',
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
      toImageButtonOptions: {
        format: 'svg',
        filename: 'plot',
        height: 600,
        width: 800,
        scale: 1
      }}
    Plotly.plot("bar", data, layout, config);

// ALERT THE CLICKED POINT
var myPlot = document.getElementById('bar');
myPlot.on('plotly_click', function(data){
if(document.getElementById('signal_selection').checked) {
var px;
var py;

var col_iv;
var col_tran;
for(var i=0; i < data.points.length; i++){
  px=data.points[i].x;
  py=data.points[i].y;
}
col_tran=DataArrayz[parseInt(py)];
col_iv=arrayColumn(DataArrayz, parseInt(parseFloat(freqx)*parseFloat(px)));

if (!list_of_plotsV.includes(DataArrayy[parseInt(py)].toFixed(2))){
Plotly.addTraces("transient1", {y: col_tran, x:DataArrayx[0], name:'('+String(ny)+') '+DataArrayy[parseInt(py)].toFixed(2)+' V'});
list_of_plotsV.push(DataArrayy[parseInt(py)].toFixed(2));
ny=ny+1;
}
if (!list_of_plotsT.includes(String(px))){
Plotly.addTraces("iV1", {y: col_iv, x:DataArrayy, name:'('+String(nx)+') '+String(px)+' s'});
list_of_plotsT.push(String(px));
nx=nx+1;
}}});

  function deleteTrace(divId){
    Plotly.deleteTraces(divId, -1);
    if (divId == "transient1"){ny=ny-1; list_of_plotsT.pop();};
    if (divId == "iV1"){nx=nx-1; list_of_plotsV.pop();};

  };
  function deleteAllTrace(divId){
    var myPlot = document.getElementById(divId);
    while(myPlot.data.length>0){
    Plotly.deleteTraces(divId, 0);
  }
  if (divId == "transient1"){ny=1;list_of_plotsV=[];};
  if (divId == "iV1"){nx=1;list_of_plotsT=[];};


};

    function type_of_plot(plot_type_in) {
    plot_type=plot_type_in;
    if (plot_type_in=="contour" || plot_type_in=="heatmap" ){
      data = [{
              z: DataArrayz,
              x:DataArrayx[0],
              type:plot_type,
              colorscale:color_of_plot,
              colorbar: {len:0.5, xpad:30, title:current_title}
      }]
    //Change layout
    layout = {
        margin: {t: 80, b: 80, l: 80, r: 80},
        autosize: true,
        width: 1000,
        height: 600,
        aspectratio: {x: 1, y: 1, z: 0.7},
        aspectmode: 'manual',
        xaxis: {
          title: DataArray[0][1]
  },
  yaxis: {
      title: DataArray[1][0],
      tickmode:'array',
      nticks: 5,
      tickvals: [0,(DataArrayy.length/4),(DataArrayy.length/4)*2,(DataArrayy.length/4)*3,DataArrayy.length-1],
      ticktext: [parseFloat(DataArrayy[0]).toFixed(2),parseFloat(DataArrayy[V1]).toFixed(2),parseFloat(DataArrayy[V2]).toFixed(2),parseFloat(DataArrayy[V3]).toFixed(2),parseFloat(DataArrayy[V4]).toFixed(2)]
    }
      }
      layout.title = {
        text: '<b>2D Colorplot</b>',
        font: {
          size: 20,
          family:'Arial'
        },
        x: 0,
        y: 1.2,
        xanchor: 'left',
        yanchor: 'bottom',
      };
    }

  if (plot_type_in=="surface"){
    data = [{
            z: DataArrayz,
            x:DataArrayx,
            type:plot_type,
            colorscale:color_of_plot,
            colorbar: {len:0.5, xpad:30, title:current_title}
    }]
    layout = {
        margin: {t: 80, b: 25, l: 25, r: 25}, //Changed this
        autosize: true,
        width: 1000,
        height: 600,
        scene: {
            xaxis:{
                title: DataArray[0][1],
                gridcolor: 'rgb(255, 255, 255)',
                zerolinecolor: 'rgb(255, 255, 255)',
                showbackground: true,
                backgroundcolor:'rgb(230, 230,230)',

            },
            yaxis: {
                title: DataArray[1][0],
                gridcolor: 'rgb(255, 255, 255)',
                zerolinecolor: 'rgb(255, 255, 255)',
                showbackground: true,
                backgroundcolor: 'rgb(230, 230, 230)',
                tickmode:'array',
                nticks: 5,
                tickvals: [0,(DataArrayy.length/4),(DataArrayy.length/4)*2,(DataArrayy.length/4)*3,DataArrayy.length],
                ticktext: [parseFloat(DataArrayy[0]).toFixed(2),parseFloat(DataArrayy[V1]).toFixed(2),parseFloat(DataArrayy[V2]).toFixed(2),parseFloat(DataArrayy[V3]).toFixed(2),parseFloat(DataArrayy[V4]).toFixed(2)]
              },
            zaxis: {
                title: DataArray[1][1],
                gridcolor: 'rgb(255, 255, 255)',
                zerolinecolor: 'rgb(255, 255, 255)',
                showbackground: true,
                backgroundcolor: 'rgb(230, 230,230)'
            },
            aspectratio: {x: 1, y: 1, z: 0.7},
            aspectmode: 'manual'
      }
    }
    layout.title = {
      text: '<b>3D Surface</b>',
      font: {
        size: 20,
        family:'Arial'
      },
      x: 0,
      y: 1.2,
      xanchor: 'left',
      yanchor: 'bottom',
    };

  }
      Plotly.purge("bar");
      Plotly.newPlot("bar", data, layout, config);
      var myPlot = document.getElementById('bar');
      myPlot.on('plotly_click', function(data){
      if(document.getElementById('signal_selection').checked) {
      var px;
      var py;
      var col_iv;
      var col_tran;
      for(var i=0; i < data.points.length; i++){
        px=data.points[i].x;
        py=data.points[i].y;
      }
      col_tran=DataArrayz[parseInt(py)];
      col_iv=arrayColumn(DataArrayz, parseInt(parseFloat(freqx)*parseFloat(px)));

      if (!list_of_plotsV.includes(DataArrayy[parseInt(py)].toFixed(2))){
      Plotly.addTraces("transient1", {y: col_tran, x:DataArrayx[0], name:'('+String(ny)+') '+DataArrayy[parseInt(py)].toFixed(2)+' V'});
      list_of_plotsV.push(DataArrayy[parseInt(py)].toFixed(2));
      ny=ny+1;
      }
      if (!list_of_plotsT.includes(String(px))){
      Plotly.addTraces("iV1", {y: col_iv, x:DataArrayy, name:'('+String(nx)+') '+String(px)+' s'});
      list_of_plotsT.push(String(px));
      nx=nx+1;
      }}});
    }


    function color_palette(color){
      var update;
      if (color=='Traditional'){
        color_of_plot=w_colorscale;
        if (plot_type=='surface'){
          data = [{
               z: DataArrayz,
               x:DataArrayx,
               type:plot_type,
               colorscale:color_of_plot,
               colorbar: {len:0.5, xpad:30, title:current_title}
       }];
       layout = {
           margin: {t: 80, b: 25, l: 25, r: 25},
           autosize: true,
           width: 1000,
           height: 600,
           scene: {
               xaxis:{
                   title: DataArray[0][1],
                   gridcolor: 'rgb(255, 255, 255)',
                   zerolinecolor: 'rgb(255, 255, 255)',
                   showbackground: true,
                   backgroundcolor:'rgb(230, 230,230)',

               },
               yaxis: {
                   title: DataArray[1][0],
                   gridcolor: 'rgb(255, 255, 255)',
                   zerolinecolor: 'rgb(255, 255, 255)',
                   showbackground: true,
                   backgroundcolor: 'rgb(230, 230, 230)',
                   tickmode:'array',
                   nticks: 5,
                   tickvals: [0,(DataArrayy.length/4),(DataArrayy.length/4)*2,(DataArrayy.length/4)*3,DataArrayy.length],
                   ticktext: [parseFloat(DataArrayy[0]).toFixed(2),parseFloat(DataArrayy[V1]).toFixed(2),parseFloat(DataArrayy[V2]).toFixed(2),parseFloat(DataArrayy[V3]).toFixed(2),parseFloat(DataArrayy[V4]).toFixed(2)]
                 },
               zaxis: {
                   title: DataArray[1][1],
                   gridcolor: 'rgb(255, 255, 255)',
                   zerolinecolor: 'rgb(255, 255, 255)',
                   showbackground: true,
                   backgroundcolor: 'rgb(230, 230,230)'
               },
               aspectratio: {x: 1, y: 1, z: 0.7},
               aspectmode: 'manual'
         }
       }
       layout.title = {
         text: '<b>3D Surface</b>',
         font: {
           size: 20,
           family:'Arial'
         },
         x: 0,
         y: 1.2,
         xanchor: 'left',
         yanchor: 'bottom',
       };

       config = {
         showEditInChartStudio: true,
         plotlyServerURL: "https://chart-studio.plotly.com",
          displayModeBar: true,
          displaylogo: false,
         toImageButtonOptions: {
           format: 'svg',
           filename: 'plot',
           height: 600,
           width: 800,
           scale: 1
         }}
       Plotly.purge("bar");
       Plotly.newPlot("bar", data, layout, config);
     }
       else {
         type_of_plot(plot_type);
       }

      }

      else{
      color_of_plot=color;
      update = {colorscale:color_of_plot};
      Plotly.restyle('bar', update);
    }
    }

    </script>
<script>
//1D transient plots
var data=[];
var layout = {
  width: 450,
  height: 450,
  legend: {"orientation": "h", "y":-0.3},
  xaxis:{
      title: DataArray[0][1]
},
yaxis:{
    title: DataArray[1][1]
}
};
layout.title = {
  text: '<b>1D Transient</b>',
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
  toImageButtonOptions: {
    format: 'svg',
    filename: 'plot',
    height: 600,
    width: 800,
    scale: 1
  }}

Plotly.newPlot('transient1', data, layout, config);
//i-V plot
var data=[];

var layout = {
  width: 450,
  height: 450,
  legend: {"orientation": "h", "y":-0.3},
  xaxis:{
      title:DataArray[1][0]
},
yaxis:{
    title: DataArray[1][1]
}
};
layout.title = {
  text: '<b>i-V Plot</b>',
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
  toImageButtonOptions: {
    format: 'svg',
    filename: 'plot',
    height: 600,
    width: 800,
    scale: 1
  }}
Plotly.newPlot('iV1', data, layout, config);
</script>

<script>
var data1=[];
var layout1 = {
  width: 450,
  height: 450,
  legend: {"orientation": "h", "y":-0.3},
  xaxis:{
      title: DataArray[0][1]
},
yaxis:{
    title: DataArray[1][1]
}
};
var config1 = {
  showEditInChartStudio: true,
  plotlyServerURL: "https://chart-studio.plotly.com",
   displayModeBar: true,
   displaylogo: false,
  toImageButtonOptions: {
    format: 'svg',
    filename: 'plot',
    height: 600,
    width: 1200,
    scale: 1
  }}
  var data2=[];
  var layout2 = {
    width: 450,
    height: 450,
    legend: {"orientation": "h", "y":-0.3},
    xaxis:{
        title: DataArray[0][1]
  },
  yaxis:{
      title: 'Concentration'
  }
  };
  var config2 = {
    showEditInChartStudio: true,
    plotlyServerURL: "https://chart-studio.plotly.com",
     displayModeBar: true,
     displaylogo: false,
    toImageButtonOptions: {
      format: 'svg',
      filename: 'plot',
      height: 600,
      width: 1200,
      scale: 1
    }}

Plotly.newPlot('calibration1', data1, layout1, config1);
Plotly.newPlot('calibration2', data2, layout2, config2);
</script>

<script>
function calibration_function(){
var plotDiv = document.getElementById("calibration"+String(calib_num));
var CalCoeff = parseFloat(document.getElementById("CalCoeff").value);
var CalCoeffUnit= document.getElementById("CalCoeffUnit").value;
var namesignals=document.getElementById("namesignals").value;
var nsignals= document.getElementById("nsignals").value;
var transient_data= document.getElementById("transient1").data;
var iV_data= document.getElementById("iV1").data;
var nsignals_array;
var transient_array;
var total_sum=0.0;
var point;
var Csignal;
var yunits=CalCoeffUnit.split("/");
var CurrentCoeffUnits="("+yunits[1]+")";
con_units=CalCoeffUnit[0];
nsignals=nsignals.split(",");
nsignals_array=nsignals.map(function(element){
   return parseInt(element)-1;
});

if (CurrentCoeffUnits!=current_units){
  Swal.fire({
  icon: 'error',
  title: "Units Error",
  text: "Calibration coefficient units for Current do not match the current units of the data. Please try again converting the calibration coefficient units."
})
  return;
}

var update = {
  legend: {"orientation": "h", "y":-0.3},
  title:{
  text: '<b>'+namesignals+'</b>',
  font: {
    size: 20,
    family:'Arial'},
    x: 0,
    y: 1.2,
    xanchor: 'left',
    yanchor: 'bottom'
  },
  yaxis:{
      title: 'Concentration ('+yunits[0]+')'
},
xaxis:{
    title: DataArray[0][1]
}
};
var config ={
  showEditInChartStudio: true,
  plotlyServerURL: "https://chart-studio.plotly.com",
   displayModeBar: true,
   displaylogo: false,
  toImageButtonOptions: {
    format: 'svg',
    filename: 'plot',
    height: 600,
    width: 800,
    scale: 1
  }};
var data=[];
Plotly.purge(plotDiv);
Plotly.newPlot(plotDiv,data,update,config);
//Loop through the signals
for (var i=0;i<nsignals_array.length;i++){
Csignal=transient_data[nsignals_array[i]].y.map(function(element){
   return parseFloat(element)*CalCoeff;
});
Plotly.addTraces(plotDiv, {y: Csignal, x:DataArrayx[0], name:'('+String(nsignals_array[i]+1)+') '+parseFloat(list_of_plotsV[parseInt(nsignals_array[i])]).toFixed(2)+' V'});

if (i==0 && num_of_calibrations==1){
  Array_for_table[0] = [namesignals+' ('+String(parseInt(nsignals_array[i])+1)+') '+parseFloat(list_of_plotsV[parseInt(nsignals_array[i])]).toFixed(2)+' V','-','-','-','-','-','-','-','-','-','-','-','-','-','-'];
  Array_for_table[1] = [DataArray[0][1],'Current '+CurrentCoeffUnits,'Concentration ('+yunits[0]+')','Max ('+yunits[0]+')', 'Max '+time_units, 't½ '+time_units, 'StDev(T½)','C0','K','StDev(C0)','StDev(K)','p-value(C0)', 'p-value(K)','R^2 score','-'];
} else {
Array_for_table[0].push(namesignals+' ('+String(parseInt(nsignals_array[i])+1)+') '+parseFloat(list_of_plotsV[parseInt(nsignals_array[i])]).toFixed(2)+' V','-','-','-','-','-','-','-','-','-','-','-','-','-','-');
Array_for_table[1].push(DataArray[0][1],'Current '+CurrentCoeffUnits,'Concentration ('+yunits[0]+')','Max ('+yunits[0]+')', 'Max '+time_units, 't½ '+time_units, 'StDev(T½)','C0','K','StDev(C0)','StDev(K)','p-value(C0)', 'p-value(K)','R^2 score','-');
};


transient_array=transient_data[nsignals_array[i]].y;
//API CALL FOR THE MAX POINTS
total_sum = Csignal.reduce((a, b) => a + b, 0);
API_peaks(Csignal,time_array,total_sum,Csignal);

for (var d=0;d<transient_array.length;d++){ //This will be wrong
  if (i==0 && num_of_calibrations==1){
    if (d==0){
Array_for_table.push([DataArrayx[0][d],transient_array[d], Csignal[d], maxpoint[1], maxpoint[0], T_half, std_thalf, param1_fit, param2_fit, std1_fit, std2_fit, pval, pval2, r2,'-']);
} else {Array_for_table.push([DataArrayx[0][d],transient_array[d], Csignal[d],' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ','-']);};
} else { if (d==0) {
  Array_for_table[d+2].push(DataArrayx[0][d],transient_array[d], Csignal[d],maxpoint[1], maxpoint[0], T_half, std_thalf, param1_fit, param2_fit, std1_fit, std2_fit, pval, pval2, r2,'-');
}else {Array_for_table[d+2].push(DataArrayx[0][d],transient_array[d], Csignal[d],' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ','-');}};
};
};
if (calib_num==1){calib_num=2} else{calib_num=1};
num_of_calibrations+=1;

};




</script>

<script>
//functions for the API call.

function API_peaks(coln, col1, total_sum, signal_array) { //Change function to match the
var signal;
var ytype='Concentration';
var max_signal;
var min_signal;
var API_dir;
var period;


var settings_API;
var k;
signal=coln.join('+');
max_signal=Math.abs(max(signal_array));
min_signal=Math.abs(min(signal_array));
period=String(parseFloat(col1[5])-parseFloat(col1[4]));
if (Math.floor(total_sum*100)<Math.floor(0.0*100)){if (min_signal>max_signal){sign="negative"}}
else {sign="positive"};
API_dir="https://py-dot-neurodatalab.nw.r.appspot.com/peaks?"+"sign="+sign+"&signal="+signal+"&period="+period+"&ytype="+ytype;
settings_API = {
                async: false,
                crossDomain: true,
                contentType: "text/plain",
                xhrFields: {withCredentials: true},
                url: API_dir,
                type: "GET"
              };
$.ajax(settings_API).done(function (response_API) {
content_API = response_API.split("&");
Area_curve=parseFloat(content_API[1]);
if (content_API=="NaN") {Array_of_Peaks=[];}
else {
 x_points=content_API[0].split(" ");
 // PARAMETERS OF THE EXPONENTIAL FIT
 param1_fit=parseFloat(content_API[2]).toFixed(2);
 param2_fit=parseFloat(content_API[3]).toFixed(2);
 r2=parseFloat(content_API[4]).toFixed(3);
 pval=parseFloat(content_API[5]).toFixed(4);
 pval2=parseFloat(content_API[6]).toFixed(4);
 T_half=parseFloat(content_API[7]);
 decay_x=content_API[8].split(" ");
 std1_fit=parseFloat(content_API[9]).toFixed(2);
 std2_fit=parseFloat(content_API[10]).toFixed(2);
 std_thalf=parseFloat(content_API[11]).toFixed(2);





  maxpoint=[parseFloat(parseFloat(col1[parseInt(x_points[0])]).toFixed(2)), parseFloat(parseFloat(coln[parseInt(x_points[0])]).toFixed(2))];
  Array_of_Peaks.push(maxpoint);}
  Array_of_ypeaks.push(maxpoint[1]);
  Array_of_xpeaks.push(maxpoint[0]);


});
};


function max(num){
return Math.max.apply(null, num);
}
function min(num){
return Math.min.apply(null, num);
}
</script>

<script>
function export_function(){
var data_selected=" ";
var typeofdata = document.getElementsByName('typeofdata');
for(i = 0; i < typeofdata.length; i++) {
    if(typeofdata[i].checked) {
    data_selected=typeofdata[i].value;
  };
};
if (data_selected == '3d_colorplot') {export_function2(); return;}
else if (data_selected ==' '){ Swal.fire({
  icon: 'error',
  title: "Data Selection Error",
  text: "Data type to export has not been selected. Please select the type of data to export in the CSV file."
});
return;
}




var namesignalsexp=String(document.getElementById("namesignalsexp").value);
//Create the table from Array_for_table
var table_text= '\
<table class ="table-hover" style="width:100%">\
<tr>\
';

for (var j=0;j<Array_for_table.length;j++){
for (var i=0; i<Array_for_table[0].length;i++){
if (i==0) {
table_text+='<tr>\
';};
table_text+='<td>'+Array_for_table[j][i]+'</td>\
';
if (i==(Array_for_table.length-1)) {table_text+='</tr>'}; //Check if it works
};
};
table_text+='</table>';
document.getElementById('hidden_table').innerHTML = table_text;
document.getElementById("xx").click();

};

function export_function2(){
//Create the table from DataArrayz
var namesignalsexp=String(document.getElementById("namesignalsexp").value);
var csvContent = "data:text/csv;charset=utf-8,"
    + DataArrayz.map(e => e.join(",")).join("\n");
var encodedUri = encodeURI(csvContent);
var link = document.createElement("a");
link.setAttribute("href", encodedUri);
link.setAttribute("download", namesignalsexp);
document.body.appendChild(link); // Required for FF
link.click();
}
</script>



<script>

function convolution_function(){
//Read parameters from inputs:
var kernel_size = parseInt(document.getElementById("ksize").value);
var repetitions = parseInt(document.getElementById("reps").value);
var kernel_selected=" ";
var typeofkernel = document.getElementsByName('typeofkernel');
for(i = 0; i < typeofkernel.length; i++) {
    if(typeofkernel[i].checked) {
    kernel_selected=typeofkernel[i].value;
    }
};


//FFT SECTION with javascript
var linear_array = Array.prototype.concat.apply([], DataArrayz);
var row_length=DataArrayz[0].length;

var rows=DataArrayz.length;
var columns=DataArrayz[0].length;
var min_linear_array=getMin(linear_array);
var max_linear_array=getMax(linear_array);
var normalized_array=linear_array.map(x => normalize(x,max_linear_array,min_linear_array));

var denormalized_array=normalized_array.map(x => denormalize(x,max_linear_array,min_linear_array));
let mat = cv.matFromArray(rows, columns, cv.CV_32F, normalized_array);
let src = mat.clone();

let ksize = new cv.Size(kernel_size, kernel_size);
let anchor = new cv.Point(-1, -1);
// You can try more different parameters
for (var i=0; i<repetitions;i++) {
  if (kernel_selected =='Gaussian'){cv.GaussianBlur(src, src, ksize, 0, 0, cv.BORDER_DEFAULT)}
  else if (kernel_selected =='Uniform'){cv.blur(src, src, ksize, anchor, cv.BORDER_DEFAULT);}
  else {
    Swal.fire({
    icon: 'error',
    title: "Kernel Error",
    text: "Kernel type has not been selected. Please select the type of kernel to convolute with the signal."
  });
  return;
};
};
//Retrieve the array
var Gaussian_Array=Array.from((src.data32F).map(x => denormalize(x,max_linear_array,min_linear_array)));
// Split the linear array
DataArrayz= chunk(Gaussian_Array,row_length);
// Replot the Colorplot after smoothing
type_of_plot(plot_type);
src.delete(); mat.delete();
};

cv['onRuntimeInitialized']=()=>{
document.getElementById("ConvButton").disabled = false;
};





function get_2DFFT(){
  var linear_array = Array.prototype.concat.apply([], DataArrayz);
  var rows=DataArrayz.length;
  var columns=DataArrayz[0].length;
  freqy=document.getElementById("samplingfrequency").value;
  if (freqy == ""){Swal.fire({
  icon: 'error',
  title: "Input Error",
  text: "Sampling frequency is missing. Please try again introducing the sampling frequency of your signal acquisition."
  }); return;};
  let mat = cv.matFromArray(rows, columns, cv.CV_32F, linear_array);
  let fft_spectrum = new cv.Mat();
  let src = mat.clone();
  // get optimal size of DFT
  let optimalRows = cv.getOptimalDFTSize(src.rows);
  let optimalCols = cv.getOptimalDFTSize(src.cols);
  let s0 = cv.Scalar.all(0);
  let padded = new cv.Mat();
  cv.copyMakeBorder(src, padded, 0, optimalRows - src.rows, 0,
                   optimalCols - src.cols, cv.BORDER_CONSTANT, s0);
  // use cv.MatVector to distribute space for real part and imaginary part
  let plane0 = new cv.Mat();
  padded.convertTo(plane0, cv.CV_32F);
  let planes = new cv.MatVector();
  let complexI = new cv.Mat();
  let plane1 = new cv.Mat.zeros(padded.rows, padded.cols, cv.CV_32F);
  planes.push_back(plane0);
  planes.push_back(plane1);
  cv.merge(planes, complexI); //This is only adding a matrix of zeros as Imaginary to the original matrix.
  // in-place dft transform
  fft_spectrum = new cv.Mat();
  cv.dft(complexI, fft_spectrum);
  //Get the magnitude
  cv.split(fft_spectrum, planes);
  cv.magnitude(planes.get(0), planes.get(1), planes.get(0)); //Calculates the magnitude and puts it in planes.get(0)
  let mag = planes.get(0);
  let m1 = new cv.Mat.ones(mag.rows, mag.cols, mag.type());
  cv.add(mag, m1, mag); //Adding one to the magnitude


  // crop the spectrum, if it has an odd number of rows or columns
  let rect = new cv.Rect(0, 0, mag.cols & -2, mag.rows & -2);
  mag = mag.roi(rect);
  // rearrange the quadrants of Fourier image
  // so that the origin is at the image center
  let cx = mag.cols / 2;
  let cy = mag.rows / 2;
  let tmp = new cv.Mat();

  let rect0 = new cv.Rect(0, 0, cx, cy);
  let rect1 = new cv.Rect(cx, 0, cx, cy);
  let rect2 = new cv.Rect(0, cy, cx, cy);
  let rect3 = new cv.Rect(cx, cy, cx, cy);

  let q0 = mag.roi(rect0);
  let q1 = mag.roi(rect1);
  let q2 = mag.roi(rect2);
  let q3 = mag.roi(rect3);

  // exchange 1 and 4 quadrants
  q0.copyTo(tmp);
  q3.copyTo(q0);
  tmp.copyTo(q3);

  // exchange 2 and 3 quadrants
  q1.copyTo(tmp);
  q2.copyTo(q1);
  tmp.copyTo(q2);

magnitude_spectrum= Array.from(mag.data32F);
magnitude_spectrum=magnitude_spectrum.map( x => 20*Math.log10(x)); //Convert to dBs
magnitude_array=[];
while(magnitude_spectrum.length) magnitude_array.push(magnitude_spectrum.splice(0,columns));
//Generate Freqx array
var FreqxArray=[];
var FreqyArray=[];
for (var i=-parseInt(columns/2);i<parseInt(columns/2);i++){FreqxArray.push(i*(1/((parseFloat(columns))/freqx)))}; // Spacing of k-space calculated as 1/FOV
for (var i=-parseInt(rows/2);i<parseInt(rows/2);i++){FreqyArray.push(i*(1/((parseFloat(rows))/freqy)))};

//Plot the 2D FFT
config = {
 showEditInChartStudio: true,
 plotlyServerURL: "https://chart-studio.plotly.com",
  displayModeBar: true,
  displaylogo: false,
 toImageButtonOptions: {
   format: 'svg',
   filename: 'plot',
   height: 600,
   width: 800,
   scale: 1
 }};
data = [{
        z: magnitude_array,
        x:FreqxArray,
        y:FreqyArray,
        type:'heatmap',
        colorscale:'Greys',
        colorbar: {len:0.5, xpad:30, title:'Magnitude (dB)'+current_units}
}];
layout = {
    margin: {t: 80, b: 80, l: 80, r: 80}, //Changed this
    autosize: true,
    width: 1000,
    height: 600,
        xaxis:{
            title: 'Frequency '+time_units+'<sup>-1</sup>',
            gridcolor: 'rgb(255, 255, 255)',
            zerolinecolor: 'rgb(255, 255, 255)',
            showbackground: true,
            backgroundcolor:'rgb(230, 230,230)',

        },
        yaxis: {
            title: 'Frequency '+time_units+'<sup>-1</sup>',
            gridcolor: 'rgb(255, 255, 255)',
            zerolinecolor: 'rgb(255, 255, 255)',
            showbackground: true,
            backgroundcolor: 'rgb(230, 230, 230)'
          },
        zaxis: {
            title: 'Magnitude (dB)'+current_units,
            gridcolor: 'rgb(255, 255, 255)',
            zerolinecolor: 'rgb(255, 255, 255)',
            showbackground: true,
            backgroundcolor: 'rgb(230, 230,230)'
        },
        aspectratio: {x: 1, y: 1, z: 0.7},
        aspectmode: 'manual'

}
layout.title = {
  text: '<b>2D FFT Spectrum</b>',
  font: {
    size: 20,
    family:'Arial'
  },
  x: 0,
  y: 1.2,
  xanchor: 'left',
  yanchor: 'bottom',
};




Plotly.purge("bar");
Plotly.newPlot("bar", data, layout, config);
var myPlot = document.getElementById('bar');
myPlot.on('plotly_click', function(data){
if(document.getElementById('signal_selection').checked) {
var px;
var py;

for(var i=0; i < data.points.length; i++){
  px=data.points[i].pointIndex[1];
  py=data.points[i].pointIndex[0];
}
//Convert to percentage:

//px=parseInt((Math.abs((px-parseFloat(columns)/2))/(parseFloat(columns))/2)*100);
//py=parseInt((Math.abs((py-parseFloat(rows)/2))/(parseFloat(rows))/2)*100);

px=parseInt(100*(Math.abs(px-columns/2)/(parseFloat(columns)/2)));
py=parseInt(100*(Math.abs(py-rows/2)/(parseFloat(rows)/2)));
document.getElementById("hsize").setAttribute('value',px);
output1 = document.getElementById("slider1");
output1.innerHTML = px;
document.getElementById("vsize").setAttribute('value',py);
output2 = document.getElementById("slider2");
output2.innerHTML = py;
}});
return fft_spectrum;
};

function close_2DFFT(){
  Plotly.purge("bar");
  type_of_plot(plot_type);
};


function normalize(val0, max0, min0) { return (val0 - min0) / (max0 - min0);};
function denormalize(val0, max0, min0) { return (val0*(max0-min0))+min0;};
//Max and min functions for large arrays where min() and max() do not work.
function getMax(arr) {
    return arr.reduce((max, v) => max >= v ? max : v, -Infinity);
}
function getMin(arr) {
    return arr.reduce((min, v) => min <= v ? min : v, Infinity);
}

function chunk(arr, size) {
  var chunkedArray = [];
  while ( arr.length > 0 ) {
    chunkedArray.push( arr.splice( 0, size ) );
  }
  return chunkedArray;
}
</script>





<script>

function FFT_function() {
let fft_spectrum = get_2DFFT();
 //The spectrum here is the raw unshifted one
// Shift the spectrum so the centre is at the centre of the matrix
let cx = fft_spectrum.cols / 2;
let cy = fft_spectrum.rows / 2;
let tmp = new cv.Mat();

let rect0 = new cv.Rect(0, 0, cx, cy);
let rect1 = new cv.Rect(cx, 0, cx, cy);
let rect2 = new cv.Rect(0, cy, cx, cy);
let rect3 = new cv.Rect(cx, cy, cx, cy);

let q0 = fft_spectrum.roi(rect0);
let q1 = fft_spectrum.roi(rect1);
let q2 = fft_spectrum.roi(rect2);
let q3 = fft_spectrum.roi(rect3);


q0.copyTo(tmp);
q3.copyTo(q0);
tmp.copyTo(q3);
q1.copyTo(tmp);
q2.copyTo(q1);
tmp.copyTo(q2);


let returned_image = new cv.Mat();
let planes2 = new cv.MatVector();
var spectrum_cols=parseInt(fft_spectrum.cols);
var spectrum_rows=parseInt(fft_spectrum.rows);
//Trim the fft_spectrum
cv.split(fft_spectrum, planes2);
var fft_real = Array.from(planes2.get(0).data32F);
var fft_real_array=[];
var fft_im = Array.from(planes2.get(1).data32F);
var fft_im_array=[];
while(fft_real.length) {
fft_real_array.push(fft_real.splice(0,spectrum_cols));
fft_im_array.push(fft_im.splice(0,spectrum_cols));
};
var central_col=parseInt(spectrum_cols/2);
var central_row=parseInt(spectrum_rows/2);
var cutting_col_low=parseInt(central_col-(((document.getElementById("hsize").value)/100)*spectrum_cols/2));
var cutting_row_low=parseInt(central_row-(((document.getElementById("vsize").value)/100)*spectrum_rows/2));
var cutting_col_high=parseInt(central_col+(((document.getElementById("hsize").value)/100)*spectrum_cols/2));
var cutting_row_high=parseInt(central_row+(((document.getElementById("vsize").value)/100)*spectrum_rows/2));
var new_fft_real=zeros([spectrum_rows,spectrum_cols]);
var new_fft_im=zeros([spectrum_rows,spectrum_cols]);

for (var i=cutting_row_low;i<cutting_row_high;i++){
for (var j=cutting_col_low;j<cutting_col_high;j++){
new_fft_real[i][j]=fft_real_array[i][j];
new_fft_im[i][j]=fft_im_array[i][j];
}};

//Pass the partial reconstruction to opencv.js object
planes2=new cv.MatVector();
var linear_new_fft_real = Array.prototype.concat.apply([], new_fft_real);
var linear_new_fft_im =  Array.prototype.concat.apply([], new_fft_im);
let mat_linear_real = cv.matFromArray(spectrum_rows, spectrum_cols, cv.CV_32F, linear_new_fft_real);
let mat_linear_im = cv.matFromArray(spectrum_rows, spectrum_cols, cv.CV_32F, linear_new_fft_im);
let partial_fft = new cv.Mat();
planes2.push_back(mat_linear_real);
planes2.push_back(mat_linear_im);
cv.merge(planes2, partial_fft);
// Now the partial fft needs to be unshifted:
q0 = partial_fft.roi(rect0);
q1 = partial_fft.roi(rect1);
q2 = partial_fft.roi(rect2);
q3 = partial_fft.roi(rect3);
q0.copyTo(tmp);
q3.copyTo(q0);
tmp.copyTo(q3);
q1.copyTo(tmp);
q2.copyTo(q1);
tmp.copyTo(q2);
console.log(partial_fft);
// PLotting to check
cv.dft(partial_fft, returned_image, (cv.DFT_INVERSE, cv.DFT_REAL_OUTPUT, cv.DFT_SCALE));
planes2=new cv.MatVector();
cv.split(returned_image, planes2);
let returned_image2 = planes2.get(0);
var new_data=Array.from(returned_image2.data32F).reverse();
console.log(new_data);
var new_DataArrayz = chunk(new_data,spectrum_cols);
console.log(new_DataArrayz);
DataArrayz=new_DataArrayz;
type_of_plot(plot_type);
};


function reset_all(){
DataArrayz=originalDataArrayz;
color_of_plot=w_colorscale;
plot_type='surface';
document.getElementById('hidden_table').innerHTML = "";
table_text="";
deleteAllTrace('transient1');
deleteAllTrace('iV1');
deleteAllTrace('iV1');
deleteAllTrace('calibration1');
deleteAllTrace('calibration2');
list_of_plotsT=[];
nx=1;
ny=1;
calib_num=1;


returned_current=0;
num_of_calibrations=1;
list_of_plotsV=[];
Array_of_Peaks=[];
Array_of_ypeaks=[];
Array_of_xpeaks=[];
Array_for_table=[];
list_of_plotsT=[];
list_of_plotsV=[];
type_of_plot(plot_type);
}

function invert_colorplot(){
var tempArray = DataArrayz.map(arr => arr.map(x => -x));
DataArrayz=tempArray;
type_of_plot(plot_type);
}

function zeros(dimensions) {
    var array = [];

    for (var i = 0; i < dimensions[0]; ++i) {
        array.push(dimensions.length == 1 ? 0 : zeros(dimensions.slice(1)));
    }

    return array;
}

</script>






<script>
function downloadPDF(){
  var element = document.getElementById('wrapper');
  var opt = {
  margin:       0,
  filename:     'myfile.pdf',
  image:        { type: 'png', quality: 1},
  pagebreak: { mode: 'avoid-all' },
  html2canvas:  { scale: 1 , backgroundColor:'#eff4f7'},
  jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
};

html2pdf().set(opt).from(element).save();
};
</script>


    </div>

    </body>

    </html>



  </body>
</html>
