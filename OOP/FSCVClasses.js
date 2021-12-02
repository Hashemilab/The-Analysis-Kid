// Class for uploaded FSCV Data.
class HL_FSCV_DATA {
constructor(data, units, frequency, cycling_frequency, name_of_file, plot_type, color_palette){
this.frequency = frequency;
this.cycling_frequency = cycling_frequency;
this.name_of_file = name_of_file;
this.current = new HL_FSCV_ARRAY(data, units, 'Current');
this.cycling_time = new HL_FSCV_TIME(cycling_frequency, data[0].length, 's', 'Time');
this.time = new HL_FSCV_TIME(frequency, data.length, 's', 'Time');
this.snr = 0;
//Plotting properties.
this.plot_type = plot_type;
this.palettes = new HL_FSCV_COLORPALETTE();
if (color_palette == 'Custom'){color_palette = this.palettes.custom}
else if(color_palette =='Parula'){color_palette = this.palettes.parula};
this.color_palette = color_palette;
this.plot_settings = new HL_PLOT_SETTINGS();
this.plot_layout = this.plot_settings.plot_layout;
this.color_limits = [];
};

// Methods of the data.
graph_color_plot(div){
//Function to plot the main color plot.
var graph_data = [{
z:this.current.array,
x:this.cycling_time.array,
type:this.plot_type,
colorscale:this.color_palette,
colorbar: {len:0.5, xpad:30, title:this.current.name+' ('+this.current.units+')'},
zsmooth: false,
zmin:this.color_limits[0],
zmax:this.color_limits[1]
}];

this.plot_layout = this.plot_settings.plot_layout;
this.plot_layout.title.text = "<b>"+this.name_of_file+"</b>";
if (this.plot_type == 'surface'){
this.plot_layout.scene = {
xaxis:{
title: this.cycling_time.name+' ('+this.cycling_time.units+')',
gridcolor: 'rgb(255, 255, 255)',
zerolinecolor: 'rgb(255, 255, 255)',
showbackground: true,
showgrid:true,
backgroundcolor:'rgb(230, 230,230)',
},
yaxis: {
title: 'Samples',
gridcolor: 'rgb(255, 255, 255)',
zerolinecolor: 'rgb(255, 255, 255)',
showbackground: true,
showgrid:true,
backgroundcolor: 'rgb(230, 230, 230)',
},
zaxis: {
title: this.current.name+' ('+this.current.units+')',
gridcolor: 'rgb(255, 255, 255)',
zerolinecolor: 'rgb(255, 255, 255)',
showbackground: true,
showgrid:true,
backgroundcolor: 'rgb(230, 230,230)'
},
aspectratio: {x: 1, y: 1, z: 0.7},
aspectmode: 'manual'
};
} else {
this.plot_layout.xaxis = {
title:this.cycling_time.name+' ('+this.cycling_time.units+')'
};
this.plot_layout.yaxis = {
title:'Samples'
};
};
Plotly.newPlot(div, graph_data, this.plot_layout, this.plot_settings.plot_configuration);
_(div).on('plotly_click', function(data){main_graph_clicked(data)});
};

change_color_palette(new_color_palette, div){
if (new_color_palette == 'Custom'){this.color_palette = this.palettes.custom}
else if(new_color_palette =='IBM'){this.color_palette = this.palettes.ibm}
else if(new_color_palette =='Wong'){this.color_palette = this.palettes.wong}
else if(new_color_palette =='Parula'){this.color_palette = this.palettes.parula}
else {this.color_palette = new_color_palette;}
this.graph_color_plot(div);
};

change_type_of_plot(new_plot_type, div){
this.plot_type = new_plot_type;
this.graph_color_plot(div);
};

change_colorbar_limits(div, div_min, div_max, min, max, autoadjust){
if (autoadjust){
if (!isNaN(min) && isNaN(max)) {max = abs((3/2)*min)}
else {min = -(2/3)*max};
};
this.color_limits = [min, max];
//Write values to application.
_(div_min).value = this.color_limits[0].toFixed(2);
_(div_max).value = this.color_limits[1].toFixed(2);
this.graph_color_plot(div);
};

get_colorbar_range(div_min, div_max){
let tmp = index_of_max_and_min(flatten(this.current.array));
this.color_limits = [tmp[0], tmp[2]];
_(div_min).value = this.color_limits[0].toFixed(2);
_(div_max).value = this.color_limits[1].toFixed(2);
};

invert_current_values(div){
for(var i = 0;i<this.current.array.length;++i){for(var j = 0;j<this.current.array[i].length;++j){this.current.array[i][j] = - this.current.array[i][j]}};
this.graph_color_plot(div);
};
background_subtraction(div, start, end){
for (var i = 0; i<fscv_data.current.array.length;++i){
var avg = average(fscv_data.current.array[i].slice(start, end));
for (var j=0; j<fscv_data.current.array[0].length;++j){fscv_data.current.array[i][j] = fscv_data.current.array[i][j] - avg};
};
this.graph_color_plot(div);
};
get_snr(start_sample, end_sample, snr_id){
this.snr = 10*Math.log10(index_of_max(absolute_array(flatten(this.current.array)))[0]/std(flatten(transpose(this.current.array.slice(start_sample, end_sample)))));
_(snr_id).innerHTML = this.snr.toFixed(2)+' dB';
};

initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};

