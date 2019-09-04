<?php
namespace SimplonAuch\Gps;



class Map {

	/*
		array of objects Point
	*/
	private $points = [];


	/*
		array of objects Connexion
	*/
	private $connexions = [];


	public function __construct(){
	}


	public function add_point( $name, $x, $y ){
		$this->points[ $name ] = new Point($name,$x,$y);
	}


	public function get_point( $name ){
		$classname = (new \ReflectionClass($this->points[$name]))->getShortName();

		if( $classname != "Point" ){
			throw new \Exception("Point $name not found. " . print_r($this,1) );
		}

		return $this->points[$name];
	}


	public function connect( $point1, $point2, $bilateral=false ){
		$p1 = $this->get_point( $point1 );
		$p2 = $this->get_point( $point2 );

		$this->connexions[] = new Connexion( $p1, $p2 );

		if( $bilateral ){
			$this->connexions[] = new Connexion( $p2, $p1 );
		}
	}


	public function generate_dikstra_graph(){
		$graph = [];

		foreach( $this->connexions as $c ){
			$from = $c->getFrom()->getName();
			$to = $c->getTo()->getName();

			if( ! is_array($graph[$from]) ){
				$graph[$from] = [];
			}

			$graph[$from][$to] = $c->getDistance();
		}

		return $graph;
	}


	public function generate_d3js_graph(){
		$nodes = [];
		$links = [];

		foreach( $this->points as $p ){
			$nodes[] = [
				"id"     => $p->getName(),
				"x_axis" => $p->getX() / 2,
				"y_axis" => $p->getY() / 2,
				"radius" => 8,
				"color"  => "red"
			];
		}

		foreach( $this->connexions as $c ){
			$links[] = [
				"source"   => $c->getFrom()->getName(),
				"target"   => $c->getTo()->getName(),
				"distance" => $c->getDistance() / 2
			];
		}

		return [
			"nodes" => $nodes,
			"links" => $links
		];
	}


}


