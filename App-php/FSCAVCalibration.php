<!DOCTYPE html>
<html lang="en">
<title>FSCAV Calibration</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="JavaScriptPackages/plotly-latest.min.js"></script>
<script src="JavaScriptPackages/jquery-3.5.1.min.js"></script>
<script src="JavaScriptPackages/ArrayMethods.js"></script>
<script src="JavaScriptPackages/DashboardMethods.js"></script>
<script src = "OOP/FSCAVObject.js"></script>
<head>
<title>FSCAV Calibration</title>
<link rel="shortcut icon" href="Images/cv.png"/>
<link type="text/css" rel="stylesheet" href="Styling/styles.css"/>
<link rel="stylesheet" href="Styling/bootstrap.min.css"/>
<link rel="stylesheet" href="Styling/buttons.css"/>
</head>

<script>
// Fading out of loading icon in applications.
$(window).on('load', function () {
$(".se-pre-con").fadeOut("slow");
});
</script>

<body>
<div class="header">
<h1>FSCAV Calibration</h1>
</div>
<br>
<div style = "text-align: center">
<label id="slider_label" for="plot_slider">1</label>
</div>
<div style = "text-align: center">
<button>
<a id="previous_button" onclick="previous_pushed()" >← Prev.</a>
</button>
<input type="range" class="custom-range w-25" id="plot_slider" min="1" max="10" value="1" step = "1" onchange="slider_changed()">
<button>
<a id="next_button" onclick="next_pushed()">Next →</a>
</button>
</div>

<div id="loading" class="se-pre-con"></div>
<div id="graph"></div>
<p class="footdash">Application created by The Hashemi Lab, Imperial College London.</p>
</body>
<script>
//Buttons callbacks.
function previous_pushed(){
document.getElementById('plot_slider').stepDown();
slider_changed();
};
function next_pushed(){
document.getElementById('plot_slider').stepUp();
slider_changed();
};
function slider_changed(){
$("#slider_label").html($('#plot_slider').val());
};
</script>
<script>
// Create FSCAV Object.
let Data = new FSCAV_DATA(DataArray, neurotransmitter, v_units, c_units, frequency);


































function makeTrace(i) {
    return {
        y: Array.apply(null, Array(10)).map(() => Math.random()),
        line: {
            shape: 'spline' ,
            color: 'red'
        },
        visible: i === 0,
        name: 'Data set ' + i,

    };
}

Plotly.plot('graph', [0, 1, 2, 3].map(makeTrace), {
    updatemenus: [{
        y: 0.8,
        yanchor: 'top',
        buttons: [{
            method: 'restyle',
            args: ['line.color', 'red'],
            label: 'red'
        }, {
            method: 'restyle',
            args: ['line.color', 'blue'],
            label: 'blue'
        }, {
            method: 'restyle',
            args: ['line.color', 'green'],
            label: 'green'
        }]
    }, {
        y: 1,
        yanchor: 'top',
        buttons: [{
            method: 'restyle',
            args: ['visible', [true, false, false, false]],
            label: 'Data set 0'
        }, {
            method: 'restyle',
            args: ['visible', [false, true, false, false]],
            label: 'Data set 1'
        }, {
            method: 'restyle',
            args: ['visible', [false, false, true, false]],
            label: 'Data set 2'
        }, {
            method: 'restyle',
            args: ['visible', [false, false, false, true]],
            label: 'Data set 3'
        }]
    }],
});
</script>
</html>
