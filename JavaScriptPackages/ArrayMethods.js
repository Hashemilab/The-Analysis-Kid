// Index of the max value in array.
function index_of_max(arr) {
var max = arr[0], index = 0;
for (var i = 1; i < arr.length; i++) {if (arr[i] > max) {index = i; max = arr[i]}};
return [max, index];
};
// Index of the min value in array.
function index_of_min(arr) {
var min = arr[0], index = 0;
for (var i = 1; i < arr.length; i++) {if (arr[i] < min) {index = i; min = arr[i]}}
return [min, index];
};
function index_of_max_and_min(arr){
var max = arr[0], index_max = 0, min = arr[0], index_min = 0;
for (var i = 1; i < arr.length; i++) {
if (arr[i] < min) {index_min = i; min = arr[i]}
if (arr[i] > max) {index_max = i; max = arr[i]}
};
return [min, index_min, max, index_max];
};

// Array of local minima considering n neighbours.
function local_minima(arr, n){
mins = []; mins_index = [];
for (var i = n; i < arr.length - n; ++i) {
ev = true;
for (var j = 1; j<n+1;++j){ev = ev && (arr[i]<arr[i-j] && arr[i]<arr[i+j]);};
if(ev){mins.push(arr[i]); mins_index.push(i)};
}
return [mins_index, mins];
};

//Array of local maxima considering 4 neighbours.
function local_maxima(arr, n){
maxes = []; maxes_index = [];
for (var i = n; i < arr.length - n; ++i) {
ev = true;
for (var j = 1; j<n+1;++j){ev = ev && (arr[i]>arr[i-j] && arr[i]>arr[i+j]);};
if(ev){maxes.push(arr[i]); maxes_index.push(i)};
}
return [maxes_index, maxes];
};

// Calculates the absolute of array.
function absolute_array(arr){
tmp=[];
for (var i=0;i<arr.length;++i){tmp[i] = Math.abs(arr[i])};
return tmp;
};

function diff_arr(arr, frequency){
var tmp = [0];
for (var i=0;i<arr.length-1;++i){ tmp[i+1] = (arr[i+1]-arr[i])*frequency};
return tmp;
};
// Mean square errors of two arrays.
function mse(arr1, arr2){
var sum=0;
for (var i =0; i<arr1.length;++i){sum+=(arr1[i]-arr2[i])*(arr1[i]-arr2[i])};
return sum/arr1.length;
};

// Short form to calculate average.
function average(arr){for(i=0, sum=0;i<arr.length;++i){sum+=arr[i]}; return sum/arr.length};
//Standard deviation of the array.
function std(array){
const n = array.length;
const mean = array.reduce((a, b) => a + b) / n;
return Math.sqrt(array.map(x => Math.pow(x - mean, 2)).reduce((a, b) => a + b) / n);
}
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
// Calculate area under the curve of array with Simpson's rule.
function simpson_auc(arr, frequency){
var n = arr.length, h = 1/frequency, sum1=0, sum2=0;
for (var i=1;i<arr.length-1;++i){if(i%2==0){sum1 += arr[i]} else{sum2+=arr[i]}}
return  h/3*(arr[0]+2*sum1+4*sum2+arr[arr.length-1]);
}

// Linear curve fit using linear least squares.
function linear_fit(arr_x, arr_y){
var sum_xx = 0, sum_y = 0, sum_yy=0, sum_x = 0, sum_xy = 0, n = arr_x.length;
for(var i=0;i<n;i++){
var x = arr_x[i];
var y = arr_y[i];
sum_xx += x*x, sum_y += y, sum_yy += y*y, sum_x += x, sum_xy += x*y;
}
var a = ((sum_y*sum_xx)-(sum_x*sum_xy))/((n*sum_xx)-sum_x*sum_x);
var b = ((n*sum_xy)-(sum_x*sum_y))/((n*sum_xx)-sum_x*sum_x);
var r2 = Math.pow((n*sum_xy - sum_x*sum_y)/Math.sqrt((n*sum_xx-sum_x*sum_x)*(n*sum_yy-sum_y*sum_y)),2);
return [a,b, r2];
};

function quadratic_fit(arr_x, arr_y, order){
let x_matrix = [], x_temp = [], y_matrix = transpose([arr_y]), x_matrix_t = [], dot1, dot_inv, dot2;
for (j=0;j<arr_x.length;j++){
x_temp = [];
for(i=0;i<=order;i++){x_temp.push(Math.pow(arr_x[j],i));};
x_matrix.push(x_temp);
};
x_matrix_t = transpose(x_matrix);
dot1 = multiply_matrices(x_matrix_t, x_matrix);
dot_inv = inverse(dot1);
dot2 = multiply_matrices(x_matrix_t, y_matrix);
return multiply_matrices(dot_inv, dot2);
};

