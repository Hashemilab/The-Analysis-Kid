// Class for uploaded FSCAV data.
function FSCAV_DATA(data, neurotransmitter, v_units, c_units, frequency) {
  this.voltage_array = arrayColumn(data, 0);
  this.frequency = frequency;
  this.time_array;
  this.neurotransmitter = neurotransmitter;
  this.number_of_signals = data[0].length-1;
  this.v_units = v_units;
  this.c_units = c_units;

};
