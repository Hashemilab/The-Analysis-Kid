// Class for uploaded FSCAV data.
class HL_FSCAV_DATA{
constructor(frequency, units, c_units, peak_width, state){
this.frequency = frequency;
this.origin_file_array = [];
this.current = new HL_FSCV_ARRAY([], units, 'Current');
this.norm_current = new HL_FSCV_ARRAY([], units, 'Norm. current');
this.time = new HL_FSCV_ARRAY([], 's', 'Time');
this.concentration = new HL_FSCV_ARRAY([], c_units, 'Concentration'); //Labels or predictions.
// Parameters to calculate the charge, get the linear fit and the SNN model.
this.local_neighbours = peak_width;
this.max_indexes = [];
this.max_values = [];
this.min_indexes = [];
this.min_values = [];
this.total_auc = [];
this.line_auc = [];
this.auc = [];
this.normalised_dataset = [];
this.normalised_labels = [];
this.linear_fit_parameters = [];
this.snn_fit_parameters = [];
this.snn_model;
// Plotting parameters.
this.plot_settings = new HL_PLOT_SETTINGS();
this.cv_plot_state = 'block';
this.fit_plot_state = 'none';
this.state = state;
this.graph_index = 0;
this.number_of_files = 0;
};

read_data_from_loaded_files(data, names_of_files, concentration_label){
this.current.array.push(data.map(x => arrayColumn(x, 2)));
this.time.array.push(data.map(x => makeArr(0,(x.length-1)/this.frequency, x.length)));
this.origin_file_array.push(names_of_files);
this.number_of_files+=data.length;
this.concentration.array.push(uniform_array(data.length, concentration_label));
};

linearise_data_arrays(){
this.current.array = linearise(this.current.array, 1);
this.time.array = linearise(this.time.array, 1);
this.origin_file_array = linearise(this.origin_file_array, 1);
this.concentration.array = linearise(this.concentration.array, 1);
};



data_loading_finished(peak_width){
this.linearise_data_arrays();
this.calculate_limits_and_auc(peak_width);
};

calculate_limits_and_auc(peak_width){
this.local_neighbours = peak_width;
for(var i=0;i<this.current.array.length; ++i){this.get_max_and_min_values(i); this.get_auc(i)};
};

get_max_and_min_values(index){
[this.max_indexes[index], this.max_values[index]] = local_maxima(this.current.array[index], this.local_neighbours);
[this.min_indexes[index], this.min_values[index]] = local_minima(this.current.array[index], this.local_neighbours);
};

get_auc(index){
this.get_normalized_current_array(index);
this.total_auc[index] = simpson_auc(this.norm_current.array[index].slice(this.min_indexes[index][0], this.min_indexes[index][1]), this.frequency);
var linear_parameters = linear_fit([this.time.array[index][this.min_indexes[index][0]], this.time.array[index][this.min_indexes[index][1]]],
[this.norm_current.array[index][this.min_indexes[index][0]], this.norm_current.array[index][this.min_indexes[index][1]]]);
var line = this.time.array[index].slice(this.min_indexes[index][0], this.min_indexes[index][1]).map(x => linear_parameters[0]+linear_parameters[1]*x);
this.line_auc[index] = simpson_auc(line,this.frequency);
this.auc[index] = this.total_auc[index] - this.line_auc[index];
};
get_normalized_current_array(index){
this.norm_current.array[index] = [];
for(var j = 0; j<this.current.array[index].length; ++j){this.norm_current.array[index][j] = this.current.array[index][j] - this.min_values[index][0]};
};

change_points(pindex, type){
if(type == "min1"){this.min_indexes[this.graph_index][0] = pindex; this.min_values[this.graph_index][0] = this.current.array[this.graph_index][pindex]}
else if(type == "min2"){this.min_indexes[this.graph_index][1] = pindex; this.min_values[this.graph_index][1] = this.current.array[this.graph_index][pindex]}
else {this.max_indexes[this.graph_index][0] = pindex; this.max_values[this.graph_index][0] = this.current.array[this.graph_index][pindex]};
// Recalculate auc
this.get_auc(this.graph_index);
};

manual_change_points(value, type){
if(type =="first_interval_point_button"){
for(var i=0;i<this.current.array.length; ++i){this.min_indexes[i][0] = value; this.min_values[i][0] = this.current.array[i][value]; this.get_auc(i)};
}
else if(type=="max_point_button"){
for(var i=0;i<this.current.array.length; ++i){this.max_indexes[i][0] = value; this.max_values[i][0] = this.current.array[i][value]; this.get_auc(i)};
}
else if(type=="second_interval_point_button"){
for(var i=0;i<this.current.array.length; ++i){this.min_indexes[i][1] = value; this.min_values[i][1] = this.current.array[i][value]; this.get_auc(i)};
};
};


initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};

