#include <stdint.h>
#include <stdio.h>
#include <stdlib.h>
#include <math.h>

int * boxesForGauss(float sigma, int n){
float wIdeal = sqrt((12*sigma*sigma/n)+1);
int i, wl = floor(wIdeal);
if(wl%2==0) {wl--;};
int wu = wl+2;
float mIdeal = (12*sigma*sigma - n*wl*wl - 4*n*wl - 3*n)/(-4*wl - 4);
int m = round(mIdeal);
int *sizes = (int *) malloc(n * sizeof(int));
for(i=0; i<n;++i){sizes[i] = i < m ? wl : wu;};
return sizes;
};

void boxBlurH_4(float *scl, float *tcl, int w, int h, int r) {
int i, j;
float iarr = 1.f / (r + r + 1);
for (i = 0; i < h; i++) {
int ti = i * w, li = ti, ri = ti + r;
float fv = scl[ti], lv = scl[ti + w - 1];
float val = (r + 1)*fv;
for (j = 0; j < r; j++) val += scl[ti + j];
for (j = 0; j <= r; j++) { val += scl[ri++] - fv;   tcl[ti++] = round(val*iarr);}
for (j = r + 1; j < w - r; j++) { val += scl[ri++] - scl[li++];   tcl[ti++] = round(val*iarr);}
for (j = w - r; j < w; j++) { val += lv - scl[li++];   tcl[ti++] = round(val*iarr);}
}
};

void boxBlurT_4(float *scl, float *tcl, int w, int h, int r) {
int i, j;
float iarr = 1.f / (r + r + 1);
for ( i = 0; i < w; i++) {
int ti = i, li = ti, ri = ti + r * w;
float fv = scl[ti], lv = scl[ti + w * (h - 1)];
float val = (r + 1)*fv;
for (j = 0; j < r; j++) val += scl[ti + j * w];
for (j = 0; j <= r; j++) { val += scl[ri] - fv;  tcl[ti] = round(val*iarr);  ri += w; ti += w;}
for (j = r + 1; j < h - r; j++) { val += scl[ri] - scl[li];  tcl[ti] = round(val*iarr);  li += w; ri += w; ti += w;}
for (j = h - r; j < h; j++) { val += lv - scl[li];  tcl[ti] = round(val*iarr);  li += w; ti += w;}
}
};

void boxBlur_4(float *scl, float *tcl, int w, int h, int r, int size) {
int i;
for (i = 0; i < size; i++) tcl[i] = scl[i];
boxBlurH_4(tcl, scl, w, h, r);
boxBlurT_4(scl, tcl, w, h, r);
};
void gaussBlur_4(float *scl, float *tcl, int w, int h, int r) {
int *bxs = boxesForGauss(r, 3);
boxBlur_4(scl, tcl, w, h, (bxs[0] - 1) / 2, w*h);
boxBlur_4(tcl, scl, w, h, (bxs[1] - 1) / 2, w*h);
boxBlur_4(scl, tcl, w, h, (bxs[2] - 1) / 2, w*h);
};

void conv_2d(float *scl, float *tcl,  int w, int h, int radius){
gaussBlur_4(scl, tcl, w, h, radius);
};
