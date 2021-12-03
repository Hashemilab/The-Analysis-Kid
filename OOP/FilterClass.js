// Class with static methods to filter FSCV data.
class HL_FILTERING {
constructor(c_units) {
this.plot_settings = new HL_PLOT_SETTINGS();
this.wrapped_data = new HL_FSCV_ARRAY([], c_units, 'Mirrored FSCV Data');
this.width;
this.height;
this.wrapped_width;
this.wrapped_height;
this.width_even = true;
this.height_even = true;
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
let data = fscv_data.current.array, linear_input = flatten(data), linear_output = new Array(linear_input.length);
for (var i = 0; i<reps; ++i){
conv_2d_gaussian(linear_input, linear_output, data[0].length, data.length, std); linear_input = linear_output;
};
fscv_data.current.array = split_array(linear_output, data[0].length);
};

get_2dfft(fscv_data, div, frequency, cycling_frequency, height_padding, width_padding){
this.width = fscv_data.current.array[0].length; this.height = fscv_data.current.array.length; this.get_data_even(fscv_data);
if (this.spectrum_output.array.length == 0){this.get_spectrum_arrays(fscv_data, frequency, cycling_frequency, height_padding, width_padding)};
[this.spectrum_magnitude_linear.array, this.spectrum_magnitude.array] = this.magnitude_array(this.spectrum_real_linear.array, this.spectrum_imaginary_linear.array, this.wrapped_width, this.wrapped_height);
this.spectrum_magnitude.array = array_to_2d(this.spectrum_magnitude.array, this.wrapped_height, this.wrapped_width);
this.graph_spectrum(div);
this.restore_data(fscv_data);
};

apply_2dfft_filtration(fscv_data, div, frequency, cycling_frequency, cutoffx, cutoffy, order, height_padding, width_padding, type){
this.width = fscv_data.current.array[0].length; this.height = fscv_data.current.array.length; this.get_data_even(fscv_data);
if (this.spectrum_output.array.length == 0){this.get_spectrum_arrays(fscv_data, frequency, cycling_frequency, height_padding, width_padding)};
cutoffx = this.get_absolute_frequency(cutoffx, this.frequency_x.array);
cutoffy = this.get_absolute_frequency(cutoffy, this.frequency_y.array);
[this.spectrum_real_linear.array,  this.spectrum_imaginary_linear.array, this.spectrum_output.array] = this.butter_2d_filter(this.wrapped_width,
this.wrapped_height, this.frequency_y.array, this.frequency_x.array, this.spectrum_real_linear.array,  this.spectrum_imaginary_linear.array,
frequency, cycling_frequency, cutoffx, cutoffy, order, type);
var linear_array = this.irfft2d(this.spectrum_output.array, this.wrapped_width, this.wrapped_height, (this.wrapped_width-this.width)/2, (this.wrapped_height-this.height)/2);
fscv_data.current.array = array_to_2d(linear_array, this.height, this.width);
this.restore_data(fscv_data);
};

get_spectrum_arrays(fscv_data, frequency, cycling_frequency, height_padding, width_padding){
this.wrapped_width = this.width + 2*parseInt(width_padding*this.width); this.wrapped_height = this.height + 2*parseInt(height_padding*this.height);
this.frequency_x.array = this.get_frequency_array(this.wrapped_width, cycling_frequency);
this.frequency_y.array = this.get_frequency_array(this.wrapped_height, frequency);
this.wrapped_data.array = this.wrap_data(new Float32Array(flatten(fscv_data.current.array)), this.width, this.height, parseInt(this.width*width_padding), parseInt(this.height*height_padding));
[this.spectrum_output.array, this.spectrum_real_linear.array, this.spectrum_imaginary_linear.array] = this.rfft2d(this.wrapped_data.array, this.wrapped_width, this.wrapped_height);
};

graph_spectrum(div){
var graph_data = [{
z:this.spectrum_magnitude.array,
x:this.frequency_x.array,
y:this.frequency_y.array,
type:'heatmap',
colorscale:'Greys',
colorbar: {len:0.5, xpad:30, title:this.spectrum_magnitude.units},
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
};

get_frequency_array(length, frequency){
var array = new Float32Array(length), j = 0, half_FOV = parseInt(length/2);
for(var i = -half_FOV; i<half_FOV;++i){array[j] = i*(1/((length)/frequency));++j;};
return array;
};

get_absolute_frequency(cutoff, frequency_array){
return (cutoff/100)*frequency_array[frequency_array.length - 1];
};

get_data_even(fscv_data){
if(this.width % 2 !== 0){fscv_data.current.array.map(x => x.push(x[x.length - 1])); ++this.width; this.width_even = false;};
if(this.height % 2 !== 0){fscv_data.current.array.push(fscv_data.current.array[fscv_data.current.array.length - 1]); ++this.height; this.height_even = false;};
};
restore_data(fscv_data){
if(!this.width_even){for(var i=0;i<this.height;++i){fscv_data.current.array[i].splice(-1,1)}; --this.width; this.width_even = true;}
if(!this.height_even){fscv_data.current.array.splice(-1,1); --this.height; this.height_even = true;}
}

initialise_graph(div){
Plotly.newPlot(div, [], this.plot_settings.plot_layout, this.plot_settings.plot_configuration);
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
// Methods with WASM.
rfft2d(data, m, n) {
let heap_data = allocFromArray(data), heap_spectrum = alloc(2*m*n*4), heap_spectrum_real = alloc(m*n*4), heap_spectrum_imag = alloc(m*n*4);
_rfft2d(heap_data.byteOffset, heap_spectrum.byteOffset, m, n);
_unzip_fft(heap_spectrum.byteOffset, heap_spectrum_real.byteOffset, heap_spectrum_imag.byteOffset, 2*m*n);
let spectrum = get_data_from_heap(heap_spectrum, 2*m*n), spectrum_real = get_data_from_heap(heap_spectrum_real, m*n),
spectrum_imag = get_data_from_heap(heap_spectrum_imag, m*n);
free(heap_data);free(heap_spectrum); free(heap_spectrum_real); free(heap_spectrum_imag);
return [spectrum, spectrum_real, spectrum_imag];
};

wrap_data(data, m, n, m_padding, n_padding){
let n_signal = (m+2*m_padding)*(n+2*n_padding), heap_data = allocFromArray(data), heap_wrapped_data = alloc(n_signal*4);
_wrap_array(heap_data.byteOffset, heap_wrapped_data.byteOffset, m, n, m_padding, n_padding);
let wrapped_data =  get_data_from_heap(heap_wrapped_data, n_signal);
free(heap_data); free(heap_wrapped_data);
return wrapped_data;
};

magnitude_array(spectrum_real, spectrum_imag, m, n){
let real_heap = allocFromArray(spectrum_real), imag_heap = allocFromArray(spectrum_imag), magnitude_heap = alloc(n*(m/2 + 1)*4), shifted_heap = alloc(m*n*4);
_magnitude_fft(real_heap.byteOffset, imag_heap.byteOffset, magnitude_heap.byteOffset, shifted_heap.byteOffset, m, n);
let magnitude = get_data_from_heap(magnitude_heap, n*(m/2 + 1)), shifted = get_data_from_heap(shifted_heap, m*n);
free(real_heap); free(imag_heap); free(magnitude_heap); free(shifted_heap);
return [magnitude, shifted];
};

butter_2d_filter(m, n, fy_array, fx_array, real_array, imag_array, frequency, cycling_frequency, cutoffx, cutoffy, order, type){
let fy_heap = allocFromArray(fy_array), fx_heap = allocFromArray(fx_array), b_2d_heap = alloc(4*n*(m/2 + 1)), real_heap = allocFromArray(real_array),
imag_heap = allocFromArray(imag_array), spectrum_heap = alloc(2*m*n*4);
_butter_2d(fy_heap.byteOffset, fx_heap.byteOffset, b_2d_heap.byteOffset, m, n, cutoffx, cutoffy, order);
if (type == 'LPF'){_had_product(real_heap.byteOffset, imag_heap.byteOffset, b_2d_heap.byteOffset, n*(m/2 + 1));}
else {_had_product_inv(real_heap.byteOffset, imag_heap.byteOffset, b_2d_heap.byteOffset, n*(m/2 + 1));};
_zip_fft(spectrum_heap.byteOffset, real_heap.byteOffset, imag_heap.byteOffset, m*n);
let real_spectrum = get_data_from_heap(real_heap, m*n);
let imag_spectrum = get_data_from_heap(imag_heap, m*n);
let full_spectrum = get_data_from_heap(spectrum_heap, 2*m*n);
free(fy_heap); free(fx_heap); free(b_2d_heap); free(real_heap); free(imag_heap); free(spectrum_heap);
return [real_spectrum, imag_spectrum, full_spectrum];
};

irfft2d(spectrum, m, n, m_padding, n_padding) {
let heap_spectrum = allocFromArray(spectrum), heap_wrapped_data = alloc(m*n*4), heap_data = alloc((m-m_padding*2)*(n-n_padding*2)*4);
_irfft2d(heap_spectrum.byteOffset, heap_wrapped_data.byteOffset, m, n);
_unwrap_array(heap_data.byteOffset, heap_wrapped_data.byteOffset, m, n, m_padding, n_padding);
let data = get_data_from_heap(heap_data, (m-m_padding*2)*(n-n_padding*2));
free(heap_spectrum); free(heap_data); free(heap_wrapped_data);
return data;
};

};
