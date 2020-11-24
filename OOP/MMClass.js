class HL_MICHAELIS_MENTEN{
constructor(){
this.plot_settings = new HL_PLOT_SETTINGS();
this.average_concentration = new HL_FSCV_ARRAY([],[], 'Concentration');
this.modelled_concentration = new HL_FSCV_ARRAY([],[], 'Concentration');
this.release_rate = new HL_FSCV_ARRAY([],[], 'Release rate');
this.autoreceptors_rate = new HL_FSCV_ARRAY([],[], 'Autoreceptors rate');
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
this.release_rate_slider_values = [0];
this.autoreceptors_slider_values = [0];

};

add_data_to_application(div, fscv_concentration, release_graph_div, release_div, autoreceptors_div, release_type, autoreceptors_type, parameters, release_list_div, autoreceptors_list_div){
this.assign_concentration_trace(fscv_concentration);
this.initialise_sliders(release_div, release_type, autoreceptors_div, autoreceptors_type);
this.input_values_changed(div, release_graph_div, release_div, autoreceptors_div, release_type, autoreceptors_type, parameters, release_list_div, autoreceptors_list_div);
};

assign_concentration_trace(fscv_concentration){
this.average_concentration = fscv_concentration.average_concentration;
this.time.array = fscv_concentration.time.array[0]; //Assumption of all time arrays being the same.
};

initialise_sliders(release_div, autoreceptors_div, release_type, autoreceptors_type){
this.frequency = parseInt(1/(this.time.array[2] - this.time.array[1]));
this.autoreceptors_slider.range.max = this.time.array.length/this.frequency;
this.autoreceptors_slider.start[0] = (this.time.array.length/this.frequency)/2;
this.release_rate_slider.range.max = this.time.array.length/this.frequency;
this.release_rate_slider.start[0] = (this.time.array.length/this.frequency)/2;
this.reset_slider(release_div, release_type); this.reset_slider(autoreceptors_div, autoreceptors_type);
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

input_values_changed(concentration_graph_div, release_graph_div, release_div, autoreceptors_div, release_type, autoreceptors_type, parameters, release_list_div, autoreceptors_list_div){
this.assign_slider_values(release_div, release_type);
this.assign_slider_values(autoreceptors_div, autoreceptors_type);
this.parameters = parameters;
this.get_input_values(release_list_div, release_type); this.get_input_values(autoreceptors_list_div, autoreceptors_type);
this.release_rate.array = this.generate_input_arrays(release_type, this.average_concentration.array.length);
this.release_rate.units = this.average_concentration.units+'/s';
this.autoreceptors_rate.array = this.generate_input_arrays(autoreceptors_type, this.average_concentration.array.length);
this.autoreceptors_rate.units = '%';
this.modelled_concentration.array = this.generate_modelled_concentration(this.release_rate.array, this.autoreceptors_rate.array, this.parameters[0],
this.parameters[1], this.parameters[2], this.parameters[3], this.parameters[4], this.parameters[5]);
this.graph_input_arrays(release_graph_div);
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
s[i+1] = s[i-1] + (2/this.frequency)*(Rt[i]*(1-At[i]) - alpha*(vmax1*s[i])/km1+s[i]) - beta*(vmax2*s[i])/(km2+s[i]));
}
return y;
};

optimisation_of_parameters(){



function diff_fun(Rt, At, alpha, vmax1, km1, beta, vmax2, km2){

}

}



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

graph_input_arrays(div){

var release_rate_trace = {
x: this.time.array,
y: this.release_rate.array,
name: 'Release rate',
showlegend: false
};

var autoreceptors_rate = {
x: this.time.array,
y: this.autoreceptors_rate.array,
name: 'Autoreceptors',
yaxis: 'y2',
showlegend: false
};


var layout = {
title:  {
text: '<b> Input Functions </b>',
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
yaxis: {title: this.release_rate.name+" ("+this.release_rate.units+")"},
yaxis2: {
title: this.autoreceptors_rate.name+" ("+this.autoreceptors_rate.units+")",
overlaying: 'y',
side: 'right'
},
autosize: true,
};

Plotly.newPlot(div, [release_rate_trace, autoreceptors_rate], layout, this.plot_settings.plot_configuration);
};






initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};



}
