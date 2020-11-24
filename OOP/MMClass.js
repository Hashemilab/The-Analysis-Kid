class HL_MICHAELIS_MENTEN{
constructor(){
this.plot_settings = new HL_PLOT_SETTINGS();
this.average_concentration = new HL_FSCV_ARRAY([],[], 'Concentration');
this.modelled_concentration = new HL_FSCV_ARRAY([],[], 'Concentration');
this.release_rate = new HL_FSCV_ARRAY([],[], 'Release rate');
this.autoreceptors_rate = new HL_FSCV_ARRAY([],[], 'Autoreceptors rate');
this.alpha = new HL_FSCV_ARRAY([],[], 'Alpha');
this.beta = new HL_FSCV_ARRAY([],[], 'Beta');
this.time = new HL_FSCV_ARRAY([],'s', 'Time');
this.frequency;
this.parameters = []; // alpha, vmax1, km1, beta, vmax2, km2.
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
this.alpha_slider = {
start: [50],
tooltips: true,
range: {
'min': 0,
'max': 100
},
step:0.1,
};
this.beta_slider = {
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
this.alpha_slider_values = [0];
this.beta_slider_values = [0];
};

add_data_to_application(div, fscv_concentration, release_graph_div, alpha_graph_div, release_div, autoreceptors_div, alpha_div, beta_div,
release_type, autoreceptors_type, alpha_type, beta_type, parameters, release_list_div, autoreceptors_list_div, alpha_list_div, beta_list_div){
this.assign_concentration_trace(fscv_concentration);
this.initialise_sliders(release_div, release_type, autoreceptors_div, autoreceptors_type, alpha_div, alpha_type, beta_div, beta_type);
this.input_values_changed(div, release_graph_div, alpha_graph_div, release_div, autoreceptors_div, alpha_div, beta_div, release_type,
autoreceptors_type, alpha_type, beta_type,  parameters, release_list_div, autoreceptors_list_div, alpha_list_div, beta_list_div);
};

assign_concentration_trace(fscv_concentration){
this.average_concentration = fscv_concentration.average_concentration;
this.time.array = fscv_concentration.time.array[0];
};

initialise_sliders(release_div, autoreceptors_div, release_type, autoreceptors_type, alpha_div, alpha_type, beta_div, beta_type){
this.frequency = parseInt(1/(this.time.array[2] - this.time.array[1]));
this.get_slider_max_value(release_type); this.get_slider_max_value(autoreceptors_type);
this.get_slider_max_value(alpha_type); this.get_slider_max_value(beta_type);
this.reset_slider(release_div, release_type); this.reset_slider(autoreceptors_div, autoreceptors_type);
this.reset_slider(alpha_div, alpha_type); this.reset_slider(beta_div, beta_type);
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



input_values_changed(concentration_graph_div, release_graph_div, alpha_graph_div, release_div, autoreceptors_div, alpha_div, beta_div,
release_type, autoreceptors_type, alpha_type, beta_type, parameters, release_list_div, autoreceptors_list_div, alpha_list_div, beta_list_div){
this.assign_slider_values(release_div, release_type); this.assign_slider_values(autoreceptors_div, autoreceptors_type);
this.assign_slider_values(alpha_div, alpha_type); this.assign_slider_values(beta_div, beta_type);
this.parameters = parameters;
this.get_input_values(release_list_div, release_type); this.get_input_values(autoreceptors_list_div, autoreceptors_type);
this.get_input_values(alpha_list_div, alpha_type); this.get_input_values(beta_list_div, beta_type);
this.release_rate.array = this.generate_input_arrays(release_type, this.average_concentration.array.length);
this.release_rate.units = this.average_concentration.units+'/s';
this.autoreceptors_rate.array = this.generate_input_arrays(autoreceptors_type, this.average_concentration.array.length);
this.autoreceptors_rate.units = '%';
this.alpha.array = this.generate_input_arrays(alpha_type, this.average_concentration.array.length);
this.alpha.units = '%';
this.beta.array = this.generate_input_arrays(beta_type, this.average_concentration.array.length);
this.beta.units = '%';
this.modelled_concentration.array = this.generate_modelled_concentration(this.release_rate.array, this.autoreceptors_rate.array, this.alpha.array,
this.parameters[0], this.parameters[1], this.beta.array, this.parameters[2], this.parameters[3]);
this.graph_input_arrays(release_graph_div, this.release_rate, 'Release rate', this.autoreceptors_rate, 'Autoreceptors', 'R(t) and A(t)');
this.graph_input_arrays(alpha_graph_div, this.alpha, 'Alpha', this.beta, 'Beta', 'Alpha and Beta');
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

generate_modelled_concentration(Rt, At, alpha, vmax1, km1, beta, vmax2, km2){
var s = [0, 0];
for(var i=1;i<Rt.length-1;++i){
s[i+1] = s[i-1] + (2/this.frequency)*(Rt[i]*(1-At[i]/100) - (alpha[i]/100)*(vmax1*s[i])/(km1+s[i]) - (beta[i]/100)*(vmax2*s[i])/(km2+s[i]));
}
return s;
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
Plotly.newPlot(div, [experimental_trace, modelled_trace], layout, this.plot_settings.plot_configuration);
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

Plotly.newPlot(div, [trace_1, trace_2], layout, this.plot_settings.plot_configuration);
};






initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};



}
