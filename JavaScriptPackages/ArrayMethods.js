//Maximum of an array.
function max(num){
return Math.max.apply(null, num);
};
//Minimum of an array.
function min(num){
return Math.min.apply(null, num);
};
// Index of the max value in array.
function indexOfMax(arr) {
if (arr.length === 0) {
return -1;
}
var max = arr[0];
var maxIndex = 0;
for (var i = 1; i < arr.length; i++) {
if (arr[i] > max) {
maxIndex = i;
max = arr[i];
}}
return maxIndex;
};
// Index of the min value in array.
function indexOfMin(arr) {
if (arr.length === 0) {
return -1;
}
var min = arr[0];
var minIndex = 0;
for (var i = 1; i < arr.length; i++) {
if (arr[i] < min) {
minIndex = i;
min = arr[i];
}}
return minIndex;
};
// Array of local minima considering 4 neighbours.
function localminima(arr){
mins = []; mins_index = [];
for (var i = 2; i < arr.length - 2; ++i) {
if (arr[i-1] > arr[i] && arr[i-2] > arr[i] && arr[i] < arr[i+1] && arr[i] < arr[i+2]) {
mins.push(arr[i]); mins_index.push(i);
}};
return [mins_index, mins];
}
//Array of local maxima considering 4 neighbours.
function localmaxima(arr){
maxes = []; maxes_index = [];
for (var i = 1; i < arr.length - 1; ++i) {
if (arr[i-1] < arr[i] && arr[i-2] < arr[i] && arr[i] > arr[i+1] && arr[i] > arr[i+2]) {
maxes.push(arr[i]); maxes_index.push(i);
}};
return [maxes_index, maxes];
}
//Max and min functions for large arrays where min() and max() do not work.
function getMax(arr) {
return arr.reduce((max, v) => max >= v ? max : v, -Infinity);
}
function getMin(arr) {
return arr.reduce((min, v) => min <= v ? min : v, Infinity);
}

// Short form to calculate average.
const average=arr=>arr.reduce((p,c)=>parseFloat(p)+parseFloat(c),0)/arr.length;
//Standard deviation of the array.
function std(arr){
var avg = average(arr);
var n = arr.length;
var squareDiffs = arr.map(function(value){
var diff = parseFloat(value) - avg;
var sqrDiff = diff * diff;
return sqrDiff;
});
var sum = squareDiffs.reduce(function(a, b){
return a + b;
}, 0);
if (n == 1){var avgSquareDiff = 0}
else {var avgSquareDiff = sum/(n-1);};
var stdDev = Math.sqrt(avgSquareDiff);
return stdDev;
};
// Extract column from 2D array.
function arrayColumn(arr, n) {
return arr.map(x=> x[n]);
};
// Calculate area under the curve of array with trapezoid rule.
function trap_auc(arr, frequency){
var area = 0;
for(var i=1; i<arr.length; i++) {
area += 0.5 * (arr[i] + arr[i-1]) * (1/frequency);
};
return area;
};
// Normalize value to 0-1 having a min and max value of the array.
function normalize(val0, max0, min0) { return (val0 - min0) / (max0 - min0);};
// Denormalize value having a min and max value of the array.
function denormalize(val0, max0, min0) { return (val0*(max0-min0))+min0;};
// Convert linear array to 2D array given the number of columns.
function split_array(array, part) {
var tmp = [];
for(var i = 0; i < array.length; i += part) {
tmp.push(array.slice(i, i + part));
}
return tmp;
}

function linearise(array){
return [].concat.apply([], array);
}
// Function that generates array (similar to numpy.linspace).
function makeArr(startValue, stopValue, cardinality) {
var arr = [];
var step = (stopValue - startValue) / (cardinality - 1);
for (var i = 0; i < cardinality; i++) {
arr.push(startValue + (step * i));
}
return arr;
}
// Function that generates an array of zeros.
function uniform_array(len, value) {
let arr = new Array(len); for (let i=0; i<len; ++i) arr[i] = Array.isArray(value) ? [...value] : value;
return arr;
}
//Calculate transpose.
function transpose(a) {
return Object.keys(a[0]).map(function(c) {
return a.map(function(r) { return r[c];});
});
};
// Parse string n-dim array to float.
function parse_array_to_float(arr) {
var callee = arguments.callee;
return arr instanceof Array ? arr.map(function(elem2) {return callee(elem2);})
: parseFloat(arr);
};

