<?php

	namespace Fisharebest\Algorithm;

	include "algorithm/src/Dijkstra.php";



	/*
		Init 2D alphabetical array
	*/
	$graph = array_flip(range('A', 'Y'));

	foreach( $graph as &$g ){
		$g = [];
	}


	/*
		Fullfilling the graph
	*/

	$graph["A"]["B"] = 1;
	$graph["A"]["C"] = 1.5;
	$graph["B"]["E"] = 3;
	$graph["B"]["F"] = 5;
	$graph["C"]["D"] = 1.2;
	$graph["C"]["I"] = 2.5;
	$graph["D"]["E"] = 1.6;
	$graph["D"]["J"] = 2.2;
	$graph["E"]["G"] = 2.3;
	$graph["E"]["H"] = 1.4;
	$graph["F"]["G"] = 0.5;
	$graph["G"]["K"] = 1.2;
	$graph["H"]["J"] = 1.5;
	$graph["H"]["K"] = 1.9;
	$graph["I"]["L"] = 2;
	$graph["I"]["M"] = 1.7;
	$graph["J"]["L"] = 0.7;
	$graph["K"]["N"] = 3.5;
	$graph["K"]["P"] = 3.4;
	$graph["L"]["O"] = 3;
	$graph["M"]["O"] = 2.1;
	$graph["M"]["Q"] = 2.7;
	$graph["N"]["P"] = 1.7;
	$graph["O"]["S"] = 2.8;
	$graph["P"]["W"] = 4.3;
	$graph["Q"]["R"] = 0.9;
	$graph["Q"]["S"] = 3.6;
	$graph["R"]["T"] = 2;
	$graph["R"]["U"] = 3;
	$graph["S"]["U"] = 1.3;
	$graph["S"]["W"] = 2.3;
	$graph["T"]["X"] = 2;
	$graph["T"]["V"] = 3;
	$graph["U"]["V"] = 1;
	$graph["W"]["Y"] = 2.9;
	$graph["X"]["Y"] = 6;



	/*
		Here and back
	*/
	function flipDiagonally($arr) {
	    $out = array();
	    foreach ($arr as $key => $subarr) {
	        foreach ($subarr as $subkey => $subvalue) {
	            $out[$subkey][$key] = $subvalue;
	        }
	    }
	    return $out;
	}

	$graph2 = flipDiagonally($graph);
	
	foreach( $graph2 as $key => $val ){
		$graph[$key] = 	array_merge( $graph[$key], $val );
	}



	require('data/points.php');
	require('data/connexions.php');



//print_r( $graph );

?><!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<style type="text/css">
		img {
			vertical-align: top;
			max-width: 900px;
			display: inline-block;
		}
		p {
			vertical-align: top;
			display: inline-block;
		}
	</style>

	<img src="maps/plan2.png" />

	<p>
	<?php

	$dijkstra = new Dijkstra( $graph );

	function show( $from, $to ){
		global $dijkstra;
		echo "<br/><strong>de $from à $to : </strong>";
		$p = $dijkstra->shortestPaths($from, $to);
		print_r( implode("-",$p[0]) );
	}

	show("A", "Y");
	show("M", "W");
	show("T", "J");
	show("H", "U");
	?>
	</p>


</body>
</html>
