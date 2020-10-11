<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<script type="text/javascript" src="jquery-3.5.1.min.js"></script>
<title>Sample Page</title>

<script>



    var coln=[1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10];
    var signal=coln.join('+');
    console.log(signal);
    var content_API;
      var API_dir="https://py-dot-neurodatalab.nw.r.appspot.com/gradient?signal="+signal;
      var settings_API = {
        async: false,
        crossDomain: true,
        contentType: "text/plain",
        xhrFields: {withCredentials: true},
        url: API_dir,
        type: "GET"
      };
      $.ajax(settings_API).done(function (response_API) {
        content_API = response_API;
        //var Array_of_Peaks = content_API.split(" ");
        console.log(content_API);
    });


</script>
</head>
<body>
<h1>Sample Page</h1>

<div id="windSpeed">Wind speed: </div>
<div id="currentWeather">Current weather conditions: </div>

</body>
</html>
