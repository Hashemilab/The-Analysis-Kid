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
function std(values){
var avg = average(values);
var n=values.length;
var squareDiffs = values.map(function(value){
var diff = parseFloat(value) - avg;
var sqrDiff = diff * diff;
return sqrDiff;
});
var sum = squareDiffs.reduce(function(a, b){
return a + b;
}, 0);
if (n==1){var avgSquareDiff=0}
else {  var avgSquareDiff = sum/(n-1);};
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
function chunk(arr, size) {
var chunkedArray = [];
while ( arr.length > 0 ) {
chunkedArray.push( arr.splice( 0, size ) );
}
return chunkedArray;
}
