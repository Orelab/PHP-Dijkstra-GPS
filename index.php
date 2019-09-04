<?php

/*


	== Séquence GPS ==


	Objectifs :
		apprentissage/révision Objets
		réaliser un diagramme UML
		appliquer en PHP

	Déroulé :

	Enoncé :
		Modélisez un diagramme des classes permettant de modéliser
		la structure d'une carte avec pour objectif de créer un GPS
		simple. Réalisez ensuite l'implémentation en PHP et imprimez 
		les données de la carte en format texte.

		Découvrez et intégrez l'algorithme de Dijkstra pour trouver
		le chemin le plus court entre deux points.

		Générez une map virtuelle avec D3js.

	Documents fournis :
		les images plan1.png et plan2.png
		Captures d'écrans du programme fonctionnel

	Bonus :
		Pour les rapides pour qui l'objet est aquis, cet exercice
		propose des challenges additionnels (algorithme de Dijkstra,
		et découverte de D3js). Il doit donc y en avoir pour tout 
		le monde.


*/



include "classes/Point.php";
include "classes/Connexion.php";
include "classes/Map.php";
include "classes/Dijkstra.php";

use SimplonAuch\Gps;
use Fisharebest\Algorithm;



$map = new SimplonAuch\Gps\Map();

$map->add_point("A",736,83);
$map->add_point("B",900,94);
$map->add_point("C",707,278);
$map->add_point("D",933,337);
$map->add_point("E",1174,396);
$map->add_point("F",1557,442);
$map->add_point("G",1533,526);
$map->add_point("H",1177,624);
$map->add_point("I",587,648);
$map->add_point("J",932,681);
$map->add_point("K",1433,706);
$map->add_point("L",878,730);
$map->add_point("M",491,876);
$map->add_point("N",1066,1054);
$map->add_point("O",697,1162);
$map->add_point("P",1263,1237);
$map->add_point("Q",341,1252);
$map->add_point("R",282,1382);
$map->add_point("S",809,1562);
$map->add_point("T",162,1658);
$map->add_point("U",618,1667);
$map->add_point("V",600,1817);
$map->add_point("W",1018,1836);
$map->add_point("X",54,1925);
$map->add_point("Y",905,2242);

$map->connect("A","B",true);
$map->connect("B","E",true);
$map->connect("B","F",true);
$map->connect("C","A");
$map->connect("C","D",true);
$map->connect("D","E",true);
$map->connect("D","J",true);
$map->connect("E","F",true);
$map->connect("E","H",true);
$map->connect("F","G",true);
$map->connect("G","K",true);
$map->connect("H","J",true);
$map->connect("H","K",true);
$map->connect("I","C");
$map->connect("I","L",true);
$map->connect("J","H",true);
$map->connect("J","L",true);
$map->connect("K","N",true);
$map->connect("K","P",true);
$map->connect("L","O",true);
$map->connect("M","I");
$map->connect("M","O",true);
$map->connect("N","P",true);
$map->connect("N","S",true);
$map->connect("O","S",true);
$map->connect("P","W",true);
$map->connect("Q","M");
$map->connect("Q","S",true);
$map->connect("R","Q");
$map->connect("R","U",true);
$map->connect("R","T",true);
$map->connect("S","U",true);
$map->connect("S","W",true);
$map->connect("T","V",true);
$map->connect("T","X",true);
$map->connect("U","V",true);
$map->connect("W","Y",true);
$map->connect("X","Y",true);


$data_d3js = $map->generate_d3js_graph();

$data_dijkstra = $map->generate_dikstra_graph();

$dijkstra = new Fisharebest\Algorithm\Dijkstra( $data_dijkstra );
$path = $dijkstra->shortestPaths( $_REQUEST["from"], $_REQUEST["to"] );



?><!DOCTYPE html>
<html>
<head>
	<title>A tiny GPS</title>
	<link rel="stylesheet" href="assets/style.css"/>
	<script type="text/javascript" src="assets/d3.min.js"></script>
</head>
<body>

	<svg width="831" height="1138"></svg>

	<form id="theTrip" method="get" autocomplete="off">
		<input type="text" name="from" value="" required placeholder="from"/> :
		<input type="text" name="to" value="" required placeholder="to"/>
		<input type="submit" name="go" value="GO"/>
	</form>

	<script type="text/javascript">
		var path = <?=json_encode($path[0]) ?>;
		var graph = <?=json_encode($data_d3js) ?>;
	</script>

	<script type="text/javascript" src="assets/app.js"></script>
</body>
</html>