invert_current_values(div){
this.current.array[this.graph_index] = this.current.array[this.graph_index].map(x => -x);
this.get_max_and_min_values(this.graph_index); this.get_auc(this.graph_index);
this.plot_graph(div);
};

get_linear_fit(div, status_id, type){if(this.state = 'fit'){
this.linear_fit_parameters[0] = linear_fit(this.auc, this.concentration.array);
this.linear_fit_parameters[1] = linear_estimation_errors(this.auc.map(x =>this.linear_fit_parameters[0][0]+this.linear_fit_parameters[0][1]*x), this.concentration.array, this.auc);
this.get_linear_fit_metrics(div, type);
this.update_fitting_status(status_id);
}};

get_linear_fit_metrics(div, type){
if(type =='regression_plot_type'){
let x_line_fit = makeArr(index_of_min(this.auc)[0], index_of_max(this.auc)[0], 100);
this.plot_scatter_and_line(div, this.auc, this.concentration.array, 'Experimental', 'Experimental', x_line_fit, x_line_fit.map(x => this.linear_fit_parameters[0][0]+this.linear_fit_parameters[0][1]*x),
'Fit', "Charge ("+this.current.units+"·s)",  this.concentration.name +" ("+this.concentration.units+")", '<b>Linear Fit</b>', '<b>S(Q) = '+this.linear_fit_parameters[0][0].toFixed(2)+
' + '+this.linear_fit_parameters[0][1].toFixed(2)+' · Q<br>'+'R<sup>2</sup> = '+this.linear_fit_parameters[0][2].toFixed(2)+'</b>');
} else{
this.plot_scatter_and_line(div, this.concentration.array, this.auc.map(x => this.linear_fit_parameters[0][0]+this.linear_fit_parameters[0][1]*x), 'Experimental', this.origin_file_array,
makeArr(0,index_of_max(this.concentration.array)[0], 100), makeArr(0,index_of_max(this.concentration.array)[0], 100), "Ideal", 'True values: '+this.concentration.name+' ('+this.concentration.units+')',
'Predicted values: '+this.concentration.name+' ('+this.concentration.units+')', 'Linear Fit', '<b>SEE: ' + this.linear_fit_parameters[1][0].toFixed(2) +' '+this.concentration.units+'</b>');
};
};

predict_from_linear_fit(div, linear_fit_parameters){if(this.state = 'predict'){
// Method only to be used by objects in predict mode.
this.get_prediction_from_linear_fit(linear_fit_parameters, this);
this.plot_scatter_and_line(div, makeArr(0,this.concentration.array.length-1, this.concentration.array.length-1), this.concentration.array, 'Predictions', this.origin_file_array,
[], [], '', 'File number', this.concentration.name +" ("+this.concentration.units+")", '<b>Predictions</b>', 'Predictions from linear fit');
}};

