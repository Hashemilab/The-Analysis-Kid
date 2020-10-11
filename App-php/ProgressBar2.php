<script>
function _(el) {
  return document.getElementById(el);
}

function uploadFile2() {
  var file2 = _("file2").files[0];
  var formdata = new FormData();
  formdata.append("file2", file2);
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler2, false);
  ajax.addEventListener("load", completeHandler2, false);
  ajax.addEventListener("error", errorHandler2, false);
  ajax.addEventListener("abort", abortHandler2, false);
  ajax.open("POST", "save_csv2.php");
  ajax.send(formdata);


}

function progressHandler2(event) {
  var percent = (event.loaded / event.total) * 100;
  var mbloaded=(event.loaded/1000000).toFixed(2);
  _("progressBar2").value = Math.round(percent);
  _("status2").innerHTML = " "+Math.round(percent) + "% ("+mbloaded+" MB)";
}

function completeHandler2(event) {
  _("status2").innerHTML = event.target.responseText;
  _("progressBar2").value = 0; //wil clear progress bar after successful uploa
}

function errorHandler2(event) {
  _("status2").innerHTML = "Upload Failed";
}

function abortHandler2(event) {
  _("status2").innerHTML = "Upload Aborted";
}
</script>
