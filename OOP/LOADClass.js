function HL_LOAD_DATA(status_id){

this.status_id= status_id;
this.DataArray = [];
this.number_of_files;
this.names_of_files = [];
// Assign the handle self to save the variables inside the callback.
var self = this;
// Callback to read the content of uploaded files.
this.read_files = function(){
var files = this.files;
var i;
self.number_of_files = files.length;
for (i=0; i < files.length; ++i) {
var reader = new FileReader();
var re = /(?:\.([^.]+))?$/;
var file_ext = files[i].name;
self.names_of_files.push(file_ext);
file_ext = re.exec(file_ext)[1];
reader.readAsBinaryString(files[i]);
reader.onload = function(event) {
var DataString = event.target.result;
//If the file is xlsx:
if (file_ext == 'csv' || file_ext=='xlsx' || file_ext=='xls') {self.DataArray.push(self.excel_reader(DataString))};
// If the file is .txt for the colorplot
if (file_ext == 'txt'){self.DataArray.push(self.txt_reader(DataString))};
document.getElementById(self.status_id).innerHTML = " "+i+"/"+self.number_of_files+" files uploaded.";
}};

document.getElementById(self.status_id).innerHTML = "Uploaded succesfully.";
};

// Method to read Excel file.
this.excel_reader = function(data){
var roa;
var workbook = XLSX.read(data, {type: 'binary'});
var result = [];
var i=0;
workbook.SheetNames.forEach(function (sheetName) {
roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {header: 1});
if (roa.length) {result[i] = roa; i=i+1;}
});
return result[0];
};
// Method to read plain text file.
this.txt_reader = function(data){
return data.split('\n').map(function(element){return element.split('\t')});
};
};