get_prediction_from_linear_fit(linear_fit_parameters, fscav_data){
fscav_data.linear_fit_parameters = linear_fit_parameters;
fscav_data.concentration.array = fscav_data.auc.map(x => linear_fit_parameters[0][0]+linear_fit_parameters[0][1]*x);
};

show_predict_charge(div){if(this.state = 'predict'){
this.plot_scatter_and_line(div, makeArr(0,this.auc.length-1, this.auc.length-1), this.auc, 'Charge plot', this.origin_file_array,
[], [], '', 'File number', "Charge ("+this.current.units+"·s)", '<b>Charge plot</b>', 'Estimated charge from voltammograms.');
}};

get_snn_fit(div, epochs, learning_rate, layer_size, patience, min_delta, dropout_rate, std_noise, status_id, snn_type){if(this.state = 'fit'){
var self = this;
this.get_normalised_training_set([this.auc, this.line_auc, arrayColumn(this.min_values, 1), arrayColumn(this.max_values, 0)], this.concentration.array);
if(snn_type === 'single_electrode'){this.define_new_snn_model(std_noise, layer_size, dropout_rate); this.compile_and_fit(self, div, learning_rate, epochs, patience, min_delta, status_id);}
else if(snn_type == 'multiple_electrodes'){tf.loadLayersModel("TensorFlowModels/dnn_fscav.json").then(model => self.get_loaded_model(model, std_noise, dropout_rate)).then(() => self.compile_and_fit(self, div, learning_rate, epochs, patience, min_delta, status_id))};
}};

define_new_snn_model(std_noise, layer_size, dropout_rate){
this.snn_model = tf.sequential({layers: [tf.layers.gaussianNoise({stddev:std_noise, inputShape: [4]}),
tf.layers.dense({units: layer_size, activation: 'relu'}),tf.layers.gaussianDropout({rate:dropout_rate}), tf.layers.dense({units: layer_size, activation: 'relu'}),
tf.layers.dense({units: 1})]});
};

get_loaded_model(model, std_noise, dropout_rate){
this.snn_model = model;
this.snn_model.layers[0].outboundNodes[0].outboundLayer.stddev = std_noise; // Change Gaussian STD of noise.
this.snn_model.layers[2].outboundNodes[0].outboundLayer.rate = dropout_rate; //Change the dropout rate.
};
compile_and_fit(self, div, learning_rate, epochs, patience, min_delta, status_id){
this.snn_model.compile({optimizer: tf.train.adam(learning_rate), loss: tf.losses.meanSquaredError, metrics: [tf.metrics.meanSquaredError]});
const data = tf.tensor(transpose(this.normalised_dataset[0]));
const labels = tf.tensor(this.normalised_labels[0]);
this.snn_model.fit(data, labels, {epochs: epochs, validationSplit:0.1, callbacks: tf.callbacks.earlyStopping({monitor: 'val_loss', patience: patience, minDelta: min_delta})}).then(info => {
self.update_fitting_status(status_id);
this.snn_fit_parameters[0] = [info.history.loss, info.history.val_loss];
self.get_snn_fitting_metrics(div);
});
};

get_snn_fitting_metrics(div){if(this.state = 'fit'){
// Function to calculate and plot the predictions of the snn with the train data. Important: good predictions do not mean it will perform well with other data.
const data = tf.tensor(transpose(this.normalised_dataset[0]));
let predicted_concentration = denormalize(Array.from(this.snn_model.predict(data).dataSync()), this.normalised_labels[1], this.normalised_labels[2]);
this.snn_fit_parameters[1] = Math.sqrt(mse(this.concentration.array,  predicted_concentration));
this.plot_scatter_and_line(div, this.concentration.array, predicted_concentration, 'Experimental', this.origin_file_array, makeArr(0,index_of_max(this.concentration.array)[0], 100),
makeArr(0,index_of_max(this.concentration.array)[0], 100), 'Ideal', 'True values: '+this.concentration.name+' ('+this.concentration.units+')',
'Predicted values: '+this.concentration.name+' ('+this.concentration.units+')', 'SNN Fit', '<b>RMSE: ' + this.snn_fit_parameters[1].toFixed(2) +' '+this.concentration.units+'</b>');
}};