show_limits(div, y_start_point, y_end_point, x_start_point, x_end_point){
this.plot_layout.shapes = [
{
type: 'rect',
x0: x_start_point,
y0: y_start_point,
x1: x_end_point,
y1: y_end_point,
line: {
color: 'red',
width: 2
},
fillcolor: 'rgba(0, 0, 0, 0)'
}
];
Plotly.relayout(div, this.plot_layout);
// Empty the shapes for future plots.
this.plot_layout.shapes = [];
};


export_data(type, precision){
if(type === "xlsx"){this.export_data_xlsx()}
else{this.export_data_txt(precision)};
};

export_data_xlsx(){
let ws, wb = XLSX.utils.book_new();
ws = XLSX.utils.aoa_to_sheet(this.current.array);
XLSX.utils.book_append_sheet(wb, ws, 'Color plot');
XLSX.writeFile(wb, this.name_of_file+".xlsx");
};

export_data_txt(precision){
let text = '', i, j;
for(i=0; i<this.current.array.length;++i){
for(j=0; j<this.current.array[i].length;++j){
text+=this.current.array[i][j].toFixed(precision)+'\t';
};
text+='\n';
};
download_text(text, this.name_of_file);
};

};
class HL_FSCV_1D_DATA{
constructor(units, frequency, type){
//Data properties.
this.current = new HL_FSCV_ARRAY([], units, 'Current');
this.time = new HL_FSCV_ARRAY([], 's', 'Time');
this.legend_array = [];
this.origin_file_array = [];
this.type = type;
this.counter = 0;
//Plotting properties.
this.plot_settings = new HL_PLOT_SETTINGS();
this.palettes = new HL_FSCV_COLORPALETTE();
}
//Methods.
add_trace(array, frequency, div, origin_file){
this.current.array.push(array);
this.time.array.push(makeArr(0,(array.length-1)/frequency, array.length));
this.legend_array.push("("+String(this.counter+1)+")");
this.origin_file_array.push(origin_file);
this.plot_trace(this.type, div);
this.counter++;
};
remove_trace(div){
if (this.counter != 0){
this.current.array.pop();
this.time.array.pop();
this.legend_array.pop();
this.origin_file_array.pop();
this.delete_trace(div);
this.counter--;
};
};

plot_trace(type, div){
var layout = this.plot_settings.plot_layout;
layout.xaxis.title = this.time.name +" ("+this.time.units+")";
layout.yaxis.title = this.current.name +" ("+this.current.units+")";
layout.title.text = "<b>"+this.type+"</b>";
Plotly.relayout(div, layout);
Plotly.addTraces(div, [{y: this.current.array[this.counter], x:this.time.array[this.counter],
name:"("+String(this.counter+1)+")", text:this.origin_file_array[this.counter], line:{color: this.palettes.colors[this.counter%this.palettes.colors.length]}}]);
};

delete_trace(div){
Plotly.deleteTraces(div, -1);
}

initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};
};










//Class for injection traces.
class HL_FSCV_1D_DATA_INJECTION{
constructor(units, frequency, type){
//Data properties.
this.current = new HL_FSCV_ARRAY([], units, 'Current');
this.time = new HL_FSCV_ARRAY([], 's', 'Time');
this.type = type;
this.limits = [75, 200];
this.fit_parameters = [10, 1];
this.modelled_current = new HL_FSCV_ARRAY([], units, 'Current');
this.modelled_concentration = new HL_FSCV_ARRAY([], '', 'Concentration');
//Plotting properties.
this.plot_settings = new HL_PLOT_SETTINGS();
this.palettes = new HL_FSCV_COLORPALETTE();
}
//Methods.
add_trace(array, frequency, concentration, limits, div){
this.current.array = array;
this.time.array = makeArr(0,(array.length-1)/frequency, array.length);
this.limits = limits;
this.fit_model_to_extract(concentration);
this.plot_trace(this.type, div);
};

plot_trace(type, div){
var layout = this.plot_settings.plot_layout;
layout.xaxis.title = this.time.name +" ("+this.time.units+")";
layout.yaxis.title = this.current.name +" ("+this.current.units+")";
layout.title.text = "<b>"+this.type+"</b>";
layout.annotations = [{
xref: 'paper',
yref: 'paper',
x: 0.98,
xanchor: 'right',
y: 0.9,
yanchor: 'bottom',
text:'<b> RMSE : '+Math.sqrt(mse(this.current.array, this.modelled_current.array)).toFixed(2)+' '+this.current.units+'</b>',
showarrow: false
}];


var trace = {y: this.current.array, x:this.time.array, showlegend: false, text:'Injection'};

var max_point = {
y:[this.current.array[this.limits[0]]],
x:[this.time.array[this.limits[0]]],
type: 'scatter',
showlegend: false,
mode: 'markers',
marker: {color: 'black'},
text:'Max'
};

var min_point = {
y:[this.current.array[this.limits[1]]],
x:[this.time.array[this.limits[1]]],
type: 'scatter',
showlegend: false,
mode: 'markers',
marker: {color: 'black'},
text:'Min'
};


var extract = {
y:this.current.array.slice(this.limits[0],this.limits[1]),
x:this.time.array.slice(this.limits[0],this.limits[1]),
showlegend: false,
line: {color: 'black', width:2},
text:'Extract'
};

var fit = {
y:this.modelled_current.array,
x:this.time.array,
showlegend: false,
line: {color: 'red', width:1},
text:'Fit'
};

Plotly.newPlot(div, [trace], layout);
Plotly.addTraces(div, [max_point, min_point, extract, fit]);
};

change_extract_limits(first, last, concentration, div){
this.limits = [first, last];
this.fit_model_to_extract(concentration);
this.plot_trace(this.type, div);
};


fit_model_to_extract(concentration){
var self = this;
//First stimation of fit params.
this.fit_parameters[0] = index_of_max(this.current.array)[0];
var func = function([],P){return self.model_injection_current(self.limits, P)};
this.fit_parameters = fminsearch(func, this.fit_parameters, [], this.current.array, {maxIter:5000, step: [0.1, 0.1]});
this.modelled_current.array = this.model_injection_current(this.limits, this.fit_parameters);
this.modelled_concentration.array = this.modelled_current.array.map(z => concentration*z/this.fit_parameters[0]);
};

model_injection_current([start, end], [max_rect, A]){
let u = 0, c = uniform_array(this.current.array.length, 0);
for (let i=1; i<this.current.array.length; ++i){
if (i<start || i>end) {u = 0} else{u = max_rect};
c[i] = A*(u-c[i-1])+c[i-1];
};
return c
};


optimise_fitting(concentration, type, div){
this.fit_model_to_extract(concentration);
this.plot_trace(type, div);
};


initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};
};














