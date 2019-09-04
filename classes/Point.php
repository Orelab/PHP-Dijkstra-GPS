<?php
namespace SimplonAuch\Gps;


class Point {

	private $name;

	private $x;

	private $y;


	public function __construct( $name, $x, $y ){
		$this->name = $name;
		$this->x = $x;
		$this->y = $y;
	}

	public function getName(){
		return $this->name;
	}

	public function getX(){
		return $this->x;
	}

	public function getY(){
		return $this->y;
	}

}


