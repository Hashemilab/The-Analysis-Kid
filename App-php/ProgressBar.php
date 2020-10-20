<script>
function _(el) {
  return document.getElementById(el);
}

function uploadFile(fileID, progressBarID, statusID) {
  var file = _(fileID).files[0];
  var formdata = new FormData();
  formdata.append('file', file);
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler.bind(this, progressBarID, statusID), false);
  ajax.addEventListener("load", completeHandler.bind(this, progressBarID, statusID), false);
  ajax.addEventListener("error", errorHandler.bind(this, progressBarID, statusID), false);
  ajax.addEventListener("abort", abortHandler.bind(this, progressBarID, statusID), false);
  ajax.open("POST", "check_upload.php");
  ajax.send(formdata);
}

function progressHandler(progressBarID, statusID) {
  var event = this.event;
  var percent = (event.loaded / event.total) * 100;
  var mbloaded=(event.loaded/1000000).toFixed(2);
  _(progressBarID).value = Math.round(percent);
  _(statusID).innerHTML = " "+Math.round(percent) + "% ("+mbloaded+" MB)";
}

function completeHandler(progressBarID, statusID) {
  _(statusID).innerHTML = event.target.responseText;
  _(progressBarID).value = 0; //wil clear progress bar after successful uploa
}

function errorHandler(progressBarID, statusID) {
  _(statusID).innerHTML = "Upload Failed";
}

function abortHandler(progressBarID, statusID) {
  _(statusID).innerHTML = "Upload Aborted";
}
</script>
