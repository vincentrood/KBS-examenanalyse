<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Resultaat voorbeeld met flot plugin</title>
	<link href="../includes/libs/flot/examples/examples.css" rel="stylesheet" type="text/css">
	<style type="text/css">

	.demo-container {
		position: relative;
		height: 400px;
	}

	#placeholder {
		width: 550px;
	}

	#menu {
		position: absolute;
		top: 20px;
		left: 625px;
		bottom: 20px;
		right: 20px;
		width: 200px;
	}

	#menu button {
		display: inline-block;
		width: 200px;
		padding: 3px 0 2px 0;
		margin-bottom: 4px;
		background: #eee;
		border: 1px solid #999;
		border-radius: 2px;
		font-size: 16px;
		-o-box-shadow: 0 1px 2px rgba(0,0,0,0.15);
		-ms-box-shadow: 0 1px 2px rgba(0,0,0,0.15);
		-moz-box-shadow: 0 1px 2px rgba(0,0,0,0.15);
		-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.15);
		box-shadow: 0 1px 2px rgba(0,0,0,0.15);
		cursor: pointer;
	}

	#description {
		margin: 15px 10px 20px 10px;
	}

	#code {
		display: block;
		width: 870px;
		padding: 15px;
		margin: 10px auto;
		border: 1px dashed #999;
		background-color: #f8f8f8;
		font-size: 16px;
		line-height: 20px;
		color: #666;
	}

	ul {
		font-size: 10pt;
	}

	ul li {
		margin-bottom: 0.5em;
	}

	ul.options li {
		list-style: none;
		margin-bottom: 1em;
	}

	ul li i {
		color: #999;
	}

	</style>
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../../excanvas.min.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="../includes/libs/flot/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="../includes/libs/flot/jquery.flot.js"></script>
	<script language="javascript" type="text/javascript" src="../includes/libs/flot/jquery.flot.pie.js"></script>
	<script type="text/javascript">

	$(function() {

		// Example Data
		var data = [
		<?php
		$rand = rand(2,6);
		for($x = 0;$x < $rand;$x++){
		?>
			{ label: "Examen <?php echo $x;?>",  data: <?php echo rand(1,100);?>}
			<?php
			if($rand != $x){
				echo",";
			}
			?>
		<?php
		}
		?>
		];
		//var data = [
		//	{ label: "Series1",  data: [[1,10]]},
		//	{ label: "Series2",  data: [[1,30]]},
		//	{ label: "Series3",  data: [[1,90]]},
		//	{ label: "Series4",  data: [[1,70]]},
		//	{ label: "Series5",  data: [[1,80]]},
		//	{ label: "Series6",  data: [[1,0]]}
		//];

		//var data = [
		//	{ label: "Series A",  data: 0.2063},
		//	{ label: "Series B",  data: 38888}
		//];

		// Randomly Generated Data
		/*
		var data = [],
			series = Math.floor(Math.random() * 6) + 3;

		for (var i = 0; i < series; i++) {
			data[i] = {
				label: "Series" + (i + 1),
				data: Math.floor(Math.random() * 100) + 1
			}
		}
		*/
		var placeholder = $("#placeholder");

		
		

		$("#example-1").click(function() {

			placeholder.unbind();

			$("#title").text("Resultaten");
			$("#description").text("The pie can be tilted at an angle.");

			$.plot(placeholder, data, {
				series: {
					pie: { 
						show: true,
						radius: 1,
						tilt: 0.5,
						label: {
							show: true,
							radius: 1,
							formatter: labelFormatter,
							background: {
								opacity: 0.8
							}
						},
						combine: {
							color: "#999",
							threshold: 0.1
						}
					}
				},
				legend: {
					show: false
				}
			});

			setCode([
				"$.plot('#placeholder', data, {",
				"    series: {",
				"        pie: {",
				"            show: true,",
				"            radius: 1,",
				"            tilt: 0.5,",
				"            label: {",
				"                show: true,",
				"                radius: 1,",
				"                formatter: labelFormatter,",
				"                background: {",
				"                    opacity: 0.8",
				"                }",
				"            },",
				"            combine: {",
				"                color: '#999',",
				"                threshold: 0.1",
				"            }",
				"        }",
				"    },",
				"    legend: {",
				"        show: false",
				"    }",
				"});",
			]);
		});

		

		// Show the initial default chart

		$("#example-1").click();

		// Add the Flot version string to the footer

		$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
	});

	// A custom label formatter used by several of the plots

	function labelFormatter(label, series) {
		return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
	}

	//

	function setCode(lines) {
		$("#code").text(lines.join("\n"));
	}

	</script>
</head>
<body>

	<div id="header">
		<h2>Resultaat voorbeeld met flot plugin</h2>
		<p>Een voorbeelt, de examendata is gegenereerd door php</p>
	</div>

	<div id="content">

		<h3 id="title"></h3>
		<div class="demo-container">
			<div id="placeholder" class="demo-placeholder"></div>
			<div id="menu">
				<button id="example-1">Default Options</button>
				
			</div>
		</div>


	</div>

</body>
</html>
