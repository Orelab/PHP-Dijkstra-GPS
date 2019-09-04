<?php
namespace SimplonAuch\Gps;


class Connexion {

	/*
		object Point
	*/
	private $from;

	/*
		object Point
	*/
	private $to;

	/*
		float
	*/
	private $distance = 0;


	/*
		$point1 : object Point
		$point2 : object Point
	*/
	public function __construct( &$from, &$to ){
		$this->from = $from;
		$this->to = $to;

		$this->distance = $this->calculate_distance( $from, $to );
	}

	private function calculate_distance( &$p1, &$p2 ){
		$xa = $p1->getX();
		$ya = $p1->getY();
		$xb = $p2->getX();
		$yb = $p2->getY();

		return sqrt( pow($xb-$xa,2) + pow($yb-$ya,2) );
	}


	public function getFrom(){
		return $this->from;
	}

	public function getTo(){
		return $this->to;
	}

	public function getDistance(){
		return $this->distance;
	}

}