// Errors of regression: standard error of estimate, slope and intercept.
function linear_estimation_errors(pred_y, real_y, x){
var mean_x = average(x), sum_dx=0, sum_xx=0, sq_residuals = 0, se_regression, se_slope, se_intercept, n=x.length;
for (var i=0; i<n; ++i){
sum_xx = x[i]*x[i]; sum_dx += (x[i]-mean_x)*(x[i]-mean_x);
sq_residuals+=(pred_y[i]-real_y[i])*(pred_y[i]-real_y[i]);
};
var se_regression = Math.sqrt(sq_residuals/(n-2));
var se_slope = se_regression/(Math.sqrt(sum_dx));
var se_intercept = se_regression*Math.sqrt(sum_xx/(n*sum_dx));
return [se_regression, se_slope, se_intercept];
};
// Standard error of an extimate with predicted values.
function estimation_errors(pred_y, real_y){
var sq_residuals = 0, sq_total = 0, n = pred_y.length, see, r2, mean_y = average(real_y);
for (var i=0; i<n; ++i){
sq_residuals+=(pred_y[i]-real_y[i])*(pred_y[i]-real_y[i]);
sq_total += (real_y[i]-mean_y)*(real_y[i]-mean_y);
};
see = Math.sqrt(sq_residuals/(n-2));
r2 = 1 - sq_residuals/sq_total;
return [see, r2];
};

//Hessian matrix to estimate error of nonlinear exponential regression, y=c0*e^kx.
// Adapted from : https://www.cpp.edu/~pbsiegel/javascript/curvefitchi.html
function hess_exp_errors(c0, k, x, y){
var sum1=0,sum2=0,sum3=0,sum4=0,sum5=0, expon1,
he11, he12, he22, dett, dof, k_err, c0_error;
for (i=0;i<x.length;i++){
expon1=Math.exp(k*x[i]);
sum1+=expon1*expon1;
sum2+=y[i]*x[i]*x[i]*expon1;
sum3+=x[i]*x[i]*expon1*expon1;
sum4+=y[i]*x[i]*expon1;
sum5+=x[i]*expon1*expon1;
}
he11=4*c0*c0*sum3-2*c0*sum2; he22=2*sum1;
he12=4*c0*sum5-2*sum4; dett=he11*he22-he12*he12;
c0_err=Math.sqrt(he11/dett); k_err=Math.sqrt(he22/dett);
return [c0_err, k_err];
};

// ln(x) of each value in array.
function log_of_array(arr){
tmp=[];
for(i=0;i<arr.length;++i){tmp[i] = Math.log(arr[i])};
return tmp;
}
// exp(x) of each value in array.
function exp_of_array(arr){
tmp=[];
for(i=0;i<arr.length;++i){tmp[i] = Math.exp(arr[i])};
return tmp;
}


// Normalize array to 0-1 having a min and max value of the array.
function normalize(arr, max, min){
var norm_arr = [];
for (var i=0;i<arr.length;++i){norm_arr[i] = (arr[i]-min)/(max-min)};
return norm_arr;
};
// Denormalize value having a min and max value of the array.
function denormalize(norm_arr, max, min){
var arr = [];
for (var i=0;i<norm_arr.length;++i){arr[i] = norm_arr[i]*(max-min)+min};
return arr;
};
//Normalize to mean 0 and std 0.
function standard_normalize(arr, mean, std){
var norm_arr = [];
for (var i=0;i<arr.length;++i){norm_arr[i] = (arr[i]-mean)/std};
return norm_arr;
};
//Denormalize from mean 0 and std 1.
function standard_denormalize(norm_arr, mean, std){
var arr = [];
for (var i=0;i<norm_arr.length;++i){arr[i] = norm_arr[i]*std+mean};
return arr;
};


// Convert linear array to 2D array given the number of columns.
function split_array(array, part) {
var tmp = [];
for(var i = 0; i < array.length; i += part) {
tmp.push(array.slice(i, i + part));
}
return tmp;
};
// Similar to split_array, but does not preserve the type of the sliced array.
function array_to_2d(array, height, width){
let tmp = [];
for(var i=0;i<height;++i){tmp[i] = []; for(var j=0;j<width;++j){tmp[i][j] = array[i*width + j]}};
return tmp;
};
// Linearise an n-dimension array.
function linearise(array, level){
return array.flat(level);
}
//Linarise a n-dimension array (faster but it linearises all dimensions).
const flatten = function(arr, result = []) {
for (let i = 0, length = arr.length; i < length; i++) {
const value = arr[i];
if (Array.isArray(value)) {flatten(value, result)} else {result.push(value)}};
return result;
};

// Reverse an array.
function reverse_array(input) {
var ret = new Array;
for(var i = input.length-1; i >= 0; i--) {ret.push(input[i])};
return ret;
};