// Class for concentration traces.
class HL_FSCV_CONCENTRATION {
constructor(units){
this.plot_settings = new HL_PLOT_SETTINGS();
this.palettes = new HL_FSCV_COLORPALETTE();
this.concentration = new HL_FSCV_ARRAY([], [], 'Concentration');
this.average_concentration = new HL_FSCV_ARRAY([], [], 'Average concentration');
this.std_concentration = new HL_FSCV_ARRAY([], [], 'STD concentration');
this.time = new HL_FSCV_ARRAY([], 's', 'Time');
this.absolute_concentration = new HL_FSCV_ARRAY([], [], 'Absolute concentration');
this.max_index = new HL_FSCV_ARRAY([], units, 'Max index values');
this.min_index = new HL_FSCV_ARRAY([], units, 'Min index values');
this.origin_file_array = [];
this.names = [];
this.regression_parameters = new HL_FSCV_ARRAY([], units, 'Regression parameters (a,b,r2,se_regression, se_slope, se_intercept)');
this.regression_line_concentration = new HL_FSCV_ARRAY([], units, 'Concentration');
this.regression_line_time = new HL_FSCV_ARRAY([], 's', 'Time');
this.area_under_curve = new HL_FSCV_ARRAY([], units+'·s', 'Area under the curve');
this.color_array = [];
this.type = 'c-t Curve';
this.counter = 0;
this.graph_index = 0;
this.plsr_model = null;
}

calibrate_trace(div, index, fscv_transient, frequency, coefficients, units, name, type){
this.graph_index = this.counter++;
var array;
if (type == 'linear_fit'){array = fscv_transient.current.array[index-1].map(x => coefficients[0]+coefficients[1]*x)}
else {array = fscv_transient.current.array[index-1].map(x => coefficients[0]+coefficients[1]*x+coefficients[2]*x*x)};
this.add_concentration_to_array(div, array, frequency, fscv_transient.origin_file_array[index-1], this.palettes.colors[(index-1)%this.palettes.colors.length], name, units);
};

calibrate_trace_plsr(div, fscv_data, prediction_output_number, frequency, units, name){
this.graph_index = this.counter++;
let plsr_x = new ML.Matrix(transpose(fscv_data.current.array));
let array = this.plsr_model.predict(plsr_x).data.map(x=>x[prediction_output_number]);
this.add_concentration_to_array(div, array, frequency, fscv_data.name_of_file, this.palettes.colors[this.counter%this.palettes.colors.length], name, units);
};
load_plsr_json(json_object, status){
this.plsr_model = new ML.PLS(true, json_object);
_(status).innerHTML = 'Loaded successfully.';
};

// EXPERIMENTAL METHODS FOR KINETIC CALIBRATION.
kinetic_calibrate_trace(div, fscv_data, frequency, cycling_frequency, integration_start, integration_end, units, name,
diffusion_coefficient, absorption_strength, electrode_surface, valency){
this.graph_index = this.counter++;
var cvs = transpose(fscv_data.current.array), area, concentration_surface_array = [], electrode_response_array = [];
var F_constant = 26.801*(10**(9))*3600; //nA·s/mol
//Experimental model obtained for DA : dx.doi.org/10.1021/cn500020s|ACS  Chem.  Neurosci.2015, 6, 1509−1516
var tau = 601.2*(1/(diffusion_coefficient*10**(6)))*absorption_strength-0.065;
var a0 = absorption_strength*((1/cycling_frequency)/tau);
for (var i = 0; i<cvs.length;++i){
area = simpson_auc(cvs[i].slice(integration_start, integration_end), frequency); //With units nA*s = nNF if input is nA.
concentration_surface_array[i] = (area/(valency*F_constant*electrode_surface))*10**10; // Units mol/dm^2.
electrode_response_array[i] = a0*Math.exp(-(fscv_data.cycling_time.array[i])/tau);
};
//Implementation of deconvolution.
const cs_fft_array = tf.tensor1d(concentration_surface_array).rfft().dataSync();
const er_fft_array = tf.tensor1d(electrode_response_array).rfft().dataSync();
var cs_fft_real_array = get_even_indexes(cs_fft_array), cs_fft_im_array = get_odd_indexes(cs_fft_array),
er_fft_real_array = get_even_indexes(er_fft_array), er_fft_im_array = get_odd_indexes(er_fft_array),
con_fft_real_array=[], con_fft_im_array=[];
for (i=0;i<cs_fft_real_array.length;++i){
let cs_fft_complex = new Complex(cs_fft_real_array[i], cs_fft_im_array[i]);
let er_fft_complex = new Complex (er_fft_real_array[i], er_fft_im_array[i]);
let con_fft_complex = complex_num_divide(cs_fft_complex, er_fft_complex);
con_fft_real_array[i] = con_fft_complex.real;
con_fft_im_array[i] = con_fft_complex.imaginary;
};
var con_array = tf.complex(tf.tensor1d(con_fft_real_array), tf.tensor1d(con_fft_im_array)).irfft().dataSync(); //in mol/dm^3 => M.
con_array = scalar_product(con_array, 10**9); //in nM.
this.add_concentration_to_array(div, con_array, cycling_frequency, fscv_data.name_of_file, '#1f77b4', name, 'nM');
};

add_concentration_to_array(div, array, frequency, origin_file, color, name, units){
this.concentration.array.push(array);
this.time.array.push(makeArr(0,(array.length-1)/frequency, array.length));
this.origin_file_array.push(origin_file);
this.names.push(name);
this.color_array.push(color);
this.concentration.units.push(units);
this.get_max_and_min_values(this.counter-1);
this.get_linearised_exponential_fit(this.counter-1);
this.get_area_under_curve(this.counter-1, frequency);
this.plot_graph(div);
};

plot_graph(div){
var layout = this.plot_settings.plot_layout;
layout.xaxis.title = this.time.name +" ("+this.time.units+")";
layout.yaxis.title = this.concentration.name +" ("+this.concentration.units[this.graph_index]+")";
layout.title.text = "<b>"+this.names[this.graph_index]+' ('+String(this.graph_index+1)+")</b>";
layout.annotations = [{
xref: 'paper',
yref: 'paper',
x: 0.98,
xanchor: 'right',
y: 0.9,
yanchor: 'bottom',
text: '<b>R<sup>2</sup> : '+this.regression_parameters.array[this.graph_index][6].toFixed(2)+
'<br> SEE : '+this.regression_parameters.array[this.graph_index][7].toFixed(2)+' '+this.concentration.units[this.graph_index]+
'<br> t <sub>1/2</sub> : '+ this.regression_parameters.array[this.graph_index][4].toFixed(2)+' '+this.time.units+'</b>',
showarrow: false
}];

var trace = {
y: this.concentration.array[this.graph_index],
x:this.time.array[this.graph_index],
text:this.origin_file_array[this.graph_index],
showlegend: false,
line:{color: this.color_array[this.graph_index]},
};

var max_point = {
y:[this.concentration.array[this.graph_index][this.max_index.array[this.graph_index]]],
x:[this.time.array[this.graph_index][this.max_index.array[this.graph_index]]],
type: 'scatter',
showlegend: false,
mode: 'markers',
marker: {color: 'black'},
text:'Max'
};

var min_point = {
y:[this.concentration.array[this.graph_index][this.min_index.array[this.graph_index]]],
x:[this.time.array[this.graph_index][this.min_index.array[this.graph_index]]],
type: 'scatter',
showlegend: false,
mode: 'markers',
marker: {color: 'black'},
text:'Min'
};

var exp_decay = {
y:this.regression_line_concentration.array[this.graph_index],
x: this.regression_line_time.array[this.graph_index],
showlegend: false,
line: {color: 'black', width:0.5, dash: 'dot'},
text:'Fit'
}

Plotly.newPlot(div, [trace], layout);
Plotly.addTraces(div, [max_point, min_point, exp_decay]);
_(div).on('plotly_click', function(data){concentration_graph_clicked(data)});
};

remove_trace(div){
if (this.counter != 0){
this.switch_plot(div);
this.concentration.array.pop();
this.time.array.pop();
this.absolute_concentration.array.pop();
this.max_index.array.pop();
this.min_index.array.pop();
this.regression_parameters.array.pop();
this.regression_line_concentration.array.pop();
this.regression_line_time.array.pop();
this.area_under_curve.array.pop();
this.origin_file_array.pop();
this.names.pop();
this.color_array.pop();
--this.counter;
}
};

switch_plot(div){
if (this.graph_index == this.counter-1){
if (this.graph_index == 0){this.initialise_graph(div)}
else {--this.graph_index; this.plot_graph(div)}};
};
initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};

