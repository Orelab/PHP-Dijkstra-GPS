<?php

/*

	== GPS ==
	1/ modélisation UML ()
	2/ Découvrir et intégrer Dijkstra
	3/ créer  points/connexions
	4/ générer une map virtuelle avec D3js


*/


namespace Fisharebest\Algorithm;

include "algorithm/src/Dijkstra.php";
include "data/points.php";
include "data/connexions.php";



$divider = 2;

function calculate_distances( $points, &$connexions ){

	function distance_2_points( $xa, $ya, $xb, $yb ){
		return sqrt( pow($xb-$xa,2) + pow($yx-$ya,2) );	
	}

	foreach( $connexions as &$c ){
		$p1 = $points[$c["from"]];
		$p2 = $points[$c["to"]];

		if( ! $c["distance"] ){
			$c["distance"] = distance_2_points( $p1["x"], $p1["y"], $p2["x"], $p2["y"] );
		}
	}
}


function toDijkstra( $connexions ){
	$graph = [];

	foreach( $connexions as $c ){
		if( ! is_array($graph[$c["from"]]) ){
			$graph[$c["from"]] = [];
		}

		$graph[$c["from"]][$c["to"]] = $c["distance"];
	}

	return $graph;
}



function toD3js( $points, $connexions ){
	global $divider;

	$nodes = [];
	$links = [];

	foreach( $points as $key => $val ){
		$nodes[] = [
			"id"     => $key,
			"x_axis" => $val["x"] / $divider,
			"y_axis" => $val["y"] / $divider,
			"radius" => 8,
			"color"  => "red"
		];
	}

	foreach( $connexions as $c ){
		$links[] = [
			"source"   => $c["from"],
			"target"   => $c["to"],
			"distance" => $c["distance"] / $divider
		];
	}

	return [
		"nodes" => $nodes,
		"links" => $links
	];
}


calculate_distances( $points, $connexions );

$data_dijkstra = toDijkstra( $connexions );

$data_d3js = toD3js( $points, $connexions );

$dijkstra = new Dijkstra( $data_dijkstra );

$path = $dijkstra->shortestPaths( $_REQUEST["from"], $_REQUEST["to"] );

?><!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<style type="text/css">
		img {
			width: <?=100/$divider?>%;
			vertical-align: top;
			display: inline-block;
		}
		#theTrip {
			position: fixed;
			vertical-align: top;
			display: inline-block;
		}
		ul {
			font-family: monospace;
		}
		input {
			max-width: 50px;
			text-align: center;
		}
		svg {
			background: url(maps/plan1.png) no-repeat top left;
			background-size: contain;
		}
		circle {
			cursor: pointer;
		}
		line {
			stroke-width: 8px;
			stroke-opacity: .7;
		}
		text {
			cursor: pointer;
			font-family: "sans-serif";
			font-size: 14px;
			font-weight: bold;
			fill: "red";
		}
		circle {
			stroke: #fff;
			stroke-width: 1.5px;
		}
	</style>




<!--
	<img src="maps/plan1.png" />
-->
	<svg width="<?=1662/$divider?>" height="<?=2277/$divider?>"></svg>


	<form id="theTrip" method="get" autocomplete="off">
		<input type="text" name="from" value="" required placeholder="from"/> :
		<input type="text" name="to" value="" required placeholder="to"/>
		<input type="submit" name="go" value="GO"/>
	</form>



	<script src="d3/d3.min.js"></script>

	<script>

	var path = <?=json_encode($path)?>[0];

	var graph = <?=json_encode($data_d3js)?>;

	var svg = d3.select("svg"),
	    width = +svg.attr("width"),
	    height = +svg.attr("height");

	var link = svg.selectAll(".link")
		.data(graph.links)
		.enter()
		.append("line")
	  	  .attr("x1", function(d) { return getNode(d.source)["x_axis"]; })
	      .attr("y1", function(d) { return getNode(d.source)["y_axis"]; })
	      .attr("x2", function(d) { return getNode(d.target)["x_axis"]; })
	      .attr("y2", function(d) { return getNode(d.target)["y_axis"]; })
		  .attr("stroke", function (d) { return setColor(d.source, d.target); });

	var node = svg.selectAll(".node")
		.data(graph.nodes)
		.enter()
		.append("circle")
			.attr("cx", function (d) { return d.x_axis; })
			.attr("cy", function (d) { return d.y_axis; })
			.attr("r", function (d) { return d.radius; })
			.attr("fill", function (d) { return d.color; })
			.on("click", updateForm);


	var text = svg.selectAll(".text")
		.data(graph.nodes)
		.enter()
		.append("text")
	      .attr("x", function (d) { return d.x_axis + 8; })
    	  .attr("y", function (d) { return d.y_axis + 5; })
    	  .text(function(d) { return d.id })
    	  .on("click", updateForm);

	function getNode( name ){
		for( i in graph.nodes ){
			if( graph.nodes[i].id == name ){
				return graph.nodes[i];
			}
		}
		return false;
	}

	function setColor( source, target ){
		for( i=0 ; i<path.length ; i++ ){
			if( i==path.length) return //"#888";

			if( path[i]==source && path[i+1]==target ) return "red";
			if( path[i]==target && path[i+1]==source ) return "red";
		}
//		return "#888";
	}

	function updateForm(d, i){
		from = document.getElementsByName('from')[0];
		to = document.getElementsByName('to')[0];

		if( from.value == '' ){
			from.value = d.id;
		} else {
			to.value = d.id;
			console.log( document.forms[0] );
			document.forms[0].submit();
		}
	}

	</script>




</body>
</html>