// Hadamard product of 2D arrays.
function had_product_2d(arr1, arr2){
return uniform_array(arr1.length, uniform_array(arr1[0].length), 0).map((x,i) => x.map((y,j) => arr1[i][j]*arr2[i][j]));
}
function had_product_1d(arr1, arr2){
var tmp=[];
for(var i=0; i<arr1.length;++i){tmp[i]=arr1[i]*arr2[i];}
return tmp;
};


//Inverse of square matrix.
function inverse(t){
var n = [t.length, t[0].length], r = Math.abs, i = n[0], s = n[1], o = deep_copy_2d_array(t), u, a, f = identity(i), l, c, h, p, d, t;
for (p = 0; p < s; ++p) {
var v = -1,
m = -1;
for (h = p; h !== i; ++h) (d = r(o[h][p])), d > m && ((v = h), (m = d));
(a = o[v]), (o[v] = o[p]), (o[p] = a), (c = f[v]), (f[v] = f[p]), (f[p] = c), (t = a[p]);
for (d = p; d !== s; ++d) a[d] /= t;
for (d = s - 1; d !== -1; --d) c[d] /= t;
for (h = i - 1; h !== -1; --h)
if (h !== p) {
(u = o[h]), (l = f[h]), (t = u[p]);
for (d = p + 1; d !== s; ++d) u[d] -= a[d] * t;
for (d = s - 1; d > 0; --d) (l[d] -= c[d] * t), --d, (l[d] -= c[d] * t);
d === 0 && (l[0] -= c[0] * t);
}}
return f;
};

//Identity matrix.
function identity(n) {
var i, j, arr = [], matrix= [];
for (i=0; i < n; i++){for (j=0; j < n; j++){
if (i === j){arr[j] = 1} else{arr[j] = 0}}
matrix[i] = arr, arr = [];}
return matrix;
};

// Scalar product of one-dimensional array.
function scalar_product(arr, scalar){
tmp=[];
for(var i=0;i<arr.length;++i){tmp[i] = arr[i]*scalar};
return tmp;
};

// Copy a 2D array.
function deep_copy_2d_array(arr){
var tmp = [];
for (var i = 0; i < arr.length; i++){tmp[i] = arr[i].slice()};
return tmp;
};
function copy_array(arr){
let tmp = [];
for (var i = 0; i < arr.length; i++){tmp[i] = arr[i]};
return tmp;
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
// Convert 2D array into square by the largest dimension.
function squared_array(arr){
var h_max = 0, tmp;
for (var i=0; i<arr.length;++i){if(arr[i].length>h_max){h_max = arr[i].length}};
if (arr.length>h_max){h_max = arr.length};
var tmp = uniform_array(h_max, uniform_array(h_max, ''));
for(var i=0;i<tmp.length;++i){for(var j=0;j<tmp.length;++j){if(arr[i] != undefined && arr[i][j] != undefined){tmp[i][j] = arr[i][j]}}};
return tmp;
};

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

// Function that gets the values from even indexes.
function get_even_indexes(arr){
return arr.filter(function(element, index, array){return (index % 2 === 0);
});
};
// Function that gets the values from odd indexes.
function get_odd_indexes(arr){
return arr.filter(function(element, index, array){return (index % 2 !== 0);
});
}
// Function that gets the values from even indexes. Faster than the other two.
function get_even_and_odd_indexes(arr){
var tmp_even=[], tmp_odd=[];
for (var i=0, j=0, k=0; i<arr.length; ++i){
if(i % 2 === 0){tmp_even[j] = arr[i];++j}
else{tmp_odd[k] = arr[i]; ++k}};
return [tmp_even, tmp_odd];
};

//zip two 1D arrays.
function zip(arr1, arr2){
var tmp=[];
for (var i=0;i<arr1.length;++i){tmp.push(arr1[i], arr2[i])};
return tmp;
};

// Fast gaussian convolution. IMPORTANT: convolution is applied IN PLACE.
// https://blog.ivank.net/fastest-gaussian-blur.html
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
};
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

//Traditional definition of Gaussian convolution.


function simple_gauss_blur(scl, tcl, w, h, r) {
var rs = Math.ceil(r * 2.57);
// significant radius
for(var i=0; i<h; i++)
for(var j=0; j<w; j++) {
var val = 0, wsum = 0;
for(var iy = i-rs; iy<i+rs+1; iy++)
for(var ix = j-rs; ix<j+rs+1; ix++) {
var x = Math.min(w-1, Math.max(0, ix));
var y = Math.min(h-1, Math.max(0, iy));
var dsq = (ix-j)*(ix-j)+(iy-i)*(iy-i);
var wght = Math.exp( -dsq / (2*r*r) ) / (Math.PI*2*r*r);
val += scl[y*w+x] * wght;
wsum += wght;
}
tcl[i*w+j] = val/wsum;
}
};

