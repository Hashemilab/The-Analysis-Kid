class HL_MICHAELIS_MENTEN{
constructor(){
this.plot_settings = new HL_PLOT_SETTINGS();
this.concentration_plot_state = 'block';
this.release_plot_state = 'none';
this.average_concentration = new HL_FSCV_ARRAY([],[], 'Concentration');
this.modelled_concentration = new HL_FSCV_ARRAY([],[], 'Concentration');
this.release_rate = new HL_FSCV_ARRAY([],[], 'Release rate');
this.autoreceptors_rate = new HL_FSCV_ARRAY([],[], 'Autoreceptors rate');
this.time = new HL_FSCV_ARRAY([],'s', 'Time');
this.frequency;
this.parameters = []; // vmax1, km1, vmax2, km2.
this.alpha_beta = []; // alpha_1, alpha_2, alpha_threshold, beta_1, beta_2, beta_threshold.
this.release_rate_slider = {
start: [50],
tooltips: true,
range: {
'min': 0,
'max': 100
},
step:0.1,
};

this.autoreceptors_slider = {
start: [50],
tooltips: true,
range: {
'min': 0,
'max': 100
},
step:0.1,
};
this.release_rate_slider_values = [0];
this.autoreceptors_slider_values = [0];
};

add_data_to_application(div, fscv_concentration, release_graph_div, release_div, autoreceptors_div,
release_type, autoreceptors_type, parameters, alpha_beta, release_list_div, autoreceptors_list_div){
this.assign_concentration_trace(fscv_concentration);
this.initialise_sliders(release_div, release_type, autoreceptors_div, autoreceptors_type);
this.input_values_changed(div, release_graph_div, release_div, autoreceptors_div, release_type,
autoreceptors_type, parameters, alpha_beta, release_list_div, autoreceptors_list_div);
};

assign_concentration_trace(fscv_concentration){
this.average_concentration = fscv_concentration.average_concentration;
this.time.array = fscv_concentration.time.array[0];
};

initialise_sliders(release_div, release_type, autoreceptors_div,  autoreceptors_type){
this.frequency = parseInt(1/(this.time.array[2] - this.time.array[1]));
this.get_slider_max_value(release_type); this.get_slider_max_value(autoreceptors_type);
this.reset_slider(release_div, release_type); this.reset_slider(autoreceptors_div, autoreceptors_type);
};

get_slider_max_value(type){
this[type].range.max = this.time.array.length/this.frequency;
this[type].start[0] = (this.time.array.length/this.frequency)/2;
};

add_slider_break(div, list_div, type){
this[type].start.push(this[type].start[this[type].start.length-1]); this[type+'_values'].push(0);
this.reset_slider(div,type);
this.add_input_field(div, list_div, type);
};

remove_slider_break(div, list_div, type){
this[type].start.pop(); this[type+'_values'].pop();
this.reset_slider(div, type);
this.remove_input_field(list_div);
};

reset_slider(div, type){
_(div).noUiSlider.destroy();
noUiSlider.create(_(div), this[type]);
_(div).noUiSlider.on('change', values_changed);
};

add_input_field(div, list_div, type){
var input = document.createElement('input');
input.id =  type + "_input_" + this[type].start.length;
input.type = 'number'; input.style.width='18%'; input.value=0;
input.addEventListener('change', values_changed)
_(list_div).appendChild(input);
};

remove_input_field(list_div){
_(list_div).removeChild(_(list_div).lastChild);
};



input_values_changed(concentration_graph_div, release_graph_div, release_div, autoreceptors_div,
release_type, autoreceptors_type, parameters, alpha_beta, release_list_div, autoreceptors_list_div){
this.assign_slider_values(release_div, release_type); this.assign_slider_values(autoreceptors_div, autoreceptors_type);
this.parameters = parameters; this.alpha_beta = alpha_beta;
this.get_input_values(release_list_div, release_type); this.get_input_values(autoreceptors_list_div, autoreceptors_type);
this.release_rate.array = this.generate_input_arrays(release_type, this.average_concentration.array.length);
this.release_rate.units = this.average_concentration.units+'/s';
this.autoreceptors_rate.array = this.generate_input_arrays(autoreceptors_type, this.average_concentration.array.length);
this.autoreceptors_rate.units = '%';
this.modelled_concentration.array = this.generate_modelled_concentration(this.release_rate.array, this.autoreceptors_rate.array, this.parameters, this.alpha_beta);
this.graph_input_arrays(release_graph_div, this.release_rate, 'Release rate', this.autoreceptors_rate, 'Autoreceptors', 'R(t) and A(t)');
this.graph_concentration(concentration_graph_div);
};

assign_slider_values(div, type){
this[type].start = flatten([_(div).noUiSlider.get()]);
};

get_input_values(list_div, type){
var children = _(list_div).children;
for (var i = 0; i < children.length; i++) {this[type+'_values'][i] = children[i].value};
}

generate_input_arrays(type, length){
var sample_breaks = this[type].start.map(x => parseInt(x*this.frequency)); sample_breaks.unshift(0); sample_breaks.push(length);
var rates = parse_array_to_float(this[type+'_values']); rates.unshift(0); var tmp = [0], arr = [];
for(var i=0; i<sample_breaks.length-1;++i){
if(sample_breaks[i+1]-sample_breaks[i] > 0){
tmp = makeArr(tmp[tmp.length-1], tmp[tmp.length-1] + (rates[i]/this.frequency)*(sample_breaks[i+1]-sample_breaks[i]-1), sample_breaks[i+1]-sample_breaks[i]);
arr.push(tmp);
}
};
return flatten(arr);
};

generate_modelled_concentration(Rt, At, [vmax1, km1, vmax2, km2], [alpha_1, alpha_2, alpha_threshold, bata_1, beta_2, beta_threshold]){
var s = [0, 0], alpha, beta;
for(var i=1;i<Rt.length-1;++i){
alpha = this.get_alpha_beta_values(alpha_1, alpha_2, alpha_threshold), beta = this.get_alpha_beta_values(beta_1, beta_2, beta_threshold);
s[i+1] = s[i-1] + (2/this.frequency)*(Rt[i]*(1-At[i]/100) - (alpha)*(vmax1*s[i])/(km1+s[i]) - (beta)*(vmax2*s[i])/(km2+s[i]));
};
return s;
};

get_alpha_beta_values(param_1, param_2, s_threshold, s){
if(s>s_threshold){return param_1} else{return param_2};
};

optimisation_parameters(epochs, learning_rate, train_array, parameters_id, concentration_graph_div, release_graph_div, release_div, autoreceptors_div,
release_type, autoreceptors_type, parameters, alpha_beta, release_list_div, autoreceptors_list_div){
var opt_params = this.get_optimised_parameters(epochs, learning_rate, train_array);
this.update_parameters(opt_params, vmax1_id, km1_id, vmax2_id, km2_id);
this.input_values_changed(concentration_graph_div, release_graph_div, release_div, autoreceptors_div, release_type,
autoreceptors_type, parameters, alpha_beta, release_list_div, autoreceptors_list_div);
};

get_optimised_parameters(epochs, learning_rate, train_array){
//Provisional
const vmax1_tensor = tf.scalar(this.parameters[0]).variable(train_array[0]);
const km1_tensor = tf.scalar(this.parameters[1]).variable(train_array[1]);
const vmax2_tensor = tf.scalar(this.parameters[2]).variable(train_array[2]);
const km2_tensor = tf.scalar(this.parameters[3]).variable(train_array[3]);
const concentration_tensor = tf.tensor1d(this.average_concentration.array);
const cost = (pred, label) => pred.sub(label).square().mean();
const optimizer = tf.train.adagrad(learning_rate);
// Train the model.
for (let i = 0; i < epochs; i++) {
optimizer.minimize(() => cost(this.generate_modelled_concentration_tensor(vmax1_tensor, km1_tensor, vmax2_tensor, km2_tensor), concentration_tensor));
};
return [vmax1_tensor.dataSync()[0], km1_tensor.dataSync()[0], vmax2_tensor.dataSync()[0], km1_tensor.dataSync()[0]];
};

generate_modelled_concentration_tensor(vmax1_tensor, km1_tensor, vmax2_tensor, km2_tensor){
//Provisional
var s = tf.buffer([this.average_concentration.array.length, 1]), alpha, beta, tmp1, tmp2, tmp3;
for(var i=1;i<this.average_concentration.array-1;++i){
alpha = tf.scalar(this.get_alpha_beta_values(this.alpha_beta[0], this.alpha_beta[1], this.alpha_beta[2]));
beta = tf.scalar(this.get_alpha_beta_values(this.alpha_beta[3], this.alpha_beta[4], this.alpha_beta[5]));
tmp1 = tf.scalar((2/this.frequency)*(this.release_rate.array[i]*(1-this.autoreceptors_rate.array[i]/100));
s_ii = tf.scalar(s.get(i)); s_iii = tf.scalar(s.get(i+1)); s_i = tf.scalar(s.get(i-1));
tmp2 = alpha.mul(vmax1_tensor.mul(s_ii)).div(km1_tensor.add(s_ii));
tmp3 = beta.mul(vmax2_tensor.mul(s_ii)).div(km2_tensor.add(s_ii));
s.values[i+1] = 
};
};
update_parameters([vmax1, km1, vmax2, km2], vmax1_id, km1_id, vmax2_id, km2_id){
_(vmax1_id).value = vmax1, _(km1_id).value = km1, _(vmax2_id).value = vmax2, _(km2_id).value = km2;
};


graph_concentration(div){
var layout = this.plot_settings.plot_layout;
layout.xaxis.title = this.time.name +" ("+this.time.units+")";
layout.yaxis.title = this.average_concentration.name +" ("+this.average_concentration.units+")";
layout.title.text = "<b> c-t Curve </b>";
var experimental_trace = {
y: this.average_concentration.array,
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

graph_input_arrays(div, y1, y1_name, y2, y2_name, title){
var trace_1 = {
x: this.time.array,
y: y1.array,
name: y1_name,
showlegend: false
};

var trace_2 = {
x: this.time.array,
y: y2.array,
name: y2_name,
yaxis: 'y2',
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
yaxis: {title: y1.name+" ("+y1.units+")"},
yaxis2: {
title: y2.name+" ("+y2.units+")",
overlaying: 'y',
side: 'right'
},
autosize: true,
};
_(div).style.display = "block";
Plotly.newPlot(div, [trace_1, trace_2], layout, this.plot_settings.plot_configuration);
_(div).style.display = this.release_plot_state;
};






initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};



}
