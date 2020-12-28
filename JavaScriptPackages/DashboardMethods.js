// Short way to get element by id.
function _(el) {
return document.getElementById(el);
}

// 2D FFT FUNCTIONS from KISSFFT, Mark Borgerding.
/** Compute the FFT of a real-valued mxn matrix. */
function rfft2d(data, m, n) {
heapData = allocFromArray(data), heapSpectrum = alloc(2*m*n*4), heapSpectrum_real = alloc(m*n*4), heapSpectrum_imag = alloc(m*n*4);
_rfft2d(heapData.byteOffset, heapSpectrum.byteOffset, m, n);
_unzip_fft(heapSpectrum.byteOffset, heapSpectrum_real.byteOffset, heapSpectrum_imag.byteOffset, 2*m*n);
/* Get spectrum from the heap, copy it to local array. */
var spectrum = new Float32Array(2*m*n);
spectrum.set(new Float32Array(Module.HEAPU8.buffer,
heapSpectrum.byteOffset, 2*m*n));
var spectrum_real = new Float32Array(m*n);
spectrum_real.set(new Float32Array(Module.HEAPU8.buffer,
heapSpectrum_real.byteOffset, m*n));
var spectrum_imag = new Float32Array(m*n);
spectrum_imag.set(new Float32Array(Module.HEAPU8.buffer,
heapSpectrum_imag.byteOffset, m*n));
/* Free heap objects. */
free(heapData);free(heapSpectrum); free(heapSpectrum_real); free(heapSpectrum_imag);
return [spectrum, spectrum_real, spectrum_imag];
};

function wrap_data(data, m, n, m_padding, n_padding){
let n_signal = (m+2*m_padding)*(n+2*n_padding), heapData = allocFromArray(data), heapWrappedData = alloc(n_signal*4);
_wrap_array(heapData.byteOffset, heapWrappedData.byteOffset, m, n, m_padding, n_padding);
let wrapped_data = new Float32Array(n_signal);
wrapped_data.set(new Float32Array(Module.HEAPU8.buffer, heapWrappedData.byteOffset, n_signal));
free(heapData); free(heapWrappedData);
return wrapped_data;
};
/** Compute the inverse FFT of a real-valued mxn matrix. */
function irfft2d(spectrum, m, n) {
var heapSpectrum = allocFromArray(spectrum);
var heapData = alloc(m*n*4);
_irfft2d(heapSpectrum.byteOffset, heapData.byteOffset, m, n);
var data = new Float32Array(m*n);
data.set(new Float32Array(Module.HEAPU8.buffer,
heapData.byteOffset, m*n));
for (i=0;i<m*n;i++) {
data[i] /= m*n;
}
free(heapSpectrum);
free(heapData);
return data;
};
/** Create a heap array from the array ar. */
function allocFromArray(ar) {
/* Allocate */
var nbytes = ar.length * ar.BYTES_PER_ELEMENT;
var heapArray = alloc(nbytes);
/* Copy */
heapArray.set(new Uint8Array(ar.buffer));
return heapArray;
};
/** Allocate a heap array to be passed to a compiled function. */
function alloc(nbytes) {
var ptr = Module._malloc(nbytes);
return new Uint8Array(Module.HEAPU8.buffer, ptr, nbytes);
};
/** Free a heap array. */
function free(heapArray) {
Module._free(heapArray.byteOffset);
};