// Functions for complex numbers.
function Complex(real, imaginary) {
this.real = 0;
this.imaginary = 0;
this.real = (typeof real === 'undefined') ? this.real : parseFloat(real);
this.imaginary = (typeof imaginary === 'undefined') ? this.imaginary : parseFloat(imaginary);
}
Complex.transform = function(num) {
var complex;
complex = (num instanceof Complex) ? num : complex;
complex = (typeof num === 'number') ? new Complex(num, 0) : num;
return complex;
};

function complex_num_multiply(first, second) {
var num1, num2;
num1 = Complex.transform(first);
num2 = Complex.transform(second);
var real = (num1.real * num2.real)-(num1.imaginary * num2.imaginary);
var imaginary = (num1.real * num2.imaginary)+(num1.imaginary * num2.real);
return new Complex(real, imaginary);
}

function complex_num_divide(first, second) {
var num1, num2;
num1 = Complex.transform(first);
num2 = Complex.transform(second);
var denom = num2.imaginary * num2.imaginary + num2.real * num2.real;
var real = (num1.real * num2.real + num1.imaginary * num2.imaginary) /denom;
var imaginary = (num2.real * num1.imaginary - num1.real * num2.imaginary) /denom;
return new Complex(real, imaginary);
}

// Simple iteration to find non-linear best fit based on stochastic gradient descent.
fminsearch = function(fun,Parm0,x,y,opt){
if(!opt){opt={}};
if(!opt.maxIter){opt.maxIter=1000};
if(!opt.step){
opt.step = Parm0.map(function(p){return p/100});
opt.step = opt.step.map(function(si){if(si==0){return 1}else{return si}});
};
if(!opt.trainable){opt.trainable = uniform_array(Parm0.length, 1)};
if(!opt.objFun){opt.objFun=function(y,yp){return y.map(function(yi,i){return Math.pow((yi-yp[i]),2)}).reduce(function(a,b){return a+b})}}; //Sum squared errors.
if(!opt.max_limits){opt.max_limits = uniform_array(Parm0.length, Infinity)};
if(!opt.min_limits){opt.min_limits = uniform_array(Parm0.length, -Infinity)};
var cloneVector=function(V){return V.map(function(v){return v})};
var P0=cloneVector(Parm0), P1=cloneVector(Parm0);
var n = P0.length, step = opt.step, fun_P1, fun_P0;
var funParm = function(P){return opt.objFun(y, fun(x,P))}; //function (of Parameters) to minimize
// silly multi-univariate screening
for(var i=0;i<opt.maxIter;i++){
for(var j=0;j<n;j++){ // take a step for each parameter
if(opt.trainable[j]){
P1=cloneVector(P0);
P1[j]+=step[j];
if(P1[j]<opt.min_limits[j]){P1[j] = opt.min_limits[j]}
else if(P1[j]>opt.max_limits[j]){P1[j] = opt.max_limits[j]};
fun_P1 = funParm(P1), fun_P0 = funParm(P0);
if(fun_P1<fun_P0){step[j]=1.2*step[j], P0=cloneVector(P1)}
else{step[j]=-(0.5*step[j])};
}}};
return P0;
};

// Sort out two arrays based on one.
function sort_arrays(arrays, comparator = (a, b)  => (parseInt(a) < parseInt(b)) ? -1 : (parseInt(a) > parseInt(b)) ? 1 : 0 ) {
let arrayKeys = Object.keys(arrays);
let sortableArray = Object.values(arrays)[0];
let indexes = Object.keys(sortableArray);
let sortedIndexes = indexes.sort((a, b) => comparator(sortableArray[a], sortableArray[b]));

let sortByIndexes = (array, sortedIndexes) => sortedIndexes.map(sortedIndex => array[sortedIndex]);

if (Array.isArray(arrays)) {
return arrayKeys.map(arrayIndex => sortByIndexes(arrays[arrayIndex], sortedIndexes));
} else {
let sortedArrays = {};
arrayKeys.forEach((arrayKey) => {
sortedArrays[arrayKey] = sortByIndexes(arrays[arrayKey], sortedIndexes);
});
return sortedArrays;
}
}

//Matrix multiplication
const multiply_matrices = (a, b) => {
let x = a.length, z = a[0].length, y = b[0].length, productRow = Array.apply(null, new Array(y)).map(Number.prototype.valueOf, 0), product = new Array(x);
for (let p = 0; p < x; p++) {product[p] = productRow.slice();}
for (let i = 0; i < x; i++) {for (let j = 0; j < y; j++) {for (let k = 0; k < z; k++) {product[i][j] += a[i][k] * b[k][j];}}}
return product;
}