get_max_and_min_values(index){
var abs_array = absolute_array(this.concentration.array[index]);
var max = index_of_max(abs_array);
var min = index_of_min(abs_array.slice(max[1], abs_array.length-1));
this.absolute_concentration.array.push(abs_array);
this.max_index.array.push(max[1]);
this.min_index.array.push(max[1] + min[1]);
};

change_max_and_min_values(div, pindex, type, frequency){
if (type == 'max'){this.max_index.array[this.graph_index] = pindex}
else{this.min_index.array[this.graph_index] = pindex};
this.get_linearised_exponential_fit(this.graph_index);
this.get_area_under_curve(this.graph_index, frequency);
this.plot_graph(div);
};

calculate_average_trace(){
// Assumption that all concentrations are the same as the first added one and that length of arrays are the same.
var transposed_concentration_array = transpose(this.concentration.array);
this.average_concentration.units = this.concentration.units[0];
this.average_concentration.array = transposed_concentration_array.map(x => average(x));
// Std of traces.
this.std_concentration.units = this.average_concentration.units;
this.std_concentration.array = transposed_concentration_array.map(x => std(x));
};


get_linearised_exponential_fit(index){
var y = this.absolute_concentration.array[index].slice(this.max_index.array[index], this.min_index.array[index]);
var x = this.time.array[0].slice(this.max_index.array[index], this.min_index.array[index]);
var linear_reg = linear_fit(x,log_of_array(y)), c0 = Math.exp(linear_reg[0]), k = linear_reg[1];
this.change_fitted_parameters(index, c0, k, x, y);
};

