// Class for uploaded FSCAV data.
function HL_FSCAV_DATA(data, neurotransmitter, v_units, c_units, frequency) {
this.frequency = frequency;
this.rawdata = data;
this.neurotransmitter = neurotransmitter;
this.number_of_signals = data[0].length-1;
this.number_of_points = data.length-1;
// Create voltage features.
this.voltage = new HL_FSCAV_VOLTAGE(data, v_units);
// Create current features.
this.current = new HL_FSCAV_CURRENT(data, c_units, this.number_of_signals);
//Create time features.
this.time = new HL_FSCAV_TIME(data, frequency);
// Shoulder extremes and max point: first local maximum and first and second local minimums.
this.max_index = uniform_array(this.number_of_signals, 0);
this.min_index = uniform_array(this.number_of_signals, [0, 0]);
this.max_value = uniform_array(this.number_of_signals, 0);
this.auc = uniform_array(this.number_of_signals, 0);
for (i = 0; i < this.number_of_signals; ++i){
[this.max_index[i], this.max_value[i]] = localmaxima(this.current.array[i])[0];
this.min_index[i] = localminima(this.current.array[i])[0].slice(0,2);
this.auc[i] = trap_auc(this.current.array[i].slice(this.min_index[i][0], this.min_index[i][1]+1), frequency);
};

this.plot_current_time = function(div, index){
// Define plotly objects for line and scatter points.
let graph_data = [{
y: this.current.array[index],
x: this.time.array,
line: {
shape: 'spline',
color: 'blue'
},
showlegend: false,
name: this.current.name
}];

let scatter_data_max = {
y:[this.current.array[index][this.max_index[index]]],
x:[this.time.array[this.max_index[index]]],
name: 'Points',
type: 'scatter',
showlegend: false,
mode: 'markers',
marker: {color: 'black'},
text:'Points'
};

let scatter_data_min = {
y:[this.current.array[index][this.min_index[index][0]],
this.current.array[index][this.min_index[index][1]]],
x:[this.time.array[this.min_index[index][0]],
this.time.array[this.min_index[index][1]]],
name: 'Points',
type: 'scatter',
showlegend: false,
mode: 'markers+lines',
line: {color: 'black', width:0.5, dash: 'dot'},
marker: {color: 'black'},
text:'Points'
};

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
Plotly.addTraces(div, scatter_data_max);
Plotly.addTraces(div, scatter_data_min);
// Assign callback when click to local function graph_click();
document.getElementById(div).on('plotly_click', function(data){graph_clicked(data)});
};
//Change of minimum and maximum points by points clicked in the graph.
this.change_points = function(index, pindex, type){
if(type == "min1"){
this.min_index[index][0] = pindex;
} else if(type == "min2"){
this.min_index[index][1] = pindex;
} else {
this.max_index[index] = pindex;
}};
// Recalculation of AUC and max values.
this.recalculate_auc_and_max = function(){
for (i = 0; i < this.number_of_signals; ++i){
this.max_value[i] = this.current.array[i][this.max_index[i]];
this.auc[i] = trap_auc(this.current.array[i].slice(this.min_index[i][0], this.min_index[i][1]+1), frequency);
};
};
this.get_concentration = function(){};
this.plot_concentration = function(){};

};

// Class for Voltage data within FSCAV.
function HL_FSCAV_VOLTAGE(data, v_units) {
this.units =  v_units;
this.name = data[0][0];
this.array = arrayColumn(data, 0).slice(1);
}
// Class for Current data within FSCAV.
function HL_FSCAV_CURRENT(data, c_units, number_of_signals) {
this.units =  c_units;
this.name = 'Current';
this.tags = data[0].slice(1);
this.array = transpose(data.slice(1).map(x => x.slice(1)));
};
// Class for time data within FSCAV.
function HL_FSCAV_TIME(data, frequency) {
this.units = 's';
this.name = 'Time';
this.array = makeArr(0,(data.length-1)/frequency, data.length-1);
}
