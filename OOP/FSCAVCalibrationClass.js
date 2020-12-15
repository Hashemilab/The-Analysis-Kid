// Class for uploaded FSCAV data.
class HL_FSCAV_DATA{
constructor(frequency, units, peak_width){
this.frequency = frequency;
this.origin_file_array = [];

//Provisional
this.current = new HL_FSCV_ARRAY([], units, 'Current');
this.time = new HL_FSCV_ARRAY([], 's', 'Time');
this.concentration_labels = [];
this.max_indexes = [];
this.max_values = [];
this.min_indexes = [];
this.min_values = [];
this.total_auc = [];
this.line_auc = [];
this.auc =[];
this.graph_index = 0;
this.number_of_files = 0;
this.local_neighbours = peak_width;

this.plot_settings = new HL_PLOT_SETTINGS();
this.cv_plot_state = 'block';
this.concentration_plot_state = 'none';
};

read_data_from_loaded_files(data, names_of_files, concentration_label){
this.current.array.push(data.map(x => arrayColumn(x, 2)));
this.time.array.push(data.map(x => makeArr(0,(x.length-1)/frequency, x.length)));
this.origin_file_array.push(names_of_files);
this.number_of_files+=data.length;
this.concentration_labels.push(uniform_array(data.length, concentration_label));
};

linearise_data_arrays(){
this.current.array = linearise(this.current.array, 1);
this.time.array = linearise(this.time_array, 1);
this.origin_file_array = linearise(this.origin_file_array, 1);
this.concentration_labels = linearise(this.concentration_labels, 1);
};

data_loading_finished(){
this.linearise_data_arrays();
for(var i=0;i<this.current.array.length; ++i){this.get_max_and_min_values(i); this.get_auc(i)};
};

get_max_and_min_values(index){
[this.max_indexes[index], this.max_values[index]] = local_maxima(this.current.array[index], this.local_neighbours);
[this.min_indexes[index], this.min_values[index]] = local_minima(this.current.array[index], this.local_neighbours);
};

get_auc(index){
this.total_auc[index] = simpson_auc(this.current.array[index].slice(this.min_indexes[index][0], this.min_indexes[index][1]), this.frequency);
var linear_parameters = linear_fit([this.time.array[index][this.min_indexes[index][0]], this.time.array[index][this.min_indexes[index][1]]],
[this.current.array[index][this.min_indexes[index][0]], this.current.array[index][this.min_indexes[index][1]]]);
var line = this.time.array[index].slice(this.min_indexes[index][0], this.min_indexes[index][1]).map(x => linear_parameters[0]+linear_parameters[1]*x);
this.line_auc[index] = simpson_auc(line,this.frequency);
this.auc[index] = this.total_auc[index] - this.line_auc[index];
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