get_nonlinear_exponential_fit(){
var y = this.absolute_concentration.array[this.graph_index].slice(this.max_index.array[this.graph_index], this.min_index.array[this.graph_index]);
var x = this.time.array[0].slice(this.max_index.array[this.graph_index], this.min_index.array[this.graph_index]);
var c0 = this.regression_parameters.array[this.graph_index][2];
var k = this.regression_parameters.array[this.graph_index][0];
var exp_fun = (arr, P) => arr.map(t => P[0]*Math.exp(P[1]*t));
var opt_params = fminsearch(exp_fun, [c0, k], x, y, {maxIter:5000, step: [0.1, 0.1]});
this.change_fitted_parameters(this.graph_index, opt_params[0], opt_params[1], x, y);
};

change_fitted_parameters(index, c0, k, x, y){
var y_pred = x.map(x => c0*Math.exp(k*x));
var par_err = hess_exp_errors(c0, k, x, y);
var fit_err = estimation_errors(y_pred, y);
var t_half = Math.log(2)/Math.abs(k);
//Propagation of error of t1/2 = ln(2)/K.
var se_t_half = Math.sqrt(Math.pow(Math.log(2)/Math.pow(k, 2), 2)*Math.pow(par_err[1], 2));
this.regression_line_time.array[index] = x;
// Store the exponential trace.
this.regression_line_concentration.array[index] = y_pred;
// Store exponential parameters and exponential errors (propagation of uncertainty and recalculation):
//K, se(K), C0, se(C0), t 1/2, se (t 1/2), r^2 and SEE.
this.regression_parameters.array[index] = [k, par_err[1], c0, par_err[0], t_half, se_t_half, fit_err[1], fit_err[0]];
// Invert sign of trace if the signal is an inhibition for plotting purposes.
if(this.concentration.array[index][this.max_index.array[index]] < 0){
this.regression_line_concentration.array[index] = scalar_product(this.regression_line_concentration.array[index], -1);
};
};

get_area_under_curve(index, frequency){
// AUC calculated from t=0s to minimum.
this.area_under_curve.array[index] = simpson_auc(this.concentration.array[index].slice(0, this.min_index.array[index]), frequency);
};

