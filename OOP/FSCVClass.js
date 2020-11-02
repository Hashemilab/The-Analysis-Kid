// Class for uploaded FSCV Data.
function HL_FSCV_DATA(data, c_units, frequency, cycling_frequency, name_of_file, plot_type, color_palette){
// global variable to be accessed in callbacks.
var self = this;
//FSCV data properties.
this.frequency = frequency;
this.cycling_frequency = cycling_frequency;
this.name_of_file = name_of_file;
this.current = new HL_FSCV_CURRENT(data, c_units, 'Current');
this.cycling_time = new HL_FSCV_TIME(cycling_frequency, data[0].length, 's', 'Time');
this.time = new HL_FSCV_TIME(frequency, data.length, 's', 'Time');
// FSCV transient (1D signals) properties.
this.transient = new HL_FSCV_CURRENT([], c_units, 'Current');
this.iv = new HL_FSCV_CURRENT([], c_units, 'Current');
this.transient_counter = 0;
//Plotting properties.
this.plot_type = plot_type;
this.palettes = new HL_FSCV_COLORPALETTE();
if (color_palette == 'Custom'){color_palette = this.palettes.custom};
this.color_palette = color_palette;

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

var layout = {
autosize: true
};
layout.title = {
text: '<b>'+this.name_of_file+'</b>',
font: {
size: 20,
family:'Arial'
},
x: 0,
y: 1.2,
xanchor: 'left',
yanchor: 'bottom',
};

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

var config = {
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
}}
Plotly.newPlot(div, graph_data, layout, config);
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

this.add_transient = function(type, pindex, div_transient, div_iv){
this.transient.array.push(this.current.array[pindex[0]]);
this.iv.array.push(arrayColumn(this.current.array, pindex[1]));
this.plot_1D_signal(div_transient, this.transient, this.time, this.transient_counter);
this.plot_1D_signal(div_iv, this.iv, this.cycling_time, this.transient_counter);
++this.transient_counter;
};


this.plot_1D_signal = function(div, signal, time_signal, index){
//
// let graph_data = [{
// y:signal.array[index],
// x:time_signal.array,
// line: {
// shape: 'spline',
// },
// showlegend: false,
// name: this.current.name
// }];
//
// let scatter_data_max = {
// y:[this.current.array[index][this.max_index[index]]],
// x:[this.time.array[this.max_index[index]]],
// name: 'Points',
// type: 'scatter',
// showlegend: false,
// mode: 'markers',
// marker: {color: 'black'},
// text:'Points'
// };
//
// let scatter_data_min = {
// y:[this.current.array[index][this.min_index[index][0]],
// this.current.array[index][this.min_index[index][1]]],
// x:[this.time.array[this.min_index[index][0]],
// this.time.array[this.min_index[index][1]]],
// name: 'Points',
// type: 'scatter',
// showlegend: false,
// mode: 'markers+lines',
// line: {color: 'black', width:0.5, dash: 'dot'},
// marker: {color: 'black'},
// text:'Points'
// };
//
// let layout = {
// autosize: true,
// legend: {"orientation": "h"},
// xaxis:{
// title: this.time.name+' ('+this.time.units+')'
// },
// yaxis:{
// title: this.current.name+' ('+this.current.units+')'
// }
// };
//
// layout.title = {
// text: 'Cyclic Voltammogram of '+this.current.tags[index],
// font: {
// size: 20,
// family:'Arial'
// },
// x: 0.5,
// y: 1.2,
// xanchor: 'center',
// yanchor: 'top',
// };
//
// let config = {
// showEditInChartStudio: true,
// responsive: true,
// plotlyServerURL: "https://chart-studio.plotly.com",
// displayModeBar: true,
// displaylogo: false,
// dragmode:'select',
// modeBarButtonsToRemove: ['hoverCompareCartesian'],
// toImageButtonOptions: {
// format: 'svg',
// filename: 'plot',
// height: 600,
// width: 750,
// scale: 1
// }};
// // Plot FSCAV data.
// Plotly.newPlot(div, graph_data, layout, config);
// Plotly.addTraces(div, scatter_data_max);
// Plotly.addTraces(div, scatter_data_min);
// // Assign callback when click to local function graph_click();
// _(div).on('plotly_click', function(data){graph_clicked(data)});


};

};


function HL_FSCV_CURRENT(data, units, name){
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
