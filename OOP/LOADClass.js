// Class to check and save data loaded into applications.
function HL_LOAD_DATA(status_id){
this.status_id= status_id;
this.data_array = [];
this.number_of_files = 0;
this.names_of_files = [];
// Assign the handle self to save the variables inside the callback.
var self = this;
// Callback to read the content of uploaded files. 'this' refers to the callback event.
this.read_files = function(){
// Reset stored data if reloading.
var files = this.files;
if(files.length == 0){return;}
else if (self.number_of_files != 0){self.reset_loaded_data()};

for (let file of files){
(new Blob([file])).arrayBuffer().then(arrbuf=> self.parse_file(arrbuf, file)).then(nfiles => self.status_message(nfiles, files));
};
};
// Function that converts the text into array depending on format.
this.parse_file = function(arrbuf, file){
var re = /(?:\.([^.]+))?$/;
var file_ext = re.exec(file.name)[1];
if (file_ext == 'csv' || file_ext=='xlsx' || file_ext=='xls') {
self.data_array.push(self.excel_reader(arrbuf));
} else if (file_ext == 'txt'){
self.data_array.push(self.txt_reader(arrbuf));
} else {return};
self.names_of_files.push(file.name);
++self.number_of_files;
//Check data added has even number of values.
self.check_data_is_even();
return self.number_of_files;
};

// Method to read Excel file.
this.excel_reader = function(arrbuf){
var roa;
var workbook = XLSX.read(arrbuf, {type: 'array'});
var result = [];
var i=0;
workbook.SheetNames.forEach(function (sheetName) {
roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {header: 1});
if (roa.length) {result[i] = roa; i=i+1;}
});
return result[0];
};
// Method to read plain text file.
this.txt_reader = function(arrbuf){
var text = self.array_buffer_to_string(arrbuf).split('\n');
return parse_array_to_float(text.filter(function(element){return element.length>0}).map(function(element){return element.split('\t')}))};
// Method to reset the loaded data every time we read new files.
this.reset_loaded_data = function(){
self.data_array = [];
self.number_of_files = 0;
self.names_of_files = [];
};

this.status_message = function(nfiles, files){
var total = files.length;
_(self.status_id).innerHTML = nfiles+"/"+total+" uploaded succesfully ";
if (nfiles == total){_(self.status_id).innerHTML += "&#10004"};
};

this.array_buffer_to_string = function(buffer){
var bufView = new Int8Array(buffer);
var length = bufView.length;
var result = '';
var addition = Math.pow(2,16)-1;
for(var i = 0;i<length;i+=addition){
if(i + addition > length){addition = length - i;}
result += String.fromCharCode.apply(null, bufView.subarray(i,i+addition));
}
return result;
};

this.check_data_is_even = function(){
// If data is odd, pad the last values to make it even.
var array = self.data_array[self.data_array.length-1];
if(array[0].length % 2 !== 0){array.map(x => x.push(x[x.length - 1]))};
if(array.length % 2 !== 0){array.push(array[array.length - 1])};
}

this.export_data = function(){
var ws_name, ws, wb = XLSX.utils.book_new();
for(var i=0;i<this.number_of_files;++i){
ws_name = this.names_of_files[i];
ws = XLSX.utils.aoa_to_sheet(this.data_array[i]);
XLSX.utils.book_append_sheet(wb, ws, ws_name);
}
var filename = "Filtered_color_plots_hashemilab.xlsx";
XLSX.writeFile(wb, filename);
}
};
