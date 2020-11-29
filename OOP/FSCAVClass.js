// Class for uploaded FSCAV data.
class HL_FSCAV_DATA{
constructor(data, frequency, name, units, neurotransmitter){
this.frequency;
this.name_of_file;
this.neurotransmitter;
this.current = new HL_FSCV_ARRAY(data, units, 'Current');
this.time = new HL_FSCV_TIME(frequency, data.length, 's', 'Time');
this.plot_settings = new HL_PLOT_SETTINGS();
this.cv_plot_state = 'block';
this.concentration_plot_state = 'none';
};



initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};

invert_current_values(div){
this.current.array = this.current.array.map(x => -x);
this.plot_graph(div);
};

plot_graph(div){

var trace = {
y: this.current.array[this.graph_index],
x:this.time.array[this.graph_index],
text:this.origin_file_array[this.graph_index],
showlegend: false,
line:{color: this.color_array[this.graph_index]},
};

Plotly.newPlot(div, [trace], layout);
};

plot_predicted_concentration(){

};


}