//2D Convolution: simple implementation.
function conv_2d(kernel, array){
var result = uniform_array(array.length, uniform_array(array[0].length, 0));
var kRows = kernel.length;
var kCols = kernel[0].length;
var rows = array.length;
var cols = array[0].length;
// find center position of kernel (half of kernel size)
var kCenterX = Math.floor(kCols/2);
var kCenterY = Math.floor(kRows/2);
var i, j, m, n;
for(i=0; i < rows; ++i){          // for all rows
for(j=0; j < cols; ++j){          // for all columns
for(m=0; m < kRows; ++m){         // kernel rows
mm = kRows - 1 - m;
for(n=0; n < kCols; ++n){        // kernel columns
nn = kCols - 1 - n;
// index of input signal, used for checking boundary
var ii = i + (kCenterY - mm);
var jj = j + (kCenterX - nn);
// ignore input samples which are out of bound
if(ii >= 0 && ii < rows && jj >= 0 && jj < cols){
result[i][j] += array[ii][jj] * kernel[m][n];
}}}}};
return result;
};

// Fast gaussian convolution. IMPORTANT: convolution is applied IN PLACE.
// http://blog.ivank.net/fastest-gaussian-blur.html
function conv_2d_gaussian(scl, tcl, w, h, r){
var bxs = boxesForGauss(r, 3);
boxBlur(scl, tcl, w, h, (bxs[0]-1)/2);
boxBlur(tcl, scl, w, h, (bxs[1]-1)/2);
boxBlur(scl, tcl, w, h, (bxs[2]-1)/2);
};
function boxBlur (scl, tcl, w, h, r) {
for(var i=0; i<scl.length; i++) tcl[i] = scl[i];
boxBlurH(tcl, scl, w, h, r);
boxBlurT(scl, tcl, w, h, r);
}
function boxBlurH(scl, tcl, w, h, r) {
var iarr = 1 / (r+r+1);
for(var i=0; i<h; i++) {
var ti = i*w, li = ti, ri = ti+r;
var fv = scl[ti], lv = scl[ti+w-1], val = (r+1)*fv;
for(var j=0; j<r; j++) val += scl[ti+j];
for(var j=0  ; j<=r ; j++) { val += scl[ri++] - fv       ;   tcl[ti++] = val*iarr; }
for(var j=r+1; j<w-r; j++) { val += scl[ri++] - scl[li++];   tcl[ti++] = val*iarr; }
for(var j=w-r; j<w  ; j++) { val += lv        - scl[li++];   tcl[ti++] = val*iarr; }
}};
function boxBlurT(scl, tcl, w, h, r) {
var iarr = 1 / (r+r+1);
for(var i=0; i<w; i++) {
var ti = i, li = ti, ri = ti+r*w;
var fv = scl[ti], lv = scl[ti+w*(h-1)], val = (r+1)*fv;
for(var j=0; j<r; j++) val += scl[ti+j*w];
for(var j=0  ; j<=r ; j++) { val += scl[ri] - fv     ;  tcl[ti] = val*iarr;  ri+=w; ti+=w; }
for(var j=r+1; j<h-r; j++) { val += scl[ri] - scl[li];  tcl[ti] = val*iarr;  li+=w; ri+=w; ti+=w; }
for(var j=h-r; j<h  ; j++) { val += lv      - scl[li];  tcl[ti] = val*iarr;  li+=w; ti+=w; }
}};
function boxesForGauss(sigma, n) {
var wIdeal = Math.sqrt((12*sigma*sigma/n)+1);  // Ideal averaging filter width
var wl = Math.floor(wIdeal);  if(wl%2==0) wl--;
var wu = wl+2;
var mIdeal = (12*sigma*sigma - n*wl*wl - 4*n*wl - 3*n)/(-4*wl - 4);
var m = Math.round(mIdeal);
// var sigmaActual = Math.sqrt( (m*wl*wl + (n-m)*wu*wu - n)/12 );
var sizes = [];  for(var i=0; i<n; i++) sizes.push(i<m?wl:wu);
return sizes;
};
