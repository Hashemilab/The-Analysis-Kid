<script>
function _(el) {
  return document.getElementById(el);
}

function uploadFile() {
  var file = _("file1").files[0];
  var formdata = new FormData();
  formdata.append("file1", file);
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST", "save_csv.php"); 
  ajax.send(formdata);

  
}

function progressHandler(event) {
  var percent = (event.loaded / event.total) * 100;
  var mbloaded=(event.loaded/1000000).toFixed(2);
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = " "+Math.round(percent) + "% ("+mbloaded+" MB)"; 
}

function completeHandler(event) {
  _("status").innerHTML = event.target.responseText;
  _("progressBar").value = 0; //wil clear progress bar after successful uploa
}

function errorHandler(event) {
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event) {
  _("status").innerHTML = "Upload Aborted";
}
</script>