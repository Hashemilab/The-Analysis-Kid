// Download the wrapper of the dashboard as pdf.
function downloadPDF(){
var element = document.getElementById('wrapper');
var opt = {
margin:       0,
filename:     'myfile.pdf',
image:        { type: 'png', quality: 1},
pagebreak: { mode: 'avoid-all' },
html2canvas:  { scale: 1 , backgroundColor:'#eff4f7'},
jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
};
html2pdf().set(opt).from(element).save();
};
// Short way to get element by id. 
function _(el) {
return document.getElementById(el);
}
