// Class with static methods to filter FSCV data.
class HL_FILTERING {



static apply_convolution(fscv_data, std, reps){
var data = fscv_data.current.array;
var linear_input = linearise(data);
var linear_output = uniform_array(linear_input.length, 0);
for (var i = 0; i<reps; ++i){
conv_2d_gaussian(linear_input, linear_output, data[0].length, data.length, std);
fscv_data.current.array = split_array(linear_output, data[0].length);
linear_input = linear_output;
};
};

static apply_2dfft(){

}

};