predict_from_snn(div, snn_model, norm_data, norm_labels){if(this.state = 'predict'){
this.get_prediction_from_snn(snn_model, norm_data, norm_labels, this);
this.plot_scatter_and_line(div, makeArr(0,this.concentration.array.length-1, this.concentration.array.length-1), this.concentration.array, 'Predictions', this.origin_file_array,
[], [], '', 'File number', this.concentration.name +" ("+this.concentration.units+")", '<b>Predictions</b>', 'Predictions from SNN');
}};

get_prediction_from_snn(snn_model, norm_data, norm_labels, fscav_data){
//Assign model and normalization to predict object.
this.snn_model = snn_model;
const data = tf.tensor(transpose(this.get_normalised_prediction_set([fscav_data.auc, fscav_data.line_auc, arrayColumn(fscav_data.min_values, 1), arrayColumn(fscav_data.max_values, 0)], norm_data[1], norm_data[2])));
fscav_data.concentration.array = denormalize(Array.from(fscav_data.snn_model.predict(data).dataSync()), norm_labels[1], norm_labels[2]);
};

predict_from_snn_whole_cv_model(div, std_noise, dropout_rate){
var self = this;
tf.loadLayersModel("TensorFlowModels/dnn_fscav_whole_cv.json").then(model => self.get_loaded_model(model, std_noise, dropout_rate)).then(() => self.get_prediction_from_snn_whole_cv_model())



};

get_prediction_from_snn_whole_cv_model(){

//CONITNUE HERE.

};

update_fitting_status(status_id){
_(status_id).innerHTML = "&#10004";
};

get_normalised_training_set(data, labels){if(this.state = 'fit'){
let max = [], min = [], norm_data = [], max_labels = index_of_max(labels)[0], min_labels = index_of_min(labels)[0], norm_labels = normalize(labels, max_labels, min_labels);
for(var i = 0; i<data.length;++i){max[i] = index_of_max(data[i])[0]; min[i] = index_of_min(data[i])[0]; norm_data[i] = normalize(data[i], max[i], min[i])};
this.normalised_dataset = [norm_data, max, min]; this.normalised_labels = [norm_labels, max_labels, min_labels];
}};

get_normalised_prediction_set(data, training_max, training_min){if(this.state = 'predict'){
let norm_data = [];
for(var i = 0; i<data.length; ++i){norm_data[i] = normalize(data[i], training_max[i], training_min[i])};
return norm_data;
}};

