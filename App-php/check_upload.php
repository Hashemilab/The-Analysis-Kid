<?php
global $upload_file_name;
$upload_file_name=$_FILES['file']['name'];
$upload_file_name = preg_replace("/[^A-Za-z0-9 \.\-_]/", '', $upload_file_name);
$allowed = array('csv','txt','xlsx');
$ext = pathinfo($upload_file_name, PATHINFO_EXTENSION);
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (is_uploaded_file($_FILES['file']['tmp_name']))
  {
    //First, Validate the file name
    if(empty($_FILES['file']['name']))
    {
      echo " Error loading the file: the file name is empty. \n";
    }
    //Too long file name?
    elseif(strlen ($_FILES['file']['name'])>100)
    {
      echo " Error loading the file: file name is too long. \n";
    }
    //set a limit to the file upload size
    elseif ($_FILES['file']['size'] > 32000000)
    {
      echo " Error loading the file: file size is above 32 Mb. \n ";
    }
    //Check extension of the file
    elseif (!in_array($ext, $allowed)) {
      echo "Error loading the file: the file extension is not compatible. \n";
    }
    //Save the file
    else{
      echo "File $upload_file_name has been uploaded. \n";
    }
  }
  else {
    echo "Upload a compatible file before opening the visualization tool.\n";
  }
}
else {
  echo "Upload a compatible file before opening the visualization tool. \n";
}
?>