export_calibration(){
// Export of average and STD.
this.calculate_average_trace();
var ws_name = "Average and STD";
var aoa = transpose([this.time.array[0], this.average_concentration.array, this.std_concentration.array]);
aoa.unshift([this.time.name, this.average_concentration.name, this.std_concentration.name]);
var wb = XLSX.utils.book_new(), ws = XLSX.utils.aoa_to_sheet(aoa);
XLSX.utils.book_append_sheet(wb, ws, ws_name);
// Export of concentration traces.
ws_name = "Concentration - Time";
aoa =  transpose(squared_array(zip(this.time.array, this.concentration.array)));
var file_names = zip(uniform_array(this.origin_file_array.length, ''),this.origin_file_array);
var names = zip(uniform_array(this.names.length, 'Time ('+this.time.units+')'), this.names.map((x,i)=>x+' ('+this.concentration.units[i]+')'));
aoa.unshift(names);
aoa.unshift(file_names);
ws = XLSX.utils.aoa_to_sheet(aoa);
XLSX.utils.book_append_sheet(wb, ws, ws_name);
// Export of parameters.
ws_name = "Parametric Analysis";
var head = ['Name', 'File', 'Max Concentration', 'Max Time', 'Min Concentration', 'Min Time', 'AUC (start to Min)', 'K', 'SE(K)', 'C0', 'SE(C0)', 't 1/2', 'SE (t 1/2)', 'r^2', 'SEE'];
var max_concentration = this.max_index.array.map((x,i) => this.concentration.array[i][x]);
var max_time = this.max_index.array.map((x,i) => this.time.array[i][x]);
var min_concentration = this.min_index.array.map((x,i) => this.concentration.array[i][x]);
var min_time = this.min_index.array.map((x,i) => this.time.array[i][x]);
var reg_params = transpose(this.regression_parameters.array);
var tmp = []; tmp.push(this.names); tmp.push(this.origin_file_array); tmp.push(max_concentration); tmp.push(max_time); tmp.push(min_concentration); tmp.push(min_time);
tmp.push(this.area_under_curve.array); tmp.push(...reg_params);
aoa=transpose(tmp); aoa.unshift(head);
ws = XLSX.utils.aoa_to_sheet(aoa); XLSX.utils.book_append_sheet(wb, ws, ws_name);
var filename = "Calibration_AK.xlsx";
XLSX.writeFile(wb, filename);
};
};

