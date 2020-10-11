
<script>

document.getElementById('file1').addEventListener('change', readFileAsString)
function readFileAsString() {

    var files = this.files;
    var re = /(?:\.([^.]+))?$/;
    var file_ext=files[0].name;
    file_ext = re.exec(file_ext)[1];

    if (files.length === 0) {
        console.log('No file is selected');
        return;
    }

    var reader = new FileReader();
    reader.onload = function(event) {
        //IF the file is csv:
        var DataString=event.target.result;


        //If the file is xlsx:
        if (file_ext == 'csv' || file_ext=='xlsx' || file_ext=='xls') {DataArray=fileReader(DataString)};
        // If the file is .txt for the colorplot
        if (file_ext == 'txt'){DataArray=read_txt(DataString)};
        console.log(DataArray);





    };
    //reader.readAsText(files[0]); OLD CASE FOR CSV FILES
    reader.readAsBinaryString(files[0]);
};


function parseCSV(str) {
    var arr = [];
    var quote = false;  // true means we're inside a quoted field

    // iterate over each character, keep track of current row and column (of the returned array)
    for (var row = 0, col = 0, c = 0; c < str.length; c++) {
        var cc = str[c], nc = str[c+1];        // current character, next character
        arr[row] = arr[row] || [];             // create a new row if necessary
        arr[row][col] = arr[row][col] || '';   // create a new column (start with empty string) if necessary

        // If the current character is a quotation mark, and we're inside a
        // quoted field, and the next character is also a quotation mark,
        // add a quotation mark to the current column and skip the next character
        if (cc == '"' && quote && nc == '"') { arr[row][col] += cc; ++c; continue; }

        // If it's just one quotation mark, begin/end quoted field
        if (cc == '"') { quote = !quote; continue; }

        // If it's a comma and we're not in a quoted field, move on to the next column
        if (cc == ',' && !quote) { ++col; continue; }

        // If it's a newline (CRLF) and we're not in a quoted field, skip the next character
        // and move on to the next row and move to column 0 of that new row
        if (cc == '\r' && nc == '\n' && !quote) { ++row; col = 0; ++c; continue; }

        // If it's a newline (LF or CR) and we're not in a quoted field,
        // move on to the next row and move to column 0 of that new row
        if (cc == '\n' && !quote) { ++row; col = 0; continue; }
        if (cc == '\r' && !quote) { ++row; col = 0; continue; }

        // Otherwise, append the current character to the current column
        arr[row][col] += cc;
    }
    return arr;
};


function fileReader(data) {
            //data = new Uint8Array(data);
            var roa;
            var workbook = XLSX.read(data, {type: 'binary'});

            var result = [];
            var i=0;
            workbook.SheetNames.forEach(function (sheetName) {
                roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {header: 1});
                if (roa.length) {result[i] = roa; i=i+1;}
            });
            // see the result, caution: it works after reader event is done.

            return result[0];
        };

function read_txt(DataString){
  var DataArray0=[];
  var TXTArray;
  var TXTtime;
  var TXTvoltage;
  var TXTcurrent;
  var TXTcurrent2;
  TXTArray=DataString.split('&');
  TXTtime=TXTArray[0].split('\t'); //Check the time array
  TXTtime=[TXTtime[0], TXTtime[1]].concat(TXTtime.slice(2,TXTtime.length).map(Number));
  TXTvoltage=TXTArray[1].split('\t');
  TXTvoltage=[TXTvoltage[0]].concat(TXTvoltage.slice(1,TXTvoltage.length).map(Number));
  TXTcurrent=TXTArray[2].split('\n');
  TXTcurrent=TXTcurrent.map(function(element){
    return element.split('\t');
  });

  TXTcurrent2=TXTcurrent.map(function(element){
    return element.map(Number)
  });
  TXTcurrent2[0][0]=TXTcurrent[0][0];
  DataArray0.push(TXTtime);
  DataArray0.push([TXTvoltage[0],TXTcurrent2[0][0]]);

  for (var i=1; i<TXTvoltage.length;i++){
    if (i==1){DataArray0.push([TXTvoltage[i],''].concat(TXTcurrent2[i-1].slice(1,TXTcurrent.length)));}
    else {DataArray0.push([TXTvoltage[i],''].concat(TXTcurrent2[i-1]));};
  };
  return DataArray0;
};




</script>
