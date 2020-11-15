// Class with static methods to filter FSCV data.
class HL_FILTERING {
constructor(c_units) {
this.plot_settings = new HL_PLOT_SETTINGS();
this.wrapped_data = new HL_FSCV_ARRAY([], c_units, 'Mirrored FSCV Data');
this.wrapped_width;
this.wrapped_height;
this.spectrum_layout;
this.spectrum_magnitude = new HL_FSCV_ARRAY([], 'dB'+c_units, 'Magnitude');
this.spectrum_magnitude_linear = new HL_FSCV_ARRAY([], 'dB'+c_units, 'Linear Magnitude');
this.spectrum_real_linear = new HL_FSCV_ARRAY([], 'dB'+c_units, 'Linear Real Part');
this.spectrum_imaginary_linear = new HL_FSCV_ARRAY([], 'dB'+c_units, 'Linear Imaginary Part');
this.spectrum_output = new HL_FSCV_ARRAY([], 'dB'+c_units, 'Raw Complex FT');
this.frequency_x = new HL_FSCV_ARRAY([], 'Hz', 'Frequency');
this.frequency_y = new HL_FSCV_ARRAY([], 'Hz', 'Frequency');
};

apply_convolution(fscv_data, std, reps){
var data = fscv_data.current.array;
var linear_input = flatten(data);
var linear_output = uniform_array(linear_input.length, 0);
for (var i = 0; i<reps; ++i){
conv_2d_gaussian(linear_input, linear_output, data[0].length, data.length, std);
fscv_data.current.array = split_array(linear_output, data[0].length);
linear_input = linear_output;
};
};

get_2dfft(fscv_data, div, frequency, cycling_frequency){
if (this.spectrum_output.array.length == 0){this.wrap_and_get_spectrum(frequency, cycling_frequency)};
this.spectrum_magnitude_linear.array = this.get_magnitude_array();
this.spectrum_magnitude.array = this.get_matrix(this.spectrum_magnitude_linear.array, this.wrapped_height, this.wrapped_width);
this.graph_spectrum(div);
};

apply_2dfft_filtration(fscv_data, div, frequency, cycling_frequency, cutoffx, cutoffy, order){
if (this.spectrum_output.array.length == 0){this.wrap_and_get_spectrum(frequency, cycling_frequency)};
cutoffx = this.get_absolute_frequency(cutoffx, this.frequency_x.array);
cutoffy = this.get_absolute_frequency(cutoffy, this.frequency_y.array);
var filter = this.butter_2d_uncentered(this.wrapped_width, this.wrapped_height, frequency, cycling_frequency, cutoffx, cutoffy, order);
filter = flatten(filter);
this.spectrum_real_linear.array = had_product_1d(filter, this.spectrum_real_linear.array);
this.spectrum_imaginary_linear.array = had_product_1d(filter, this.spectrum_imaginary_linear.array);
this.spectrum_output.array = this.get_zipped_complex_array(this.spectrum_real_linear.array, this.spectrum_imaginary_linear.array);
var linear_output = irfft2d(this.spectrum_output.array, this.wrapped_width, this.wrapped_height);
fscv_data.current.array = this.get_unwrapped_data(split_array(Array.from(linear_output), this.wrapped_width));
};

wrap_and_get_spectrum(frequency, cycling_frequency){
this.wrapped_data.array = this.get_wrapped_data(fscv_data.current.array);
this.wrapped_width = fscv_data.current.array[0].length + fscv_data.current.array[0].length/3;
this.wrapped_height = fscv_data.current.array.length;
this.get_spectrum_arrays(frequency, cycling_frequency);
this.get_unzipped_complex_array(this.spectrum_output.array);
};

get_spectrum_arrays(frequency, cycling_frequency){
var linear_input = new Float32Array(flatten(this.wrapped_data.array));
this.frequency_x.array = this.get_frequency_array(this.wrapped_width, cycling_frequency);
this.frequency_y.array = this.get_frequency_array(this.wrapped_height, frequency);
this.spectrum_output.array = rfft2d(linear_input, this.wrapped_width, this.wrapped_height);
};

graph_spectrum(div){
var graph_data = [{
z:this.spectrum_magnitude.array,
x:this.frequency_x.array,
y:this.frequency_y.array,
type:'heatmap',
colorscale:'Greys',
colorbar: {title:this.spectrum_magnitude.units},
}];
this.spectrum_layout = this.plot_settings.plot_layout;
this.spectrum_layout.title.text = "<b>2D FFT Magnitude Spectrum</b>";
this.spectrum_layout.xaxis = {
title:this.frequency_x.name+' ('+this.frequency_x.units+')'
};
this.spectrum_layout.yaxis = {
title:this.frequency_y.name+' ('+this.frequency_y.units+')'
};
Plotly.newPlot(div, graph_data, this.spectrum_layout, this.plot_settings.plot_configuration);
}

get_frequency_array(length, frequency){
var array = [];
var half_FOV = parseInt(length/2);
for(var i = -half_FOV; i<half_FOV;++i){array.push(i*(1/((length)/frequency)))};
return array;
};

get_magnitude_array(){
// get magnitude array for plotting.
var real_array = this.spectrum_real_linear.array;
var im_array = this.spectrum_imaginary_linear.array;
var magnitude_array = uniform_array(real_array.length, 0);
for (var i=0;i<real_array.length;++i) {
magnitude_array[i] = Math.log(1 + Math.sqrt(real_array[i] * real_array[i] + im_array[i] * im_array[i]));
}
return magnitude_array;
};

get_unzipped_complex_array(complex_array){
var arrs = get_even_and_odd_indexes(complex_array); this.spectrum_real_linear.array = arrs[0]; this.spectrum_imaginary_linear.array = arrs[1];
};
get_zipped_complex_array(real_array, imaginary_array){
return new Float32Array(zip(real_array, imaginary_array));
};

get_matrix(array, height, width){
var calculated_array = array.slice(0, height * (width/2 + 1));
//KissFFT returns only width/2 + 1 of the rows.
var top_right = calculated_array.slice(0, (height/2)*(width/2 + 1));
var bottom_right = calculated_array.slice((height/2)*(width/2 + 1));
var bottom_left = reverse_array(top_right);
var top_left = reverse_array(bottom_right);
var tmp1 = [], tmp2 = [], linear_spectrum = [];
for (var i=0; i<(height/2)*(width/2 + 1); i+=width/2 + 1){
tmp1.push(bottom_left.slice(i, i+width/2)); tmp1.push(bottom_right.slice(i, i+width/2));
tmp2.push(top_left.slice(i, i+width/2)); tmp2.push(top_right.slice(i, i+width/2));
};
return split_array(flatten([tmp1, tmp2]), width);
};

get_absolute_frequency(cutoff, frequency_array){
return (cutoff/100)*frequency_array[frequency_array.length - 1];
};

get_wrapped_data(data){
var wrapped_data = deep_copy_2d_array(data), n_padding = parseInt(data[0].length/6);
for (var i=0;i<data.length;++i){
wrapped_data[i].push(reverse_array(wrapped_data[i].slice(wrapped_data[i].length - n_padding)));
wrapped_data[i].unshift(reverse_array(wrapped_data[i].slice(0, n_padding)));
};
return wrapped_data;
};

get_unwrapped_data(data){
var n_padding = parseInt(data[0].length/8);
for (var i=0;i<data.length;++i){data[i] = data[i].slice(n_padding, data[i].length - n_padding)};
return data;
};

initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
};

