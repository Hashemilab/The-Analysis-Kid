// Class for uploaded FSCAV data.
class HL_FSCAV_DATA{
constructor(data, names_of_files, frequency, units, v_units, neurotransmitter, peak_width){
this.frequency = frequency;
this.origin_file_array = names_of_files;
this.neurotransmitter = neurotransmitter;
//Provisional
this.current = new HL_FSCV_ARRAY(data.map(x => arrayColumn(x, 2)), units, 'Current');
this.voltage = new HL_FSCV_ARRAY(data.map(x => arrayColumn(x, 1)), v_units, 'Voltage');
this.time = new HL_FSCV_ARRAY(data.map(x => makeArr(0,(x.length-1)/frequency, x.length)), 's', 'Time');
this.max_indexes = [];
this.max_values = [];
this.min_indexes = [];
this.min_values = [];
this.auc = [];
this.graph_index = 0;
this.number_of_files = this.current.array.length;
this.local_neighbours = peak_width;
for(var i=0;i<this.current.array.length; ++i){this.get_max_and_min_values(i); this.get_auc(i)};
this.plot_settings = new HL_PLOT_SETTINGS();
this.cv_plot_state = 'block';
this.concentration_plot_state = 'none';
};



get_max_and_min_values(index){
[this.max_indexes[index], this.max_values[index]] = local_maxima(this.current.array[index], this.local_neighbours);
[this.min_indexes[index], this.min_values[index]] = local_minima(this.current.array[index], this.local_neighbours);
};

get_auc(index){
this.auc[index] = simpson_auc(this.current.array[index].slice(this.min_indexes[index][0], this.min_indexes[index][1]), this.frequency);
};

change_points(pindex, type){
if(type == "min1"){this.min_indexes[this.graph_index][0] = pindex; this.min_values[this.graph_index][0] = this.current.array[this.graph_index][pindex]}
else if(type == "min2"){this.min_indexes[this.graph_index][1] = pindex; this.min_values[this.graph_index][1] = this.current.array[this.graph_index][pindex]}
else {this.max_indexes[this.graph_index][0] = pindex; this.max_values[this.graph_index][0] = this.current.array[this.graph_index][pindex]};
// Recalculate auc
this.get_auc(this.graph_index);

};


initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};

invert_current_values(div){
this.current.array[this.graph_index] = this.current.array[this.graph_index].map(x => -x);
this.plot_graph(div);
};

plot_graph(div){

var layout = this.plot_settings.plot_layout;
layout.title.text = "<b>"+this.origin_file_array[this.graph_index]+"</b>";
layout.xaxis = {title:this.time.name +" ("+this.time.units+")"};
layout.yaxis = {title:this.current.name +" ("+this.current.units+")"};

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

Plotly.newPlot(div, [trace], layout, this.plot_settings.plot_configuration);
Plotly.addTraces(div, [scatter_data_max, scatter_data_min]);
// Assign callback when click to local function graph_click();
_(div).on('plotly_click', function(data){graph_clicked(data)});
};

plot_predicted_concentration(){

};


}
