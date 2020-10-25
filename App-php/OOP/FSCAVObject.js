// Class for uploaded FSCAV data.
function FSCAV_DATA(data, neurotransmitter, v_units, c_units, frequency) {
this.frequency = frequency;
this.rawdata = data;
this.neurotransmitter = neurotransmitter;
this.number_of_signals = data[0].length-1;
this.number_of_points = data.length-1;
// Create voltage features.
this.voltage = new FSCAV_VOLTAGE(data, neurotransmitter, v_units, c_units, frequency);
// Create current features.
this.current = new FSCAV_CURRENT(data, neurotransmitter, v_units, c_units, frequency);
//Create time features.
this.time = new FSCAV_TIME(data, neurotransmitter, v_units, c_units, frequency);
this.plot_current_time = function(div, index){
// Define plotly objects.
let graph_data=[{
y: this.current.array[index],
x: this.time.array,
line: {
shape: 'spline',
color: 'blue'
},
name: this.current.name[index]
}];

let layout = {
autosize: true,
legend: {"orientation": "h"},
xaxis:{
title: this.time.name+' ('+this.time.units+')'
},
yaxis:{
title: this.current.name+' ('+this.current.units+')'
}
};
layout.title = {
text: 'Cyclic Voltammogram of '+this.current.tags[index],
font: {
size: 20,
family:'Arial'
},
x: 0.5,
y: 1.2,
xanchor: 'center',
yanchor: 'top',
};

let config = {
showEditInChartStudio: true,
responsive: true,
plotlyServerURL: "https://chart-studio.plotly.com",
displayModeBar: true,
displaylogo: false,
dragmode:'select',
modeBarButtonsToRemove: ['hoverCompareCartesian'],
toImageButtonOptions: {
format: 'svg',
filename: 'plot',
height: 600,
width: 750,
scale: 1
}};
// Plot FSCAV data.
Plotly.newPlot(div, graph_data, layout, config);
}
};
// Class for Voltage data within FSCAV.
function FSCAV_VOLTAGE(data, neurotransmitter, v_units, c_units, frequency) {
this.units =  v_units;
this.name = data[0][0];
this.array = arrayColumn(data, 0).slice(1);
}
// Class for Current data within FSCAV.
function FSCAV_CURRENT(data, neurotransmitter, v_units, c_units, frequency) {
this.units =  c_units;
this.name = 'Current';
this.tags = data[0].slice(1);
this.array = transpose(data.slice(1).map(x => x.slice(1)));
}
// Class for time data within FSCAV.
function FSCAV_TIME(data, neurotransmitter, v_units, c_units, frequency) {
this.units = 's';
this.name = 'Time';
this.array = makeArr(0,(data.length-1)/frequency, data.length-1);
}
