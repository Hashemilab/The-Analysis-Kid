<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="jquery-3.5.1.min.js"></script>
    <script src="dashboard/html2pdf.bundle.min.js"></script>
    <script src="dashboard/sweetalert.min.js"></script>
    <script src="https://kit.fontawesome.com/828d573e3a.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script type="text/javascript" id="MathJax-script" async
      src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js">
    </script>

    <title>Kinetic Calibration Dashboard</title>
    <link rel="shortcut icon" href="cv.png" />


    <link
      rel="stylesheet"
      href="dashboard/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="dashboard/buttons.css"
    />

    <link
      rel="stylesheet"
      href="dashboard/font-awesome.min.css"
    />
    <link
      href="dashboard/google-css.css"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="dashboard/styles.css" />
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
      background: url("loading.gif") center no-repeat #eff4f7;
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
              <h1 contenteditable="true">Kinetic Calibration Dashboard</h1>
            </div>
            <br>
            <button class="btn btn-primary">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <a id="inversion" onclick="invert_trace()" style="color:white;">Invert Sign</a>
            </button>
            <button class="btn btn-primary" id="fusionexport-btn" onClick="downloadPDF()">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <span class="btn-text">Download as PDF</span>
            </button>
            <div id="hidden_table" style="display: none;"></div>
          </div>

          <div class="main">
            </div>

            <div class="row mt-4 mb-4">
              <div class="col-md-6">
                <div class="box">
                  <div id="transientAUC"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="box">
                  <div id="transient2"></div>
                  <div id="delete" style="margin-left:10px;position:relative;bottom:410px;left:295px;">
     <button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteTrace('transient2')">Delete Last</button>
     <button class="btn btn-primary" style=" font-size: 10px;" onclick="deleteAllTrace('transient2')">Erase All</button>
 </div>
                </div>
              </div>
            </div>
            <div class="row sparkboxes mt-4 mb-4">
              <div class="col-md-4">
                <div class="box box1">
                  <div id="spark1">
                    <div style="height: 180px;">
                    <p style="font-size:20px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><b>Deconvolution Panel</b>&nbsp;&nbsp; &nbsp; <button class="btn btn-primary" onclick="API_deconvolution()" style=" font-size: 10px;" id="DECONV_apply">Apply</button></p>
                    <p style="margin:0;">
                      <label for="diffusion" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Diffusion coeff. (cm<sup>2</sup>/s): &nbsp;&nbsp;</label>
                    <input type="number" step="0.000001" name="diffusion" id="diffusion" style="width:80px;font-size:12px;" value=0.000002 min=0 />&nbsp;&nbsp;
                    </p>
                    <p style="margin:0;">
                    <label for="abso" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Absorption Strength (cm): &nbsp;&nbsp;</label>
                    <input type="number" step="0.001" name="abso" id="abso" style="width:80px;font-size:12px;" value = 0.0055 min=0/>
                    </p>
                    <p style="margin:0;">
                      <label for="name_trace" style="font-size:12px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;">&#8226; Name: &nbsp;&nbsp;</label>
                    <input type="text" name="name_trace" id="name_trace" style="width:80px;font-size:12px;" />&nbsp;&nbsp;
                    </p>
                    </div>
                   </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box box2">
                  <div id="spark2"> <div style="height: 180px;">
                    <div class="notepad">
                        <div class="paper" contenteditable="true">
                         Write your notes here.
                        </div>
                      </div>

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

       <p style="margin:20px; font-size:10px;color:black;font-family:Arial, Helvetica, sans-serif;">The exported csv file will contain the charge trace and the last concentration trace obtained from the kinetic calibration.</p>
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
    <script src="dashboard/axios.min.js"></script>
    <script src="exportTabletoCSV.js"></script>




    <script>
    // Table entries and variables
var button_layer_1_height = 1
var annotation_offset = 0.04
var Array_of_Peaks=[];
var Array_of_AUC=[];
Array_of_Csurface=[];
var Area;
var Array_of_ypeaks=[];
var Array_of_xpeaks=[];
var x_points;
var Array_for_table=[];
var maxpoint;
var content_API;
var DeconSignal;
var current_title=DataArray[1][1];
var current_units = (DataArray[1][1].split(' '))[1];
var time_units=DataArray[0][1].split(' ')[1];
var F_constant = 26.801*(10**(9))*3600 //nA·s/mol
var maxV;
var table_text;


function max(num){
return Math.max.apply(null, num);
};
function min(num){
return Math.min.apply(null, num);
};
function indexOfMax(arr) {
    if (arr.length === 0) {
        return -1;
    }

    var max = arr[0];
    var maxIndex = 0;

    for (var i = 1; i < arr.length; i++) {
        if (arr[i] > max) {
            maxIndex = i;
            max = arr[i];
        }
    }

    return maxIndex;
};
function arrayColumn(arr, n) {
return arr.map(x=> x[n]);
}
function trap_auc(arr){
var area = 0;
for(var i=1; i<arr.length; i++) {
area += 0.5 * (arr[i] + arr[i-1]) * (1/freqy);
};
return area;
};