// Butterworth filter implementation form http://fourier.eng.hmc.edu/e101/lectures/Fourier_Analysis/node10.html
butter_2d(width, length, frequency, cycling_frequency, cutoffx, cutoffy, order){
var d, i, j, fx = this.frequency_x.array, fy = this.frequency_y.array;
var b_2d = uniform_array(length, uniform_array(width, 0));
for (i = 0;i<length;++i){for (j = 0;j<width;++j){
d = Math.pow((Math.pow((fy[i])/cutoffy,2) + Math.pow((fx[j])/cutoffx, 2)), 0.5);
b_2d[i][j] = 1/(1 + Math.pow((d), 2*order));
}};
return b_2d;
};
// Same Butterworth filter but rearranged to be applied to the spectrum comming from Kiss FFT.
butter_2d_uncentered(width, length, frequency, cycling_frequency, cutoffx, cutoffy, order){
var d, i, j, fi, fx = this.frequency_x.array, fy = this.frequency_y.array, half_length = parseInt(length/2), half_width = parseInt(width/2);
var b_2d = uniform_array(length, uniform_array(half_width + 1, 0));
for (i = 0;i<length;++i){for (j = 0;j<width/2;++j){
if(i<length/2){fi = fy[i+half_length]}
else{fi = fy[i-half_length]};
d = Math.pow((Math.pow((fi)/cutoffy,2) + Math.pow((fx[j+half_width])/cutoffx, 2)), 0.5);
b_2d[i][j] = 1/(1 + Math.pow((Math.pow((Math.pow((fi)/cutoffy,2) + Math.pow((fx[j+half_width])/cutoffx, 2)), 0.5)), 2*order));
}};
b_2d.push(uniform_array(length*(width/2 - 1), 0)); //fill with zeros for the parts that have not been calculated.
return b_2d;
};

graph_filter(div, cutoffx, cutoffy){
cutoffx = this.get_absolute_frequency(cutoffx, this.frequency_x.array);
cutoffy = this.get_absolute_frequency(cutoffy, this.frequency_y.array);
this.spectrum_layout.shapes = [{
opacity: 0.3,
xref: 'x',
yref: 'y',
fillcolor: 'red',
x0: - cutoffx,
y0: -cutoffy,
x1: cutoffx,
y1: cutoffy,
type: 'circle',
line: {
color: 'red'
}
}];
Plotly.relayout(div, this.spectrum_layout);
};

};