class HL_FSCV_DATA_CALIBRATION {
constructor(frequency, units, c_units, peak_width){
this.frequency = frequency;
this.origin_file_array = [];
this.current = new HL_FSCV_ARRAY([], units, 'Current');
this.time = new HL_FSCV_ARRAY([], 's', 'Time');
this.concentration = new HL_FSCV_ARRAY([], c_units, 'Concentration'); //Labels or predictions.
this.local_neighbours = peak_width;
this.local_max_index = 0;
this.max_indexes = [];
this.max_values = [];
this.plot_settings = new HL_PLOT_SETTINGS();
this.cv_plot_state = 'block';
this.fit_plot_state = 'none';
this.graph_index = 0;
this.number_of_files = 0;
this.linear_fit_parameters = [];
//PLSR variables.
this.plsr_options = null;
this.plsr_model = null;
this.plsr_x = null;
this.plsr_y = null;
};

read_data_from_loaded_files(data, names_of_files, concentration_array){
this.current.array.push(data.map(x => arrayColumn(x, 2)));
this.time.array.push(data.map(x => makeArr(0,(x.length-1)/this.frequency, x.length)));
this.origin_file_array.push(names_of_files);
this.number_of_files+=data.length;
this.concentration.array.push(concentration_array);
};

read_data_from_plsr_file(data, name_of_files, peak_width){
this.current.array = transpose(data[0][0]);
this.time.array = this.current.array.map(x => makeArr(0,(x.length-1)/this.frequency, x.length));
this.origin_file_array = uniform_array(this.current.array.length, name_of_files[0]);
this.number_of_files = this.current.array.length;
this.concentration.array = data[0][1];
this.detect_max_peak(peak_width);
};

read_data_from_fia_modelling(data, lims, name_of_file, concentration_array){
let cvs = transpose(data).slice(lims[0], lims[1]);
this.current.array.push(cvs);
this.time.array.push(cvs.map(x => makeArr(0,(x.length-1)/this.frequency, x.length)));
this.origin_file_array.push(uniform_array(cvs.length, name_of_file));
this.number_of_files+=cvs.length;
this.concentration.array.push(concentration_array.slice(lims[0], lims[1]));
};

read_data_from_fia_modelling_plsr(data, lims, name_of_file, concentration_array){
let cvs = transpose(data).slice(lims[0], lims[1]);
this.current.array = cvs;
this.time.array = cvs.map(x => makeArr(0,(x.length-1)/this.frequency, x.length));
this.origin_file_array = uniform_array(cvs.length, name_of_file);
this.number_of_files+=cvs.length;
this.concentration.array = concentration_array.slice(lims[0], lims[1]).map(x =>[x]);
};

linearise_data_arrays(){
this.current.array = linearise(this.current.array, 1);
this.time.array = linearise(this.time.array, 1);
this.origin_file_array = linearise(this.origin_file_array, 1);
this.concentration.array = linearise(this.concentration.array, 1);
};

data_loading_finished(peak_width){
this.linearise_data_arrays();
this.detect_max_peak(peak_width);
};

detect_max_peak(peak_width){
this.local_neighbours = peak_width;
for(var i=0;i<this.current.array.length; ++i){this.get_max_point(i);}
};

get_max_point(index){
let local_max = local_maxima(this.current.array[index], this.local_neighbours);
[this.max_indexes[index], this.max_values[index]] = [local_max[0][this.local_max_index], local_max[1][this.local_max_index]];
};

get_linear_fit(div, status_id, type){
this.linear_fit_parameters[0] = linear_fit(this.max_values, this.concentration.array);
this.linear_fit_parameters[1] = linear_estimation_errors(this.max_values.map(x =>this.linear_fit_parameters[0][0]+this.linear_fit_parameters[0][1]*x), this.concentration.array, this.max_values);
this.get_linear_fit_metrics(div, type);
this.update_fitting_status(status_id);
};

get_quadratic_fit(div, status_id, type){
let fit = quadratic_fit(this.max_values, this.concentration.array, 2);
this.linear_fit_parameters[0] = [fit[0][0], fit[1][0], fit[2][0]];
this.linear_fit_parameters[1] = estimation_errors(this.max_values.map(x =>this.linear_fit_parameters[0][0]+this.linear_fit_parameters[0][1]*x+this.linear_fit_parameters[0][2]*x*x), this.concentration.array);
this.get_quadratic_metrics(div, type);
this.update_fitting_status(status_id);
};

get_plsr_fit(div, status_id, tolerance, number_of_components, prediction_output_number){
let options = {latentVectors: number_of_components, tolerance: tolerance};
this.plsr_model = new ML.PLS(options);
this.plsr_x = new ML.Matrix(this.current.array);
this.plsr_y = new ML.Matrix(this.concentration.array);
this.plsr_model.train(this.plsr_x, this.plsr_y);
this.get_plsr_metrics(div, prediction_output_number);
this.update_fitting_status(status_id);
};

get_linear_fit_metrics(div, type){
if(type =='regression_plot_type'){
let x_line_fit = makeArr(index_of_min(this.max_values)[0], index_of_max(this.max_values)[0], 100);
this.plot_scatter_and_line(div, this.max_values, this.concentration.array, 'Experimental', 'Experimental', x_line_fit, x_line_fit.map(x => this.linear_fit_parameters[0][0]+this.linear_fit_parameters[0][1]*x),
'Fit', "Current ("+this.current.units+")",  this.concentration.name +" ("+this.concentration.units+")", '<b>Linear Fit</b>', '<b>S(Q) = '+this.linear_fit_parameters[0][0].toFixed(2)+
' + '+this.linear_fit_parameters[0][1].toFixed(2)+' · Q<br>'+'R<sup>2</sup> = '+this.linear_fit_parameters[0][2].toFixed(2)+'</b>');
} else{
this.plot_scatter_and_line(div, this.concentration.array, this.max_values.map(x => this.linear_fit_parameters[0][0]+this.linear_fit_parameters[0][1]*x), 'Experimental', this.origin_file_array,
makeArr(0,index_of_max(this.concentration.array)[0], 100), makeArr(0,index_of_max(this.concentration.array)[0], 100), "Ideal", 'True values: '+this.concentration.name+' ('+this.concentration.units+')',
'Predicted values: '+this.concentration.name+' ('+this.concentration.units+')', 'Linear Fit', '<b>SEE: ' + this.linear_fit_parameters[1][0].toFixed(2) +' '+this.concentration.units+'</b>');
};
};

get_quadratic_metrics(div, type){
if(type =='regression_plot_type'){
let x_line_fit = makeArr(index_of_min(this.max_values)[0], index_of_max(this.max_values)[0], 100);
this.plot_scatter_and_line(div, this.max_values, this.concentration.array, 'Experimental', 'Experimental', x_line_fit, x_line_fit.map(x => this.linear_fit_parameters[0][0]+this.linear_fit_parameters[0][1]*x+this.linear_fit_parameters[0][2]*x*x),
'Fit', "Current ("+this.current.units+")",  this.concentration.name +" ("+this.concentration.units+")", '<b>Quadratic Fit</b>', '<b>S(Q) = '+this.linear_fit_parameters[0][0].toFixed(2)+
' + '+this.linear_fit_parameters[0][1].toFixed(2)+' · Q +'+this.linear_fit_parameters[0][2].toFixed(2)+' · Q^2<br>'+'R<sup>2</sup> = '+this.linear_fit_parameters[1][1].toFixed(2)+'</b>');
} else{
this.plot_scatter_and_line(div, this.concentration.array, this.max_values.map(x => this.linear_fit_parameters[0][0]+this.linear_fit_parameters[0][1]*x+this.linear_fit_parameters[0][2]*x*x), 'Experimental', this.origin_file_array,
makeArr(0,index_of_max(this.concentration.array)[0], 100), makeArr(0,index_of_max(this.concentration.array)[0], 100), "Ideal", 'True values: '+this.concentration.name+' ('+this.concentration.units+')',
'Predicted values: '+this.concentration.name+' ('+this.concentration.units+')', 'Quadratic Fit', '<b>SEE: ' + this.linear_fit_parameters[1][0].toFixed(2) +' '+this.concentration.units+'</b>');
};
};

get_plsr_metrics(div, prediction_output_number){
let predicted_y = this.plsr_model.predict(this.plsr_x).data.map(x=>x[prediction_output_number]);
let y_real = this.concentration.array.map(x=>x[prediction_output_number]);
this.linear_fit_parameters[0] = null;
this.linear_fit_parameters[1] = [Math.sqrt(mse(y_real, predicted_y))];
this.plot_scatter_and_line(div, y_real, predicted_y, 'Experimental', this.origin_file_array,
makeArr(0,index_of_max(y_real)[0], 100), makeArr(0,index_of_max(y_real)[0], 100), "Ideal", 'True values: '+this.concentration.name+' ('+this.concentration.units+')',
'Predicted values: '+this.concentration.name+' ('+this.concentration.units+')', 'PLSR Fit', '<b>RMSE: ' + this.linear_fit_parameters[1][0].toFixed(2) +' '+this.concentration.units+'<br> Exp. variance: '+this.plsr_model.R2X.toFixed(2)+' </b>');
};

update_fitting_status(status_id){
_(status_id).innerHTML = "&#10004";
};

invert_current_values(div){
this.current.array[this.graph_index] = this.current.array[this.graph_index].map(x => -x);
this.detect_max_peak();
this.plot_graph(div);
};

change_points(pindex){
this.max_indexes[this.graph_index] = pindex; this.max_values[this.graph_index] = this.current.array[this.graph_index][pindex];
};

initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};

