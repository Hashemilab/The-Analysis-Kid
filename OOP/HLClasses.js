class HL_FSCV_ARRAY{
constructor(data, units, name){
this.units = units;
this.name = name;
this.array = data;
}
};

class HL_FSCV_TIME{
constructor(frequency, length, units, name){
this.units = units;
this.name = name;
this.array = makeArr(0,(length-1)/frequency, length);
}
};

class HL_FSCV_COLORPALETTE{
constructor(){
this.colors = ['#1f77b4','#ff7f0e','#2ca02c','#d62728','#9467bd','#8c564b','#e377c2','#7f7f7f','#bcbd22','#17becf','#c26591','#0a9ebd','#3f60b0', '#d59887', '#54024f', '#fece11', '#456398', '#5ddbe8', '#e0783e', '#d1fc63'];
this.parula = [[0,'#3E26A8'],[0.10196,'#4744E8'],[0.2,'#4367FD'],[0.30196,'#2D8CF3'],[0.4,'#1CAADF'],[0.50196,'#14BEB8'],[0.6,'#48CB86'],[0.70196,'#A1C840'],[0.8,'#EABA30'],[0.90196,'#FAD52E'],[1,'#F9FB15']];
this.custom = [[0, 'rgb(0, 0, 240)'],[0.2478, 'rgb(0, 2, 39)'], [0.2505, 'rgb(245, 213, 1)'],[0.66, 'rgb(168, 98, 0)'],
[0.65, 'rgb(76, 2, 69)'],[0.7003, 'rgb(0, 182, 136)'],[0.8579, 'rgb(0, 138, 30)'], [1, 'rgb(1, 248, 1)']];
};
};

class HL_PLOT_SETTINGS{
constructor(){
this.plot_configuration = {
showEditInChartStudio: true,
plotlyServerURL: "https://chart-studio.plotly.com",
displayModeBar: true,
displaylogo: false,
responsive: true,
toImageButtonOptions: {
format: 'svg',
filename: 'plot',
height: 600,
width: 800,
scale: 1
}};

this.plot_layout = {
autosize: true,
title: {
text: '<b> Blank </b>',
font: {
size: 20,
family:'Arial'
},
x: 0.05,
y: 1.2,
xanchor: 'left',
yanchor: 'bottom',
}
};
};
};
