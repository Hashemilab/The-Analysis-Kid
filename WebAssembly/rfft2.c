#include <stdint.h>
#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include "kiss_fftndr.h"
void rfft2d(float *in, float *out, int m, int n) {
int dims[] = {n, m};
kiss_fftndr_cfg cfg;

cfg = kiss_fftndr_alloc(dims, 2, 0, NULL, NULL);
kiss_fftndr(cfg, in, (kiss_fft_cpx *) out);
free(cfg);
}

void irfft2d(float *in, float *out, int m, int n) {
int dims[] = {n, m}, size = m*n, i;
kiss_fftndr_cfg cfg;

cfg = kiss_fftndr_alloc(dims, 2, 1, NULL, NULL);
kiss_fftndri(cfg, (const kiss_fft_cpx *) in, out);
//Scale the output
for(i=0;i<size;++i){out[i] = out[i]/size;};
free(cfg);
}

void unzip_fft(float *spectrum, float *spectrum_real, float *spectrum_imag, int size){
int real_index = 0, imag_index = 0;
for (int i=0;i<size;++i){
if (i % 2 == 0) {
spectrum_real[real_index] = spectrum[i];
++real_index;
}
else{
spectrum_imag[imag_index] = spectrum[i];
++imag_index;
}
}
};

void zip_fft(float *spectrum, float *spectrum_real, float *spectrum_imag, int size){
int real_index = 0, imag_index = 0, i;
for (i=0;i<size*2;++i){
if (i % 2 == 0) {
spectrum[i] = spectrum_real[real_index];
++real_index;
}
else{
spectrum[i] = spectrum_imag[imag_index];
++imag_index;
}
}
};

void magnitude_fft(float *spectrum_real, float *spectrum_imag, float *magnitude,float *magnitude_shifted, int m, int n){
int i, j, mag_counter = 0, half_w = (n/2)*(m/2 + 1), size = n*(m/2 + 1);
float *top_right, *bottom_right, *bottom_left, *top_left;
for(i=0;i<size;++i){magnitude[i] = log(1.0 + sqrt(spectrum_real[i]*spectrum_real[i]+spectrum_imag[i]*spectrum_imag[i]));}

top_right = (float *) malloc(half_w * sizeof(float));
bottom_right = (float *) malloc(half_w * sizeof(float));
bottom_left = (float *) malloc(half_w * sizeof(float));
top_left = (float *) malloc(half_w * sizeof(float));

for(i=0;i<half_w;++i){
top_right[i] = magnitude[i];
bottom_right[i] = magnitude[i + half_w];
bottom_left[half_w - i - 1] = magnitude[i];
top_left[half_w - i - 1] = magnitude[i + half_w];
};

for(i=0;i<n/2;++i){
for(j=0;j<m/2;++j){
magnitude_shifted[mag_counter] = bottom_left[i*(m/2 + 1) + j];
++mag_counter;
}
for(j=0;j<m/2;++j){
magnitude_shifted[mag_counter] = bottom_right[i*(m/2 + 1) + j];
++mag_counter;
}
};

for(i=0;i<n/2;++i){
for(j=0;j<m/2;++j){
magnitude_shifted[mag_counter] = top_left[i*(m/2 + 1) + j];
++mag_counter;
}
for(j=0;j<m/2;++j){
magnitude_shifted[mag_counter] = top_right[i*(m/2 + 1) + j];
++mag_counter;
}
}
free(top_right); free(bottom_right); free(bottom_left); free(top_left);
};

void wrap_array(float *linear_array, float *wrapped_array, int width, int height, int width_padding, int height_padding){
int i, j, total_width = width + 2*width_padding;
int wrap_counter = height_padding * total_width;
//Centre
for (i=0;i<height;++i){
for(j=0;j<width_padding;++j){
wrapped_array[wrap_counter] = linear_array[i*width];
++wrap_counter;
};
for(j=0;j<width;++j){
wrapped_array[wrap_counter] = linear_array[i*width+j];
++wrap_counter;
};
for(j=0;j<width_padding;++j){
wrapped_array[wrap_counter] = linear_array[i*width + (width-1)];
++wrap_counter;
};
};
//Top
wrap_counter = 0;
for(i=0;i<height_padding;++i){
for(j=0;j<total_width;++j){
wrapped_array[wrap_counter] = wrapped_array[height_padding * total_width + j];
++wrap_counter;
}
};
//Bottom
wrap_counter = (height_padding + height) * total_width;
for(i=0;i<height_padding;++i){
for(j=0;j<total_width;++j){
wrapped_array[wrap_counter] = wrapped_array[(height_padding + height - 1) * total_width + j];
++wrap_counter;
}
};
};

void unwrap_array(float *array, float *wrapped_array, int wrapped_width, int wrapped_height, int width_padding, int height_padding){
int i, j, h_stop = wrapped_height - height_padding, w_stop = wrapped_width - width_padding, counter = 0;
for(i = height_padding; i<h_stop;++i){
for(j = width_padding;j<w_stop;++j){
array[counter] = wrapped_array[i*wrapped_width + j];
++counter;
}
}
};
//Butterworth filter implementation form http://fourier.eng.hmc.edu/e101/lectures/Fourier_Analysis/node10.html
void butter_2d(float *fy, float *fx, float *b_2d, int m, int n, float cutoffx, float cutoffy, float order){
int i, j, half_height = n/2, half_width = m/2, w = half_width + 1;
float d, fi;
for(i=0;i<n;++i){
if(i<half_height){fi = fy[i+half_height];}
else{fi = fy[i-half_height];}
for(j=0;j<w;++j){
d = pow((fi)/cutoffy, 2) + pow((fx[j+half_width-1])/cutoffx, 2);
b_2d[i*w+j] = 1/(1 + pow(d, order));
}
}
};

void had_product(float *real, float *imag, float *filter, int size){
for(int i=0;i<size;++i){real[i] = real[i]*filter[i]; imag[i] = imag[i]*filter[i];};
};