DataArrayz=DataArray.slice(2,DataArray.length+1).map(function(row){return row.slice(2,DataArray[0].length+1);});
DataArrayx0=DataArray[0].slice(2,DataArray[0].length+1);
DataArrayx=[];
for(i = 0; i < DataArrayz.length; i++) {
DataArrayx.push(DataArrayx0);
}
DataArrayy=arrayColumn(DataArray,0).splice(2,DataArray.length+1);
var time_array=DataArrayx[0];
var Vlength=DataArrayy.length;
var freqx=parseInt(1/(parseFloat(DataArrayx[0][1])-parseFloat(DataArrayx[0][0])));
//Get the oxidation part of Peaks
maxV=indexOfMax(DataArrayy);


//Calculate area of oxidayion peak for each CV
for(i = 0; i < DataArrayz[0].length; i++) {
Area=trap_auc(arrayColumn(DataArrayz.slice(startAUC,endAUC),i));
console.log(startAUC);
console.log(endAUC);
console.log(freqx);
Array_of_AUC.push(Area); //With units nA*s = nNF
Array_of_Csurface.push((Area/(n*F_constant*surface))*10**10); // Units mol/dm^2
}


</script>
<script>
//1D transient plots

var dataAUC=[{y: Array_of_AUC, x:DataArrayx[0], name:'AUC array'}];
var layoutAUC = {
  width: 450,
  height: 450,
  legend: {"orientation": "h", "y":-0.3},
  xaxis:{
      title: DataArray[0][1]
},
yaxis:{
    title: 'Charge '+current_units+time_units
}
};
layoutAUC.title = {
  text: '<b>Oxidation AUC</b>',
  font: {
    size: 20,
    family:'Arial'
  },
  x: 0,
  y: 1.2,
  xanchor: 'left',
  yanchor: 'bottom',
};
var configAUC = {
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

Plotly.newPlot('transientAUC', dataAUC, layoutAUC, configAUC);
//i-V plot
var data=[];

var layout = {
  width: 450,
  height: 450,
  legend: {"orientation": "h", "y":-0.3},
  xaxis:{
      title:DataArray[0][1]
},
yaxis:{
    title: 'Concentration (M)'
}
};
layout.title = {
  text: '<b>Calibrated Concentration</b>',
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
    width: 1200,
    scale: 1
  }}
Plotly.newPlot('transient2', data, layout, config);
</script>


<script>
function API_deconvolution(){
var signal=Array_of_Csurface.join('+');
var Ts=String(1/freqx);
var name_trace=String(document.getElementById("name_trace").value);
var Diff = parseFloat(document.getElementById("diffusion").value);
var b = parseFloat(document.getElementById("abso").value);
var API_dir="https://py-dot-neurodatalab.nw.r.appspot.com/deconvolution?"+"Ts="+Ts+"&D="+Diff+"&b="+b+"&signal="+signal;
var settings_API = {
    async: false,
    crossDomain: true,
    contentType: "text/plain",
    xhrFields: {withCredentials: true },
    url: API_dir,
    type: "GET"
  };
  $.ajax(settings_API).done(function (response_API) {
    content_API = response_API;
  });
  DeconSignal = content_API.split(" ");
  Plotly.addTraces("transient2", {y: DeconSignal, x:DataArrayx[0], name: name_trace});
}

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
 seoe=parseFloat(content_API[12]).toFixed(4);




  maxpoint=[parseFloat(parseFloat(col1[parseInt(x_points[0])]).toFixed(2)), parseFloat(parseFloat(coln[parseInt(x_points[0])]).toFixed(2))];
  Array_of_Peaks.push(maxpoint);}
  Array_of_ypeaks.push(maxpoint[1]);
  Array_of_xpeaks.push(maxpoint[0]);


});
};
function export_function(){
var namesignalsexp=String(document.getElementById("namesignalsexp").value);
if (DeconSignal == "" || Array_of_AUC==[]){
  Swal.fire({
  icon: 'error',
  title: "Calibration Error",
  text: "No calibrated signal has been found. Please try again by obtaining a calibrated signal before exporting data."
});
  return;
};
var table_text= '\
<table class ="table-hover" style="width:100%">\
<tr>\
<th> Charge '+current_units+time_units+' </th>\
 <th > Concentration (M) </th>\
</tr>\
';

for (var j=0;j<Array_of_AUC.length;j++){

table_text+='<tr>\
<td>'+Array_of_AUC[j]+'</td>\
<td>'+DeconSignal[j]+'</td>\
';
};
table_text+='</table>';
document.getElementById('hidden_table').innerHTML = table_text;
document.getElementById("xx").click();
};
function deleteTrace(divId){
  Plotly.deleteTraces(divId, -1);
  if (divId == "transientAUC"){ny=ny-1; list_of_plotsT.pop();};
  if (divId == "iV1"){nx=nx-1; list_of_plotsV.pop();};

};
function deleteAllTrace(divId){
  var myPlot = document.getElementById(divId);
  while(myPlot.data.length>0){
  Plotly.deleteTraces(divId, 0);
}};
function invert_trace(){
Plotly.purge("transientAUC");
Array_of_AUC = Array_of_AUC.map(x => -x);
Array_of_Csurface = Array_of_Csurface.map(x => -x);
dataAUC=[{y: Array_of_AUC, x:DataArrayx[0], name:'AUC array'}];
Plotly.newPlot('transientAUC', dataAUC, layoutAUC, configAUC);
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