plot_scatter_and_line(div, x, y, scatter_name, scatter_text, x_line, y_line, line_name, x_label, y_label, title, annotations){
var layout = this.plot_settings.plot_layout;
layout.title.text = "<b>"+title+"</b>";
layout.xaxis = {title:x_label};
layout.yaxis = {title:y_label};
layout.annotations = [{
xref: 'paper',
yref: 'paper',
x: 0.98,
xanchor: 'right',
y: 0.1,
yanchor: 'bottom',
text: annotations,
showarrow: false
}];

let scatter = {
y:y,
x:x,
name: scatter_name,
type: 'scatter',
showlegend: false,
mode: 'markers',
marker: {color: 'black'},
text:scatter_text
};

let trace = {
y: y_line,
x: x_line,
text:line_name,
showlegend: false,
};

_(div).style.display = "block";
Plotly.newPlot(div, [trace], layout, this.plot_settings.plot_configuration);
Plotly.addTraces(div, [scatter]);
_(div).style.display = this.fit_plot_state;
};

plot_graph(div){
var layout = this.plot_settings.plot_layout;
layout.title.text = "<b>"+this.origin_file_array[this.graph_index]+"</b>";
layout.xaxis = {title:this.time.name +" ("+this.time.units+")"};
layout.yaxis = {title:this.current.name +" ("+this.current.units+")"};

layout.annotations = [{
xref: 'paper',
yref: 'paper',
x: 0.98,
xanchor: 'right',
y: 0.9,
yanchor: 'bottom',
text: '<b>Fitting signals<br>'+this.concentration.name+': '+this.concentration.array[this.graph_index]+' '+this.concentration.units+'</b>',
showarrow: false
}];

var trace = {
y: this.current.array[this.graph_index],
x:this.time.array[this.graph_index],
text:this.origin_file_array[this.graph_index],
showlegend: false,
};


let scatter_data_max = {
y:[this.current.array[this.graph_index][this.max_indexes[this.graph_index]]],
x:[this.time.array[this.graph_index][this.max_indexes[this.graph_index]]],
name: 'Points',
type: 'scatter',
showlegend: false,
mode: 'markers',
marker: {color: 'black'},
text:'Max'
};

_(div).style.display = "block";
Plotly.newPlot(div, [trace], layout, this.plot_settings.plot_configuration);
Plotly.addTraces(div, [scatter_data_max]);
// Assign callback when click to local function graph_click();
_(div).on('plotly_click', function(data){graph_clicked(data)});
_(div).style.display = this.cv_plot_state;
};

export_plsr_model(link_element){if (this.plsr_model != null){
let plsr_model_json_string = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(this.plsr_model.toJSON()));
_(link_element).setAttribute("href", plsr_model_json_string);
_(link_element).setAttribute("download", "plsr_model.json");
_(link_element).click();
}};

export_to_xlsx(model_type){
// Export parameters calculated from the CVs.
var wb = XLSX.utils.book_new(), aoa;
// Export fitting parameters.
if(this.current.array?.length){
aoa = transpose([this.max_values, this.origin_file_array, this.concentration.array]);
aoa.unshift([ 'Max point (sample)', 'File', this.concentration.name +' ('+this.concentration.units+')']);
XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet(aoa), "FSCV Parameters")};
// Export fit parameters.
if (model_type == 'linear_fit'){XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet([['Slope','SE slope', 'Intercept', 'SE intercept', 'R^2', 'SEE'],
[this.linear_fit_parameters[0][1], this.linear_fit_parameters[1][1], this.linear_fit_parameters[0][0], this.linear_fit_parameters[1][2], this.linear_fit_parameters[0][2],
this.linear_fit_parameters[1][0]]]), 'Linear fitting parameters')}
else if (model_type == 'quadratic_fit'){XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet([['0th order','1st order', '2nd order', 'R^2', 'SEE'],
[this.linear_fit_parameters[0][0], this.linear_fit_parameters[0][1], this.linear_fit_parameters[0][2], this.linear_fit_parameters[1][1], this.linear_fit_parameters[1][0]]]), 'Linear fitting parameters')}
else {XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet([['RMSE','Exp. variance', 'Components'],
[this.linear_fit_parameters[1][0], this.plsr_model.R2X, this.plsr_model.latentVectors]]), 'PLSR fitting parameters')}
XLSX.writeFile(wb, 'FSCV_calibration_AK.xlsx');
};
}
