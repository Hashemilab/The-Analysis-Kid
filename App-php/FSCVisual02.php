<!DOCTYPE html>
<html lang="en">

  <head>
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
</style>


<style>
table{
  width:100%;
  height:354px;
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



    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
    <script src="dashboard/html2pdf.bundle.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script src="dashboard/modernizr.js"></script>
<script type="text/javascript" id="MathJax-script" async
  src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js">
</script>
<script>
  $(window).on('load', function () {
 $(".se-pre-con").fadeOut("slow");
  });
</script>

    <title>1D Transient Dashboard</title>
    <link rel="shortcut icon" href="cv.png" />



    <link
      rel="stylesheet"
      href="dashboard/bootstrap.min.css"
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

  </head>

  <body>
<div id="loading" class="se-pre-con"></div>

    <div id="wrapper" style="background-color: #eff4f7;">
      <div class="content-area">
        <div class="container-fluid">
          <div class="text-right mt-3 mb-3 d-fixed">
            <div class="header">
              <h1 contenteditable="true">1D Transient Dashboard</h1>
            </div>
            <br>
            <button href="#" class="btn btn-primary"  >
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <a href="#" id="xx" style="color:white;">Export as CSV</a>
            </button>

            <button class="btn btn-primary" id="fusionexport-btn" onClick="downloadPDF2()">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <span class="btn-text">Download as PDF</span>
            </button>


          </div>
          <div class="main">


            <div class="row mt-5 mb-4">
              <div class="col-md-6">
                <div class="box">
<p style="font-size:20px;color:black;font-family:Arial, Helvetica, sans-serif;padding-left:20px;"><b>Summary Table</b> </p>
                  <div id="table_of_transients"></div>
                  <div id="hidden_table" style="display: none;"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="box">
                  <div id="chart"></div>
                </div>
              </div>
            </div>
            <div class="row sparkboxes mt-4 mb-4">
              <div class="col-md-4">
                <div class="box box1">
                  <div id="spark1"> <div class="notepad">
                      <div class="paper" contenteditable="true">
                       Write your notes here.
                      </div>
                    </div></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box box2">
                  <div id="spark2"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box box3">
                  <div id="spark3">

 </div>
                </div>
              </div>
            </div>

            <div class="row mt-4 mb-4">
              <div class="col-md-6">
                <div class="box">
                  <div id="area"></div>
                  <div class ="equation" id="equation2"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="box">
                  <div id="line"> </div>
                  <div class ="equation" id="equation"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <p class="footdash">Dashboard created by The Hashemi Lab, Imperial College London.</p>
    </div>



        <script src="dashboard/apexcharts.js"></script>
        <script src="dashboard/axios.min.js"></script>
        <script src="dashboard/scripts.js"></script>
        <script src="JavaScriptPackages/exportTabletoCSV.js"></script>

    </body>

<script>



    function arrayColumn(arr, n) {
      return arr.map(x=> x[n]);
    }
    function max(num){
    return Math.max.apply(null, num);
    }
    function min(num){
    return Math.min.apply(null, num);
    }
    var n_traces=DataArray[0].length-2;
    var data=[];
    var data2=[];
    var data3=[];
    var Array_of_Points=[];
    var Array_of_Peaks=[];
    var Array_average=[];
    var Array_of_AUC=[];
    var Array_of_ypeaks=[];
    var Array_of_xpeaks=[];
    var Array_std=[];
    var coln;
    var table_signals;
    var total_sum=0.0;
    var point;
    var average_point;
    var sign;
    const average = arr => arr.reduce( ( p, c ) => parseFloat(p) + parseFloat(c), 0 ) / arr.length;

    var tracen;
    var trace_peak;
    var col_average=[];
    var average_of_signals;
    var content_API;
    var standard_dev;
    var Area_curve;
    var xlabel=decodeURI(DataArray[1][DataArray[0].length-2]);
    var ylabel=decodeURI(DataArray[1][DataArray[0].length-1]);
    var yunit=ylabel.split(" ")[1];
    var xunit=xlabel.split(" ")[1];
    var ytype=ylabel.split(" ")[0];
    var variance;
    var col_std=[];
    var col_var=[];
     var Array_of_Thalf=[];

    var colors_of_signals=  ['#2E93fA','#2E93fA', '#66DA26','#66DA26', '#FFA500', '#FFA500','#E91E63', '#E91E63', '#9900ff', '#9900ff','#009933','#009933','#990000','#990000', '#33FFF3', '#33FFF3','#EBFB28','#EBFB28', '#FB28D8','#FB28D8', '#FB288B', '#FB288B'];
    var std_point;
    var pval;
    var pval2;
    var x_point;
    var T_half;
    var decay_x;
    var param1_fit;
    var param2_fit;
    var std1_fit;
    var std2_fit;
    var std_thalf;
    var seoe;
    var r2;
    var sum_of_average=0.0;
    var col1=arrayColumn(DataArray,0);
    var n_points=col1.length-1;
    var table_entry;
    var table_text= '\
    <table class ="table-hover" style="width:100%">\
      <tr>\
        <th>Signal</th>\
        <th>AUC (0-inf) '+yunit+'·'+xunit+'</th>\
        <th>Max '+yunit+'</th>\
        <th>Max '+xunit+'</th>\
        <th>t½ '+xunit+'</th>\
        <th style="display:none;">StDev(T½) </th>\
        <th style="display:none;">C0 </th>\
        <th style="display:none;">K </th>\
        <th style="display:none;">StDev(C0) </th>\
        <th style="display:none;">StDev(K) </th>\
        <th style="display:none;">p-value(C0) </th>\
        <th style="display:none;">p-value(K) </th>\
        <th style="display:none;">R^2 score</th>\
        <th style="display:none;">SEE</th>\
      </tr>';

    for (i = 1; i < n_traces; i++) {
    coln=arrayColumn(DataArray,i);
        for (j = 1; j < n_points+1; j++) {
        total_sum += parseFloat(coln[j]);
        point=[parseFloat(col1[j]),parseFloat(coln[j])];
        Array_of_Points.push(point);
        if (i==n_traces-1) {
          average_of_signals=average(DataArray[j].slice(1, n_traces));
          standard_dev=parseFloat(std(DataArray[j].slice(1, n_traces)).toFixed(2));
          variance=standard_dev*standard_dev;
          col_average.push(average_of_signals);
          col_std.push(standard_dev);
          col_var.push(variance);
          average_point=[parseFloat(col1[j]),average_of_signals];
          std_point=[parseFloat(col1[j]),standard_dev];
          sum_of_average+=average_of_signals;
          Array_average.push(average_point);
          Array_std.push(std_point);
        }

      };
      API_peaks(coln, col1, total_sum, Array_of_Points);
      total_sum = 0.0;
    tracen =  {
          name: coln[0],
          type: 'area',
          data: Array_of_Points
        };
    trace_peak={
      name: 'Peaks of '.concat(coln[0]),
       type: 'scatter',
      data: [Array_of_Peaks[0]]
    };
    //Exponential fit function

    data=data.concat(tracen);
    data=data.concat(trace_peak);

    Array_of_AUC.push(Area_curve);
    Array_of_Thalf.push(T_half);
    table_entry='\
    <tr>\
      <td>'+coln[0]+' <span style="color: '+colors_of_signals[2*(i-1)]+'">⬤</span></td>\
      <td>'+Area_curve.toFixed(2)+'</td>\
      <td>'+String(Array_of_Peaks[0][1])+'</td>\
      <td>'+String(Array_of_Peaks[0][0])+'</td>\
      <td>'+T_half.toFixed(2)+'</td>\
      <td style="display:none;">'+String(content_API[11])+'</td>\
      <td style="display:none;">'+String(content_API[2])+'</td>\
      <td style="display:none;">'+String(content_API[3])+'</td>\
      <td style="display:none;">'+String(content_API[9])+'</td>\
      <td style="display:none;">'+String(content_API[10])+'</td>\
      <td style="display:none;">'+String(content_API[5])+'</td>\
      <td style="display:none;">'+String(content_API[6])+'</td>\
      <td style="display:none;">'+String(content_API[4])+'</td>\
      <td style="display:none;">'+String(content_API[12])+'</td>\
    </tr>';
    table_text +=table_entry;
    Array_of_Points=[];
    Array_of_Peaks=[];
    };
    // Std of the measurements
     var std_area=std(Array_of_AUC);
     var std_max=std(Array_of_ypeaks);
     var std_maxt=std(Array_of_xpeaks);
     var std_t=std(Array_of_Thalf);
     // Mean of the measurements
      var mean_area=average(Array_of_AUC);
      var mean_max=average(Array_of_ypeaks);
      var mean_maxt=average(Array_of_xpeaks);
      var mean_t=average(Array_of_Thalf);
    //Average: individual iteration
    tracen={
      name: 'Average',
       type: 'area',
      data: Array_average
    };
    data=data.concat(tracen);


    API_peaks(col_average,col1,sum_of_average, Array_of_Points);
    trace_peak={
      name: 'Peaks of average',
       type: 'scatter',
      data: [Array_of_Peaks[0]]
    };
    data=data.concat(trace_peak);

    table_entry='\
    <tr>\
      <td>Avg. trace <span style="color: '+colors_of_signals[2*(i-1)]+'">⬤</span></td>\
      <td>'+Area_curve.toFixed(2)+'</td>\
      <td>'+String(Array_of_Peaks[0][1])+'</td>\
      <td>'+String(Array_of_Peaks[0][0])+'</td>\
      <td>'+T_half.toFixed(2)+'</td>\
      <td style="display:none;">'+String(content_API[11])+'</td>\
      <td style="display:none;">'+String(content_API[2])+'</td>\
      <td style="display:none;">'+String(content_API[3])+'</td>\
      <td style="display:none;">'+String(content_API[9])+'</td>\
      <td style="display:none;">'+String(content_API[10])+'</td>\
      <td style="display:none;">'+String(content_API[5])+'</td>\
      <td style="display:none;">'+String(content_API[6])+'</td>\
      <td style="display:none;">'+String(content_API[4])+'</td>\
      <td style="display:none;">'+String(content_API[12])+'</td>\
    </tr>';
    table_text +=table_entry;
    //Now the average of the PARAMETERS
    table_entry='\
    <tr>\
      <td>Average</td>\
      <td>'+mean_area.toFixed(2)+'</td>\
      <td>'+mean_max.toFixed(2)+'</td>\
      <td>'+mean_maxt.toFixed(2)+'</td>\
      <td>'+mean_t.toFixed(2)+'</td>\
      <td style="display:none;"> </td>\
      <td style="display:none;"> </td>\
      <td style="display:none;"> </td>\
      <td style="display:none;"> </td>\
      <td style="display:none;"> </td>\
      <td style="display:none;"> </td>\
      <td style="display:none;"> </td>\
      <td style="display:none;"> </td>\
      <td style="display:none;"> </td>\
    </tr>';
    table_text +=table_entry;



    table_entry='\
    <tr>\
    <td>StDev</td>\
    <td>'+std_area.toFixed(2)+'</td>\
    <td>'+std_max.toFixed(2)+'</td>\
    <td>'+std_maxt.toFixed(2)+'</td>\
    <td>'+std_t.toFixed(2)+'</td>\
    <td style="display:none;"> </td>\
    <td style="display:none;"> </td>\
    <td style="display:none;"> </td>\
    <td style="display:none;"> </td>\
    <td style="display:none;"> </td>\
    <td style="display:none;"> </td>\
    <td style="display:none;"> </td>\
    <td style="display:none;"> </td>\
    <td style="display:none;"> </td>\
    </tr>';
    table_text +=table_entry;
    table_text2=table_text;


    table_text+='\
    </table>';
    document.getElementById('table_of_transients').innerHTML = table_text;
    table_entry='\
    <tr style="visibility:collapse">\
      <td style="display:none; height: 0;">-</td>\
      <td style="display:none; height: 0;">-</td>\
      <td style="display:none; height: 0;">-</td>\
      <td style="display:none; height: 0;">-</td>\
      <td style="display:none; height: 0;">-</td>\
      <td style="display:none;height: 0;">-</td>\
      <td style="display:none;height: 0;">-</td>\
      <td style="display:none;height: 0;">-</td>\
      <td style="display:none;height: 0;">-</td>\
      <td style="display:none;height: 0;">-</td>\
      <td style="display:none;height: 0;">-</td>\
      <td style="display:none;height: 0;">-</td>\
      <td style="display:none;height: 0;">-</td>\
      <td style="display:none;height: 0;">-</td>\
    </tr>';
    table_text2+=table_entry;
    table_entry='\
    <tr style="visibility:collapse">\
      <td style="display:none; height: 0;">'+xlabel+'</td>\
      <td style="display:none; height: 0;"> Average</td>\
      <td style="display:none; height: 0;">StDev</td>\
      <td style="display:none; height: 0;">Gradient</td>\
      <td style="display:none; height: 0;">Michaelis Menten Model</td>\
      <td style="display:none;height: 0;"></td>\
      <td style="display:none; height: 0;">Alpha</td>\
      <td style="display:none;height: 0;">Vmax</td>\
      <td style="display:none;height: 0;">Km</td>\
      <td style="display:none;height: 0;">Beta</td>\
      <td style="display:none;height: 0;">Vmax2</td>\
      <td style="display:none;height: 0;">Km2</td>\
      <td style="display:none;height: 0;"></td>\
      <td style="display:none;height: 0;"></td>\
    </tr>';
    table_text2+=table_entry;


    //Mean variance and mean std
    var mean_variance=average(col_var);
    var mean_std=(Math.sqrt(mean_variance)).toFixed(2);

    //Gradient of the mean trace
    var signal_average=col_average.join('+');
    var signal_time=col1.slice(1,col1.length).join('+');

    var content_API2;
    var col_model;
    var Array_of_Gradient=[];
    var Array_of_model=[];
    var col_gradient;
    var trace_model;
    var gradient_y;
    var min_grad=0;
    var max_grad=0;
    var prev_grad_y;
    var gradient_point;
    var model_point;
    var alpha;
    var alpha_u;
    var Vmax;
    var Km;
    var Km_u;
    var alpha2;
    var Vmax2;
    var Vmax2_u;
    var Km2;
    var Km2_u;


    function API_gradient(){
    var API_dir2="https://py-dot-neurodatalab.nw.r.appspot.com/gradient?signal="+signal_average+"&col1="+signal_time+"&sign="+sign+"&peak="+String(x_points[0]);
    var settings_API2 = {
     async: false,
     crossDomain: true,
     contentType: "text/plain",
     xhrFields: {withCredentials: true},
     url: API_dir2,
     timeout: 50000,
     type: "GET"
    };

    $.ajax(settings_API2).done(function (response_API) {
     content_API2 = response_API.split("&");
     col_gradient = content_API2[0].split(" ");
     col_model=content_API2[1].split(" ");
     alpha=parseFloat(content_API2[2]);
     alpha_u=parseFloat(content_API2[3]);
     Vmax=parseFloat(content_API2[4]);
     Vmax_u=parseFloat(content_API2[5]);
     Km=parseFloat(content_API2[6]);
     Km_u=parseFloat(content_API2[7]);
     alpha2=parseFloat(content_API2[8]);
     alpha2_u=parseFloat(content_API2[9]);
     Vmax2=parseFloat(content_API2[10]);
     Vmax2_u=parseFloat(content_API2[11]);
     Km2=parseFloat(content_API2[12]);
     Km2_u=parseFloat(content_API2[13]);
    });
  };
  API_gradient();


    for (j = 1; j < n_points+1; j++) {
    prev_grad_y=parseFloat(col_gradient[j-1]);
    gradient_y=parseFloat(col_gradient[j]);
    gradient_y = gradient_y || prev_grad_y;
    if (gradient_y<min_grad) {min_grad=gradient_y};
    if (gradient_y>max_grad) {max_grad=gradient_y};
    gradient_point=[parseFloat(col1[j]),parseFloat(gradient_y.toFixed(3))];
    model_point=[parseFloat(col1[j]),parseFloat(col_model[j-1])];
    Array_of_Gradient.push(gradient_point);
    Array_of_model.push(model_point);
    //ENTRIES OF TABLE
    if (j==1){
      table_signals='\
      <tr style="visibility:collapse">\
        <td style="display:none; height: 0;">'+String(col1[j])+'</td>\
       <td style="display:none; height: 0;">'+String(col_average[j-1])+'</td>\
       <td style="display:none; height: 0;">'+String(col_std[j-1])+'</td>\
       <td style="display:none; height: 0;">'+String(gradient_y)+'</td>\
       <td style="display:none; height: 0;">'+String(Array_of_model[j-1][1])+'</td>\
       <td style="display:none;height: 0;">Mean:</td>\
       <td style="display:none;height: 0;">'+String(alpha)+'</td>\
       <td style="display:none;height: 0;">'+String(Vmax)+'</td>\
       <td style="display:none;height: 0;">'+String(Km)+'</td>\
       <td style="display:none;height: 0;">'+String(alpha2)+'</td>\
       <td style="display:none;height: 0;">'+String(Vmax2)+'</td>\
       <td style="display:none;height: 0;">'+String(Km2)+'</td>\
       <td style="display:none;height: 0;"></td>\
      </tr>';
    }
    else if (j==2){
      table_signals='\
      <tr style="visibility:collapse">\
        <td style="display:none; height: 0;">'+String(col1[j])+'</td>\
       <td style="display:none; height: 0;">'+String(col_average[j-1])+'</td>\
       <td style="display:none; height: 0;">'+String(col_std[j-1])+'</td>\
       <td style="display:none; height: 0;">'+String(gradient_y)+'</td>\
       <td style="display:none; height: 0;">'+String(Array_of_model[j-1][1])+'</td>\
       <td style="display:none;height: 0;">StDev:</td>\
       <td style="display:none;height: 0;">'+String(alpha_u)+'</td>\
       <td style="display:none;height: 0;">'+String(Vmax_u)+'</td>\
       <td style="display:none;height: 0;">'+String(Km_u)+'</td>\
       <td style="display:none;height: 0;">'+String(alpha2_u)+'</td>\
       <td style="display:none;height: 0;">'+String(Vmax2_u)+'</td>\
       <td style="display:none;height: 0;">'+String(Km2_u)+'</td>\
       <td style="display:none;height: 0;"></td>\
      </tr>';

    }
    else {
    table_signals='\
    <tr style="visibility:collapse">\
      <td style="display:none; height: 0;">'+String(col1[j])+'</td>\
     <td style="display:none; height: 0;">'+String(col_average[j-1])+'</td>\
     <td style="display:none; height: 0;">'+String(col_std[j-1])+'</td>\
     <td style="display:none; height: 0;">'+String(gradient_y)+'</td>\
     <td style="display:none; height: 0;">'+String(Array_of_model[j-1][1])+'</td>\
     <td style="display:none;height: 0;"></td>\
     <td style="display:none;height: 0;"></td>\
     <td style="display:none;height: 0;"></td>\
     <td style="display:none;height: 0;"></td>\
     <td style="display:none;height: 0;"></td>\
     <td style="display:none;height: 0;"></td>\
     <td style="display:none;height: 0;"></td>\
     <td style="display:none;height: 0;"></td>\
    </tr>';
    }
    table_text2+=table_signals;
    };
    document.getElementById('hidden_table').innerHTML = table_text2;


    //Function for API call to get the peaks and area.
    function API_peaks(coln, col1, total_sum, Array_of_Points) {

    var signal;
    var signal_array=arrayColumn(Array_of_Points,1);
    var max_signal;
    var min_signal;
    var API_dir;
    var period;
    var maxpoint;
    var settings_API;


    var k;
    signal=coln.slice(1, coln.length+1).join('+');
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
     seoe=parseFloat(content_API[12]).toFixed(2);




      maxpoint=[parseFloat(parseFloat(col1[parseInt(x_points[0])]).toFixed(2)), parseFloat(parseFloat(coln[parseInt(x_points[0])]).toFixed(2))];
      Array_of_Peaks.push(maxpoint);}
      Array_of_ypeaks.push(maxpoint[1]);
      Array_of_xpeaks.push(maxpoint[0]);


    });
    };

    //std
    function std(values){
    var avg = average(values);
    var n=values.length;
    var squareDiffs = values.map(function(value){
    var diff = parseFloat(value) - avg;
    var sqrDiff = diff * diff;
    return sqrDiff;
    });
    var sum = squareDiffs.reduce(function(a, b){
          return a + b;
      }, 0);
    if (n==1){var avgSquareDiff=0}
    else {  var avgSquareDiff = sum/(n-1);};
    var stdDev = Math.sqrt(avgSquareDiff);
    return stdDev;
    };






    //Plot configuration
    var options = {
      chart: {
        height: 385,
        width: "100%",
        type: "area"

      },
      tooltip: {
      enabled: true,
      followCursor: true,
       x: {
         show: true,
         formatter: function(value) {
      return value.toFixed(2)+' '+xunit
    },
     },
     y: {
       show: true,
       formatter: function(value) {
    return value.toFixed(2)+' '+yunit
    },
    }},
      dataLabels: {
              enabled: false
            },
      series: data,
      colors: ['#2E93fA','#2E93fA', '#66DA26','#66DA26', '#FFA500', '#FFA500','#E91E63', '#E91E63', '#9900ff', '#9900ff','#009933','#009933','#990000','#990000', '#33FFF3', '#33FFF3','#EBFB28','#EBFB28', '#FB28D8','#FB28D8', '#FB288B', '#FB288B'],
      title: {
    text: '1D Trasients',
    align: 'left',
    margin: 10,
    offsetX: 0,
    offsetY: 0,
    floating: false,
    style: {
      fontSize:  '20px',
      fontWeight:  'bold',
    }
    },
      xaxis: {
         type: 'numeric',
          title: {
              text: xlabel
      }},
       yaxis: {
          decimalsInFloat: 1,
          title: {
              text: ylabel
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

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();


        var spark1 = {
          chart: {
            toolbar: {
        offsetX: -15,
        offsetY: 0,
       show: true,
       tools: {
         download: true,
         selection: true,
         zoom: true,
         zoomin: true,
         zoomout: true,
         pan: true,
         reset: true
       },
       autoSelected: 'zoom'
     },
            id: 'sparklinne3',

            type: 'line',
            height: 180,
            sparkline: {
              enabled: true
            },
          },
          tooltip: {
          enabled: true,
          followCursor: true,
           x: {
             show: true,
             formatter: function(value) {
          return value.toFixed(2)+' '+xunit
        },
         },
         y: {
           show: true,
           formatter: function(value) {
        return value.toFixed(2)+' d'+yunit+'/d'+xunit
      },
    }},
          stroke: {
            curve: 'smooth'
          },
          fill: {
            opacity: 1,
          },
          series: [{
            name: 'Gradient',
            data: Array_of_Gradient
          }],
          xaxis: {
             type: 'numeric',
              title: {
                  text: xlabel
          }},
          yaxis: {
            min: min_grad-0.1,
            title: {
                text: ylabel
        },
    },
    colors:['#008FFB'],
          title: {
            text:'Gradient (df[t])/dt)',
            offsetX: 30,
            style: {
              fontSize: '14px',
              cssClass: 'apexcharts-yaxis-title'
            }
          },
          subtitle: {
            text: xlabel+' →',
            offsetX: 230,
              offsetY: 160,
            style: {
              fontSize: '12px',
               fontWeight:  'bold',
              cssClass: 'apexcharts-yaxis-title'
            }
          }
        }
    new ApexCharts(document.querySelector("#spark2"), spark1).render();


    var spark2 = {
      chart: {
        toolbar: {
    offsetX: -15,
    offsetY: 0,
    show: true,
    tools: {
     download: true,
     selection: true,
     zoom: true,
     zoomin: true,
     zoomout: true,
     pan: true,
     reset: true
    },
    autoSelected: 'zoom'
    },
        id: 'sparkline3',
        group: 'sparklines',
        type: 'area',
        height: 180,
        sparkline: {
          enabled: true
        },
      },
      tooltip: {
      enabled: true,
      followCursor: true,
       x: {
         show: true,
         formatter: function(value) {
      return value.toFixed(2)+' '+xunit
    },
     },
     y: {
       show: true,
       formatter: function(value) {
    return value.toFixed(2)+' '+yunit
    },
    }},
      stroke: {
        curve: 'smooth'
      },
      fill: {
        opacity: 1,
      },
      series: [{
        name: 'std',
        data: Array_std
      }],
      xaxis: {
         type: 'numeric',
          title: {
              text: xlabel
      }},
      yaxis: {
        min: 0,
        title: {
            text: ylabel
    }},
      colors: ['#008FFB'],
      //colors: ['#5564BE'],
      title: {
        text:' StDev '+yunit+': '+mean_std,
        offsetX: 30,
        style: {
          fontSize: '14px',
          cssClass: 'apexcharts-yaxis-title'
        }
      },
       subtitle: {
          text: xlabel+' →',
          offsetX: 230,
            offsetY: 160,
          style: {
            fontSize: '12px',
             fontWeight:  'bold',
            cssClass: 'apexcharts-yaxis-title'
          }
        }
    }
    new ApexCharts(document.querySelector("#spark3"), spark2).render();
    //EXPONENTIAL FIT
    tracen={
      name: 'Average',
       type: 'line',
      data: Array_average
    };
    data2=data2.concat(tracen);
    data3=data3.concat(tracen);
    var Array_of_Fit=[];
    var fit_y;
    var trace_fit;
    var fit_point;
    var decay_points=decay_x.length;
    for(var p=0;p<decay_points;p++){
    fit_y = parseFloat(param1_fit)*Math.exp(parseFloat(param2_fit)*parseFloat(decay_x[p]));
    if (sign=="negative") {fit_y=-fit_y};
    fit_point=[parseFloat(decay_x[p]),fit_y];
    Array_of_Fit.push(fit_point);
    };
    trace_fit={
      name: 'Exponential fit',
       type: 'line',
      data: Array_of_Fit
    };
    data2=data2.concat(trace_fit);



    var options2 = {
      chart: {
        height: 300,
        width: "100%",
        type: "line"

      },
      tooltip: {
      enabled: true,
      followCursor: true,
       x: {
         show: true,
         formatter: function(value) {
      return value.toFixed(2)+' '+xunit
    },
     },
     y: {
       show: true,
       formatter: function(value) {
    return value.toFixed(2)+' '+yunit
    },
    }},
      dataLabels: {
              enabled: false
            },
      series: data2,
      colors:[colors_of_signals[2*(i-1)], '#000000'],
      title: {
    text: 'Exponential fit',
    align: 'left',
    margin: 10,
    offsetX: 0,
    offsetY: 0,
    floating: false,
    style: {
      fontSize:  '20px',
      fontWeight:  'bold',
    }
    },
      xaxis: {
         type: 'numeric',
          title: {
              text: xlabel
      }},
       yaxis: {
          decimalsInFloat: 1,
          title: {
              text: ylabel
      }},
      stroke: {
            width: [5, 3],
              curve: 'smooth',
              dashArray: [0, 8]
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

    var chartline = new ApexCharts(document.querySelector('#line'), options2);
    chartline.render();
    if (sign=="negative") {param1_fit=(-parseFloat(param1_fit)).toFixed(2)};
    var equation=String.raw`$$C(t) = C_{0} e^{-Kt} → `;
    equation+=String.raw`C(t) = `+param1_fit+'±'+std1_fit+'·e^{'+param2_fit+'±'+std2_fit+'t}';
    equation+=String.raw`$$`;
    //Calculation of apparent Vmax and Km
    if (sign=='positive'){var ap_vmax=-(min_grad)};
    if (sign=='negative'){var ap_vmax=max_grad};
    var ap_km=ap_vmax/(-parseFloat(param2_fit));
    equation+=String.raw`$$ t½ = ln(2)/K = `+T_half.toFixed(2)+'±'+std_thalf+String.raw` \ `+xunit;
    equation+=String.raw`$$`;
    equation+=String.raw`$$ Apparent\ Vmax = `+ap_vmax.toFixed(2)+String.raw`, \ K_{m} = `+ap_km.toFixed(2)+String.raw`$$`+ String.raw`$$ SEE = `+seoe+String.raw`\ `+yunit+String.raw`, \ R^{2} = `+r2+String.raw`\ (not\ recommended)$$`;


    document.getElementById('equation').innerHTML += equation;
    document.getElementById('equation').innerHTML += '<p style=" font-size: 12px; text-align: center;">Further parameters for each of the signals can be found in the exportable csv file. </p>';




    trace_model={
      name: 'MM model',
       type: 'line',
      data: Array_of_model
    };
    data3=data3.concat(trace_model);

        var options3 = {
          chart: {
            height: 300,
            width: "100%",
            type: "line"

          },
          tooltip: {
          enabled: true,
          followCursor: true,
           x: {
             show: true,
             formatter: function(value) {
          return value.toFixed(2)+' '+xunit
        },
         },
         y: {
           show: true,
           formatter: function(value) {
        return value.toFixed(2)+' '+yunit
      },
    }},
          dataLabels: {
                  enabled: false
                },
          series: data3,
          colors:[colors_of_signals[2*(i-1)], '#000000'],
          title: {
        text: 'Michaelis Menten Model',
        align: 'left',
        margin: 10,
        offsetX: 0,
        offsetY: 0,
        floating: false,
        style: {
          fontSize:  '20px',
          fontWeight:  'bold',
        }
    },
          xaxis: {
             type: 'numeric',
              title: {
                  text: xlabel
          }},
           yaxis: {
              decimalsInFloat: 1,
              title: {
                  text: ylabel
          }},
          stroke: {
                width: [5, 3],
                  curve: 'smooth',
                  dashArray: [0, 8]
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

     var chartline = new ApexCharts(document.querySelector('#area'), options3);
        chartline.render();
        var equation2=String.raw`$$ \frac{dC(t)}{dt} = R(t)(1-A(t))-\alpha\frac{V_{max}·C(t)}{K_{m}+C(t)} -\beta\frac{V_{max2}·C(t)}{K_{m2}+C(t)}`;
        equation2+=String.raw`$$`;
        equation2+=String.raw`$$ \alpha = `+alpha.toFixed(2)+'±'+alpha_u.toFixed(2)+String.raw`\quad \beta = `+alpha2.toFixed(2)+'±'+alpha2_u.toFixed(2)+String.raw` $$`;
        equation2+=String.raw`$$ V_{max} = `+Vmax.toFixed(2)+'±'+Vmax_u.toFixed(2)+String.raw` \ `+yunit+'/'+xunit;
        equation2+=String.raw`\quad K_{m} = `+Km.toFixed(2)+'±'+Km_u.toFixed(2)+String.raw` \ `+yunit +String.raw`$$`;
        equation2+=String.raw`$$ V_{max2} = `+Vmax2.toFixed(2)+'±'+Vmax2_u.toFixed(2)+String.raw` \ `+yunit+'/'+xunit;
        equation2+=String.raw`\quad K_{m2} = `+Km2.toFixed(2)+'±'+Km2_u.toFixed(2)+String.raw` \ `+yunit +String.raw`$$`;

        document.getElementById('equation2').innerHTML += equation2;







    function downloadPDF2(){
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




    </html>