plot_graph(div){
var layout = this.plot_settings.plot_layout;
layout.title.text = "<b>"+this.origin_file_array[this.graph_index]+"</b>";
layout.xaxis = {title:this.time.name +" ("+this.time.units+")"};
layout.yaxis = {title:this.current.name +" ("+this.current.units+")"};

if(this.state == 'fit'){
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
} else{
layout.annotations = [{
xref: 'paper',
yref: 'paper',
x: 0.98,
xanchor: 'right',
y: 0.9,
yanchor: 'bottom',
text: '<b>Prediction signals</b>',
showarrow: false
}];
};

var trace = {
y: this.current.array[this.graph_index],
x:this.time.array[this.graph_index],
text:this.origin_file_array[this.graph_index],
showlegend: false,
};


let scatter_data_max = {
y:[this.current.array[this.graph_index][this.max_indexes[this.graph_index][0]]],
x:[this.time.array[this.graph_index][this.max_indexes[this.graph_index][0]]],
name: 'Points',
type: 'scatter',
showlegend: false,
mode: 'markers',
marker: {color: 'black'},
text:'Max'
};

let scatter_data_min = {
y:[this.current.array[this.graph_index][this.min_indexes[this.graph_index][0]],
this.current.array[this.graph_index][this.min_indexes[this.graph_index][1]]],
x:[this.time.array[this.graph_index][this.min_indexes[this.graph_index][0]],
this.time.array[this.graph_index][this.min_indexes[this.graph_index][1]]],
name: 'Points',
type: 'scatter',
showlegend: false,
mode: 'markers+lines',
line: {color: 'black', width:0.5, dash: 'dot'},
marker: {color: 'black'},
text:'Min'
};
_(div).style.display = "block";
Plotly.newPlot(div, [trace], layout, this.plot_settings.plot_configuration);
Plotly.addTraces(div, [scatter_data_max, scatter_data_min]);
// Assign callback when click to local function graph_click();
_(div).on('plotly_click', function(data){graph_clicked(data)});
_(div).style.display = this.cv_plot_state;
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

export_to_xlsx(fscav_data_predict){if(this.state = 'fit'){
// Export parameters calculated from the CVs.
var wb = XLSX.utils.book_new(), aoa;
// Export fitting parameters.
if(this.current.array?.length){
aoa = transpose([this.auc, this.line_auc, arrayColumn(this.min_values, 0), arrayColumn(this.min_values, 1), arrayColumn(this.max_values, 0), this.origin_file_array, this.concentration.array]);
aoa.unshift(['Charge above line ('+this.current.units+'· s)', 'Charge below line ('+this.current.units+'· s)', 'Interval start (sample)',  'Interval end (sample)', 'Max point (sample)',
'File', this.concentration.name +' ('+this.concentration.units+')']); XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet(aoa), "FSCAV Parameters")};
// Export prediction parameters.
if(fscav_data_predict.current.array?.length){
aoa = transpose([fscav_data_predict.auc, fscav_data_predict.line_auc, arrayColumn(fscav_data_predict.min_values, 0), arrayColumn(fscav_data_predict.min_values, 1),
arrayColumn(fscav_data_predict.max_values, 0), fscav_data_predict.origin_file_array]); aoa.unshift(['Charge above line ('+fscav_data_predict.current.units+'· s)',
'Charge below line ('+fscav_data_predict.current.units+'· s)', 'Interval start (value)',  'Interval end (value)', 'Max point (value)','File']);
XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet(aoa), 'Prediction Parameters')};
// Export linear fit parameters.
if(this.linear_fit_parameters?.length){XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet([['Slope','SE slope', 'Intercept', 'SE intercept', 'R^2', 'SEE'],
[this.linear_fit_parameters[0][1], this.linear_fit_parameters[1][1], this.linear_fit_parameters[0][0], this.linear_fit_parameters[1][2], this.linear_fit_parameters[0][2],
this.linear_fit_parameters[1][0]]]), 'Fitting Parameters')};
//Export SNN fit parameters
if(this.snn_model){XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet([['RMSE'], [this.snn_fit_parameters[1]]]), 'SNN Fit Parameters')};
//Export model linear predictions.
if(this.linear_fit_parameters?.length && fscav_data_predict.current.array?.length){fscav_data_predict.get_prediction_from_linear_fit(this.linear_fit_parameters, fscav_data_predict);
aoa = transpose([fscav_data_predict.concentration.array.slice()]); aoa.unshift([this.concentration.name + ' ('+this.concentration.units+')']); XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet(aoa), 'Linear Fit Predictions')};
//Export model SNN predictions.
if(this.snn_model && fscav_data_predict.current.array?.length){fscav_data_predict.get_prediction_from_snn(this.snn_model, this.normalised_dataset, this.normalised_labels, fscav_data_predict);
aoa = transpose([fscav_data_predict.concentration.array.slice()]); aoa.unshift([this.concentration.name + ' ('+this.concentration.units+')']);XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet(aoa), 'SNN Fit Predictions')};
XLSX.writeFile(wb, 'FSCAV_calibration_AK.xlsx');
};
};
};
