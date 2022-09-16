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
} else if (file_ext == 'json'){
self.data_array.push(self.json_reader(arrbuf));
} else {return};
self.names_of_files.push(file.name);
++self.number_of_files;
//Check data added has even number of values.
return self.number_of_files;
};

// Method to read Excel file.
//this.excel_reader = function(arrbuf){
//var roa;
//var workbook = XLSX.read(arrbuf, {type: 'array'});
//var result = [];
//var i=0;
//workbook.SheetNames.forEach(function (sheetName) {
//roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {header: 1});
//if (roa.length) {result[i] = roa; i=i+1;}
//});
//if(result.length>1){return result}
//else{return result[0];};
//};


//------------ TEST
this.excel_reader = function(arrbuf){
var roa;
var workbook = XLSX.read(arrbuf, {type: 'array'});
var result = [];
roa = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]], {header: 1});
if (roa.length) {result = roa}
return result;
};
// ----------------- TEST


// Method to read plain text file.
this.txt_reader = function(arrbuf){
var text = self.array_buffer_to_string(arrbuf).split('\n'), tmp = [], tmp2;
for(var i=0; i<text.length;++i){if(text[i].length>0){
tmp[i] = text[i].split('\t');
for(var j=0; j<tmp[i].length;++j){
tmp2 = parseFloat(tmp[i][j]);
if(isNaN(tmp2)){tmp[i].splice(j,1)}
else {tmp[i][j] = tmp2};
};
}};
return tmp;
};

this.json_reader = function(arrbuf) {
return JSON.parse(self.array_buffer_to_string(arrbuf));
};
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

this.order_files_by_name = function(){[this.names_of_files, this.data_array] = sort_arrays([this.names_of_files, this.data_array])};


};
