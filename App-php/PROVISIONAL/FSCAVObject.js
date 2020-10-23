// Class for uploaded FSCAV data.
function FSCAV_DATA(data, neurotransmitter, xunits, yunits, frequency) {
  this.data = data;
  this.neurotransmitter = neurotransmitter;
  this.length = data.length;
  this.xunits = xunits;
  this.yunits = yunits;
  this.frequency = frequency;
  this.Calibrate = function() {
  };
  this.max = function() {};
  this.min = function() {};
};
