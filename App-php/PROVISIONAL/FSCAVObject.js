// Class for uploaded FSCAV data.
function FSCAV_DATA(data, neurotransmitter, xunits, yunits, frequency) {
  this.data = data;
  this.neurotransmitter = neurotransmitter;
  this.xunits = xunits;
  this.yunits = yunits;
  this.frequency = frequency;
  this.greeting = function() {
    alert('Hi! I\'m ' + this.name + '.');
  };
}
