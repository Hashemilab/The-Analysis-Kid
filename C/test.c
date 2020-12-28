#include <stdio.h>
#include "2DFFT.h"

int main(){
/* 2D array declaration*/
double real[15][7] = {
{ 1, 2, 3, 4, 5,6,7},
{ 1, 2, 3, 4, 5,6,7},
{ 1, 2, 3, 4, 5, 6,7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7},
{ 1, 2, 3, 4, 5, 6, 7}
};

double imag[15][7] = {
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0},
{0,0,0,0,0,0,0}
};
int nx = 7, ny = 15, nx_pw2, ny_pw2, diff_nx, diff_ny;

/*Get nx and ny of power of 2*/
nx_pw2 = pow(2, ceil(log(nx)/log(2)));
ny_pw2 = pow(2, ceil(log(ny)/log(2)));
diff_nx = nx_pw2 - nx;
diff_ny = ny_pw2 - ny;
// allocate memory
double ** real_ptr = (double **) malloc(sizeof (double *) * ny_pw2);
double ** imag_ptr = (double **) malloc(sizeof (double *) * ny_pw2);
for (int i = 0; i < ny_pw2; ++i){
real_ptr[i] = (double *) malloc(sizeof (double) * nx_pw2);
imag_ptr[i] = (double *) malloc(sizeof (double) * nx_pw2);
};

// copy matrix and expand to power of 2.
for (int i = diff_ny/2; i < ny; ++i) {
for (int j = 0; j < nx_pw2; ++j) {
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
for(int i=0; i<diff_ny/2;++i){
for (int j = 0; j < nx_pw2; ++j) {
real_ptr[i][j] = real_ptr[diff_ny/2][j];
imag_ptr[i][j] = imag_ptr[diff_ny/2][j];
};
};
// Bottom padding
for(int i=ny; i<ny_pw2;++i){
for (int j = 0; j < nx_pw2; ++j) {
real_ptr[i][j] = real_ptr[ny-1][j];
imag_ptr[i][j] = imag_ptr[ny-1][j];
};
};

/*Counter variables for the loop*/
int i,j;
//Displaying array elements
printf("Two Dimensional array elements:\n");
for(i=0; i<ny_pw2; ++i) {
for(j=0;j<nx_pw2;++j) {
printf("%f ",real_ptr[i][j]);
if(j==nx_pw2-1){
printf("\n");
}
}
}
FFT2D(real_ptr, imag_ptr, nx_pw2, ny_pw2, 1);
printf("Real:\n");
for(i=0; i<ny_pw2; ++i) {
for(j=0;j<nx_pw2;++j) {
printf("%f ", real_ptr[i][j]);
if(j==nx_pw2-1){
printf("\n");
}
}
}

printf("Imaginary:\n");
for(i=0; i<ny_pw2; ++i) {
for(j=0;j<nx_pw2;++j) {
printf("%f ", imag_ptr[i][j]);
if(j==nx_pw2-1){
printf("\n");
}
}
}

return 0;
}
