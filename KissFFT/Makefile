all:
	cd compiled ; \
	emcc -O3 -Wall ../rfft2.c ../kissfft/kiss_fftr.c ../kissfft/kiss_fftnd.c \
		 ../kissfft/kiss_fftndr.c ../kissfft/kiss_fft.c -I ../kissfft \
		 -s WASM=1 -s ALLOW_MEMORY_GROWTH=1 -s \
 -s EXPORTED_FUNCTIONS="['_rfft2d', '_irfft2d', '_unzip_fft', '_zip_fft', '_wrap_array', '_magnitude_fft', '_butter_2d', '_had_product', '_unwrap_array', '_malloc', '_free']" -s INITIAL_MEMORY=536870912
