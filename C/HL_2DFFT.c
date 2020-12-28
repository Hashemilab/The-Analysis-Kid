/*-------------------------------------------------------------------------
Perform a 2D FFT inplace given a complex 2D array
The direction dir, 1 for forward, -1 for reverse
The size of the array (nx,ny)
*/
#include <stdlib.h>
#include <math.h>


/* This computes an in-place complex-to-complex FFT */
int FFT(int dir,int m, float *x,float *y)
{
long nn,i,i1,j,k,i2,l,l1,l2;
float c1,c2,tx,ty,t1,t2,u1,u2,z;

/* Calculate the number of points */
nn = 1;
for (i=0;i<m;i++)
nn *= 2;

/* Do the bit reversal */
i2 = nn >> 1;
j = 0;
for (i=0;i<nn-1;i++) {
if (i < j) {
tx = x[i];
ty = y[i];
x[i] = x[j];
y[i] = y[j];
x[j] = tx;
y[j] = ty;
}
k = i2;
while (k <= j) {
j -= k;
k >>= 1;
}
j += k;
}

/* Compute the FFT */
c1 = -1.0;
c2 = 0.0;
l2 = 1;
for (l=0;l<m;l++) {
l1 = l2;
l2 <<= 1;
u1 = 1.0;
u2 = 0.0;
for (j=0;j<l1;j++) {
for (i=j;i<nn;i+=l2) {
i1 = i + l1;
t1 = u1 * x[i1] - u2 * y[i1];
t2 = u1 * y[i1] + u2 * x[i1];
x[i1] = x[i] - t1;
y[i1] = y[i] - t2;
x[i] += t1;
y[i] += t2;
}
z =  u1 * c1 - u2 * c2;
u2 = u1 * c2 + u2 * c1;
u1 = z;
}
c2 = sqrt((1.0 - c1) / 2.0);
if (dir == 1)
c2 = -c2;
c1 = sqrt((1.0 + c1) / 2.0);
}

/* Scaling for forward transform */
if (dir == 1) {
for (i=0;i<nn;i++) {
x[i] /= (float)nn;
y[i] /= (float)nn;
}
}

return 0;
}

int FFT2D(float **c_real, float **c_imag, int nx, int ny, int dir)
{
int i,j,m;
float *real,*imag;

/* Transform the rows */
real = (float *)malloc(nx * sizeof(float));
imag = (float *)malloc(nx * sizeof(float));
m = log(nx)/log(2);
for (j=0;j<ny;j++) {
for (i=0;i<nx;i++) {
real[i] = c_real[j][i];
imag[i] = c_imag[j][i];
}
FFT(dir,m,real,imag);
for (i=0;i<nx;i++) {
c_real[j][i] = real[i];
c_imag[j][i] = imag[i];
}
}
free(real);
free(imag);

/* Transform the columns */
real = (float *)malloc(ny * sizeof(float));
imag = (float *)malloc(ny * sizeof(float));
m = log(ny)/log(2);
for (i=0;i<nx;i++) {
for (j=0;j<ny;j++) {
real[j] = c_real[j][i];
imag[j] = c_imag[j][i];
}
FFT(dir,m,real,imag);
for (j=0;j<ny;j++) {
c_real[j][i] = real[j];
c_imag[j][i] = imag[j];
}
}
free(real);
free(imag);
return 0;
}

int HL_2DFFT(float **real, float **imag, float **real_ptr, float **imag_ptr, int nx, int ny, int nx_pw2, int ny_pw2){
int i, j, diff_nx, diff_ny;

diff_nx = nx_pw2 - nx;
diff_ny = ny_pw2 - ny;

// copy matrix and expand to power of 2.
for (i = diff_ny/2; i < ny; ++i) {
for (j = 0; j < nx_pw2; ++j) {
if(j<diff_nx/2){
real_ptr[i][j] = real[i-(diff_ny/2)][0];
imag_ptr[i][j] = imag[i-(diff_ny/2)][0];
}
else if(j>(diff_nx/2 - 1) && j<nx){
real_ptr[i][j] = real[i-(diff_ny/2)][j-(diff_nx/2)];
imag_ptr[i][j] = imag[i-(diff_ny/2)][j-(diff_ny/2)];
} else{
real_ptr[i][j] = real[i-(diff_ny/2)][nx-1];
imag_ptr[i][j] = imag[i-(diff_ny/2)][nx-1];
}
}
};
// Top padding
for(i=0; i<diff_ny/2;++i){
for (j = 0; j < nx_pw2; ++j) {
real_ptr[i][j] = real_ptr[diff_ny/2][j];
imag_ptr[i][j] = imag_ptr[diff_ny/2][j];
};
};
// Bottom padding
for(i=ny; i<ny_pw2;++i){
for (j = 0; j < nx_pw2; ++j) {
real_ptr[i][j] = real_ptr[ny-1][j];
imag_ptr[i][j] = imag_ptr[ny-1][j];
};
};
FFT2D(real_ptr, imag_ptr, nx_pw2, ny_pw2, 1);

return 0;
}

int test_fcn(int a, int b) {return a+b;}
