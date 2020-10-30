// Class for uploaded FSCV Data.
function HL_FSCV_DATA(data, c_units, frequency, cycling_frequency, name_of_file){
this.frequency = frequency;
this.cycling_frequency = cycling_frequency;
this.name_of_file = name_of_file;
this.current = new HL_FSCV_CURRENT();
this.cycling_time = new HL_FSCV_TIME(cycling_frequency, data[0].length);
this.time = new HL_FSCV_TIME(frequency, data.length);

this.get_data_from_load = function(){
};
};

function HL_FSCV_CURRENT(data, c_units){
this.units = c_units;
this.name = 'Current';
this.array = data;
};

function HL_FSCV_TIME(frequency, length){
this.units = 's';
this.name = 'Time';
this.array = makeArr(0,(length-1)/frequency, length-1);
};
