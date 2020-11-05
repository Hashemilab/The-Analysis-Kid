// Class for uploaded FSCV Data.
function HL_FSCV_DATA(data, c_units, frequency, cycling_frequency, name_of_file, plot_type, color_palette){
// global variable to be accessed in callbacks.
var self = this;
//FSCV data properties.
this.frequency = frequency;
this.cycling_frequency = cycling_frequency;
this.name_of_file = name_of_file;
this.current = new HL_FSCV_ARRAY(data, c_units, 'Current');
this.cycling_time = new HL_FSCV_TIME(cycling_frequency, data[0].length, 's', 'Time');
this.time = new HL_FSCV_TIME(frequency, data.length, 's', 'Time');

//Plotting properties.
this.plot_type = plot_type;
this.palettes = new HL_FSCV_COLORPALETTE();
if (color_palette == 'Custom'){color_palette = this.palettes.custom};
this.color_palette = color_palette;
this.plot_settings = new HL_PLOT_SETTINGS();


// Methods of the data.
this.graph_color_plot = function(div){
//Function to plot the main color plot.
var graph_data = [{
z:this.current.array,
x:this.cycling_time.array,
y:this.time.array,
type:this.plot_type,
colorscale:this.color_palette,
colorbar: {len:0.5, xpad:30, title:this.current.name+'('+this.current.units+')'}
}];

var layout = this.plot_settings.plot_layout;
layout.title.text = "<b>"+this.name_of_file+"</b>";
if (this.plot_type == 'surface'){
layout.scene = {
xaxis:{
title: this.cycling_time.name+' ('+this.cycling_time.units+')',
gridcolor: 'rgb(255, 255, 255)',
zerolinecolor: 'rgb(255, 255, 255)',
showbackground: true,
showgrid:true,
backgroundcolor:'rgb(230, 230,230)',
},
yaxis: {
title: this.time.name+' ('+this.time.units+')',
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
layout.xaxis = {
title:this.cycling_time.name+' ('+this.cycling_time.units+')'
};
layout.yaxis = {
title:this.time.name+' ('+this.time.units+')'
};
};

Plotly.newPlot(div, graph_data, layout, this.plot_settings.plot_configuration);
_(div).on('plotly_click', function(data){main_graph_clicked(data)});
};

this.change_color_palette = function(new_color_palette, div){
if (new_color_palette == 'Custom'){this.color_palette = this.palettes.custom}
else {this.color_palette = new_color_palette;}
this.graph_color_plot(div);
};

this.change_type_of_plot = function(new_plot_type, div){
this.plot_type = new_plot_type;
this.graph_color_plot(div);
};

this.invert_current_values = function(div){
this.current.array = this.current.array.map(arr => arr.map(x => -x));
this.graph_color_plot(div);
};

this.initialise_graph = function(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};


};

// Class for 1D Transient and iV plots.
function HL_FSCV_1D_DATA(c_units, frequency, type){
//Data properties.
this.current = new HL_FSCV_ARRAY([], c_units, 'Current');
this.time = new HL_FSCV_ARRAY([], 's', 'Time');
this.legend_array = [];
this.origin_file_array = [];
this.type = type;
this.counter = 0;
//Plotting properties.
this.plot_settings = new HL_PLOT_SETTINGS();
//Methods.
this.add_trace = function(array, frequency, div, origin_file){
this.current.array.push(array);
this.time.array.push(makeArr(0,(array.length-1)/frequency, array.length-1));
this.legend_array.push("("+String(this.counter+1)+")");
this.origin_file_array.push(origin_file);
this.plot_trace(type, div);
};
this.remove_trace = function(div){
if (this.counter != 0){
this.current.array.pop();
this.time.array.pop();
this.legend_array.pop();
this.origin_file_array.pop();
this.delete_trace(div);
this.counter--;
};
};

this.plot_trace = function(type, div){
var layout = this.plot_settings.plot_layout;
layout.xaxis.title = this.time.name +" ("+this.time.units+")";
layout.yaxis.title = this.current.name +" ("+this.current.units+")";
layout.title.text = "<b>"+this.type+"</b>";
Plotly.relayout(div, layout);
Plotly.addTraces(div, [{y: this.current.array[this.counter], x:this.time.array[this.counter],
name:"("+String(this.counter+1)+")", text:this.origin_file_array[this.counter]}]);
this.counter++;
};

this.delete_trace = function(div){
Plotly.deleteTraces(div, -1);
}

this.initialise_graph = function(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};
};


function HL_FSCV_ARRAY(data, units, name){
this.units = units;
this.name = name;
this.array = data;
};

function HL_FSCV_TIME(frequency, length, units, name){
this.units = units;
this.name = name;
this.array = makeArr(0,(length-1)/frequency, length-1);
};

function HL_FSCV_COLORPALETTE(){
this.custom =  [[0.0, 'rgb(0, 0, 240)'],[0.2478, 'rgb(0, 2, 39)'], [0.3805, 'rgb(245, 213, 1)'],[0.65555, 'rgb(168, 98, 0)'],
[0.701, 'rgb(76, 2, 69)'],[0.7603, 'rgb(0, 182, 136)'],[0.7779, 'rgb(0, 138, 30)'], [1.0, 'rgb(1, 248, 1)']];
};
// Class that integrates plot settings used accross the plots.
function HL_PLOT_SETTINGS(){

this.plot_configuration = {
showEditInChartStudio: true,
plotlyServerURL: "https://chart-studio.plotly.com",
displayModeBar: true,
displaylogo: false,
responsive: true,
toImageButtonOptions: {
format: 'svg',
filename: 'plot',
height: 600,
width: 800,
scale: 1
}};

this.plot_layout = {
autosize: true,
title: {
text: '<b> Blank </b>',
font: {
size: 20,
family:'Arial'
},
x: 0.05,
y: 1.2,
xanchor: 'left',
yanchor: 'bottom',
},
};
};
