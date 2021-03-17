class HL_MICHAELIS_MENTEN1{
constructor(){
this.plot_settings = new HL_PLOT_SETTINGS();
this.concentration_plot_state = 'block';
this.release_plot_state = 'none';
this.concentration = new HL_FSCV_ARRAY([],[], 'Concentration');
this.modelled_concentration = new HL_FSCV_ARRAY([],[], 'Modelled concentration');
this.release_rate = new HL_FSCV_ARRAY([],[], 'Release rate');
this.time = new HL_FSCV_ARRAY([],'s', 'Time');
this.frequency;
this.stim_parameters = [];
this.kinetic_parameters = [];
this.root_mean_squared_errors = '';

};

add_data_to_application(div, release_graph_div, input_trace, time_array,  start, number_of_pulses, stim_freq, release_constant, vmax, km){
this.assign_concentration_trace(input_trace, time_array);
this.input_values_changed(div, release_graph_div, start, number_of_pulses, stim_freq, release_constant, vmax, km);
};

assign_concentration_trace(input_trace, time_array, basal_concentration){
this.concentration.units = input_trace.units;
this.concentration.name = input_trace.name;
this.concentration.array = input_trace.array;
this.time.array = time_array;
this.frequency = 1/(this.time.array[1]-this.time.array[0]);
};

input_values_changed(concentration_graph_div, release_graph_div, start, number_of_pulses, stim_freq, release_constant, vmax, km){
this.stim_params = [start, number_of_pulses, stim_freq];
this.kinetic_parameters = [vmax, km, release_constant];
this.modelled_concentration.array = this.generate_modelled_concentration(this.stim_params, this.kinetic_parameters);
this.release_rate.units = this.concentration.units+'/s';
this.root_mean_squared_errors = Math.sqrt(mse(this.concentration.array, this.modelled_concentration.array));
this.graph_input_array(release_graph_div, this.release_rate, 'Release rate', 'Release rate');
this.graph_concentration(concentration_graph_div);
};

generate_modelled_concentration([start, number_of_pulses, stim_freq], [vmax, km, release_constant]){
let s = [0], Rt = uniform_array(this.concentration.array.length, 0), samples = (number_of_pulses/stim_freq)*this.frequency,
r = stim_freq*release_constant, sample_start = start*this.frequency;
for(let i=0;i<samples;++i){Rt[sample_start+i] = r};
this.release_rate.array = Rt;
for(let i=0;i<Rt.length-1;++i){s[i+1] = s[i] + (1/this.frequency)*(Rt[i] - (vmax*s[i])/(km+s[i]))};
return s;
};

get_release_array(){

}

optimisation_parameters(epochs, learning_rate, train_array, parameters_id, min_limits_array, max_limits_array){
var opt_params = this.get_optimised_parameters(epochs, learning_rate, train_array, min_limits_array, max_limits_array);
this.update_parameters(opt_params, parameters_id);
};

get_optimised_parameters(epochs, learning_rate, train_array, min_limits_array, max_limits_array){
var self = this;
var func = function([],P){return self.generate_modelled_concentration(self.stim_params, P)};
var optimised_parameters = fminsearch(func, this.kinetic_parameters,[],this.concentration.array,
{maxIter:epochs, trainable:train_array, step: uniform_array(this.kinetic_parameters.length, learning_rate), min_limits: min_limits_array, max_limits: max_limits_array});
return optimised_parameters;
};


update_parameters([vmax, km, release_constant], [vmax_id, km_id, release_constant_id]){
_(vmax_id).value = vmax, _(km_id).value = km, _(release_constant_id).value = release_constant;
this.kinetic_parameters = [vmax, km, release_constant];
};


graph_concentration(div){
var layout = this.plot_settings.plot_layout;
layout.xaxis.title = this.time.name +" ("+this.time.units+")";
layout.yaxis.title = this.concentration.name +" ("+this.concentration.units+")";
layout.title.text = "<b> c-t Curve </b>";
layout.annotations = [{
xref: 'paper',
yref: 'paper',
x: 0.98,
xanchor: 'right',
y: 0.9,
yanchor: 'bottom',
text: '<b>RMSE : '+this.root_mean_squared_errors.toFixed(2)+' '+this.concentration.units+'</b>',
showarrow: false
}];


var experimental_trace = {
y: this.concentration.array,
x: this.time.array,
showlegend: false,
name:'Experimental',
};

var modelled_trace = {
y: this.modelled_concentration.array,
x: this.time.array,
showlegend: false,
name:'Model',
};
_(div).style.display = "block";
Plotly.newPlot(div, [experimental_trace, modelled_trace], layout, this.plot_settings.plot_configuration);
_(div).style.display = this.concentration_plot_state;
};

graph_input_array(div, y, y_name, title){
var trace = {
x: this.time.array,
y: y.array,
name: y_name,
showlegend: false
};

var layout = {
title:  {
text: '<b> '+title+' </b>',
font: {
size: 20,
family:'Arial'
},
x: 0.05,
y: 1.2,
xanchor: 'left',
yanchor: 'bottom',
},
xaxis:{title:this.time.name +" ("+this.time.units+")"},
yaxis: {title: y.name+" ("+y.units+")"},
autosize: true,
};
_(div).style.display = "block";
Plotly.newPlot(div, [trace], layout, this.plot_settings.plot_configuration);
_(div).style.display = this.release_plot_state;
};

initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};

export_kinetic_parameters(){
var wb = XLSX.utils.book_new();
// Sheet with the model.
var ws_name = "Model";
var aoa = transpose([this.time.array, this.concentration.array, this.modelled_concentration.array, this.release_rate.array]);
aoa.unshift([this.time.name, this.concentration.name, this.modelled_concentration.name, this.release_rate.name]);
var ws = XLSX.utils.aoa_to_sheet(aoa);
XLSX.utils.book_append_sheet(wb, ws, ws_name);
// Sheet with kinetic parameters.
ws_name = "Kinetic parameters";
aoa = [['Vmax', 'Km', 'Release constant'], flatten([this.kinetic_parameters])];
ws = XLSX.utils.aoa_to_sheet(aoa);
XLSX.utils.book_append_sheet(wb, ws, ws_name);
// Sheet with R and A breaks.
ws_name = "Stimulation parameters";
aoa = [['Start time (s)', 'Number of pulses', 'freq. (Hz)'], flatten([this.stim_params])]
ws = XLSX.utils.aoa_to_sheet(aoa);
XLSX.utils.book_append_sheet(wb, ws, ws_name);
var filename = "Modelling_AK.xlsx";
XLSX.writeFile(wb, filename);
};
};
