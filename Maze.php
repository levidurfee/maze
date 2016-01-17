<?php

class Maze {
	public $m;
	public $numRows = 6;
	public $perRow = 6;
	public $k = 1;
	public $solution;
	public $o = 'green';
	public $next;
	public $path = [];
	public $checked = [];
	public $deadend = false;
	public $startFound = false;
	public $t;
	protected $order = [];
	protected $solved = false;

	public function __construct() {
		$this->order = [
			0 => "moveRight",
			1 => "moveDown",
			2 => "moveLeft",
		];
	}
	public function traverseMaze() {
		$i = 1;
		$skip = false;
		while(!$this->solved) {
			$this->checkRunAway();
			if(!in_array($i, $this->checked)) {
				if($this->startFound == false) {
					if($this->checkOpen($i)) {
						$this->path[$i] = $i;
						$this->addClass($i, 'green');
						$this->startFound = true;
						if($this->checkNextMove($i)) {
							$i = $this->t;
							$skip = true;
						}
					}
					if(!$skip) {
						$i++;
					}
				} else {
					if($this->checkNextMove($i)) {
						$i = $this->t;
					}
				}
				if($this->deadend) {
					$i = 1;
					$this->path = [];
					$this->checked = [];
					$this->m = $this->makeRed($this->m);
				}
			}
			if(isset($this->m[$i]['win'])) {
				$this->solved = true;
			}
		}
	}

	protected function checkNextMove($i) {
		shuffle($this->order);
		# need to call these methods in a random order.

		# need to change the index to see if i can move right
		# if i can, change the index and start over
		# if i can't, might be a dead end
		if($this->{$this->order[0]}($i)) {
			$this->path[$this->t] = $this->t;
			$this->addClass($this->t, 'green');
			return true;
		}

		# need to change the index to see if i can move down
		# if i can, change index and start over
		# if i can't, might be dead
		if($this->{$this->order[1]}($i)) {
			$this->path[$this->t] = $this->t;
			$this->addClass($this->t, 'green');
			return true;
		}

		if($this->{$this->order[2]}($i)) {
			$this->path[$this->t] = $this->t;
			$this->addClass($this->t, 'green');
			return true;
		}
	}

	protected function moveLeft($i) {
		if($this->m[$i]['rowBlockId'] != 1) {
			$t = $i - 1;
			if( ($this->checkOpen($t)) AND (!in_array($t, $this->path)) ) {
				$this->t = $t;
				$this->deadend = false;
				return true;
			} else {
				$this->checked[$this->t] = $this->t;
				$this->deadend = true;
			}
		}
	}

	protected function moveRight($i) {
		if($i < ($this->perRow * $this->m[$i]['rowId'])) {
			$t = $i + 1;
			if( ($this->checkOpen($t)) AND (!in_array($t, $this->path)) ) {
				$this->t = $t;
				$this->deadend = false;
				return true;
			} else {
				$this->t = $i;
				$this->checked[$this->t] = $this->t;
				$this->deadend = true;
			}
		}
	}

	protected function moveDown($i) {

		if($this->m[$i]['rowId'] != $this->numRows) {
			$t = $i + $this->perRow;
			if( ($this->checkOpen($t)) AND (!in_array($t, $this->path)) ) {
				$this->t = $t;
				$this->deadend = false;
				return true;
			} else {
				$this->checked[$this->t] = $this->t;
				$this->deadend = true;
			}
		}
	}

	protected function checkOpen($o) {
		if($this->m[$o]['open'] === true) {
			return true;
		}
	}

	public static function checkIfOpen($o) {
		if($o) {
			return 'open';
		} else {
			return 'no';
		}
	}

	protected function addClass($i, $class) {
		$this->m[$i]['class'] = $class;
	}

	protected function makeRed($a) {
		for($i=0;$i<count($a);$i++) {
			if(isset($a[$i]['class'])) {
				$a[$i]['class'] = 'red';
			}
		}
		return $a;
	}

	protected function checkRunAway() {
		$this->k++;
		if($this->k > 1000) {
			echo '<strong>Not solved ' . $this->k . ' tries</strong><br />';
			echo '<h2>Path</h2><pre>';
			var_dump($this->path);
			echo '</pre>';
			echo '<h2>Checked</h2><pre>';
			var_dump($this->checked);
			echo '</pre>';
			die();
		}
	}
}