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
	public $deadend = false;
	public function traverseMaze() {
		for($i=1;$i<=count($this->m);$i++) {
			echo $i . '<br>';
			if(!$this->alreadyChecked($i)) {
				if($this->checkOpen($i)) {
					if($this->k == 1) {
						$this->incSearch($i);
						$this->path[] = $i;
						continue;
					}
					if($this->checkLeft($i)) {
						$i = $this->next;
						$this->incSearch($i);
						continue;
					}
					if($this->checkRight($i)) {
						$i = $this->next;
						$this->incSearch($i);
						continue;
					}
					if($this->checkDown($i)) {
						$i = $this->next;
						$this->incSearch($i);
						continue;
					}
					if($this->checkUp($i)) {
						$i = $this->next;
						$this->incSearch($i);
						continue;
					}
					
					$this->checkWin($i);
				}
			}
			# if it got to the end of a path die!
			if($this->deadend) {
				break;
			}
		}
		var_dump($this->path);
	}

	protected function checkLeft($l) {
		if($l > 1) {
			$i = $l - 1;
			if($this->checkOpen($i)) {
				$this->next = $i;
				$this->deadend = false;
				return true;
			} else {
				$this->deadend = true;
			}
		}
	}

	protected function checkRight($r) {
		if($r < 6) {
			$i = $r + 1;
			if($this->checkOpen($i)) {
				$this->next = $i;
				$this->deadend = false;
				return true;
			} else {
				$this->deadend = true;
			}
		}
	}

	protected function checkUp($u) {
		if($this->m[$u]['rowId'] != 1) {
			$i = $u - $this->perRow;
			if($this->checkOpen($i)) {
				$this->next = $i;
				$this->deadend = false;
				return true;
			} else {
				$this->deadend = true;
			}
		}
	}

	protected function checkDown($d) {
		if($d < ($this->perRow * $this->numRows) - $this->perRow) {
			$i = $d + $this->perRow;
			if($this->checkOpen($i)) {
				$this->next = $i;
				$this->deadend = false;
				return true;
			} else {
				$this->deadend = true;
			}
		}
	}

	protected function checkWin($w) {
		if(isset($this->m[$w]['win'])) {
			echo 'WIN';
		}
	}

	protected function incSearch($k) {
		$this->k++;
		$this->path[] = $k;
	}

	protected function alreadyChecked($a) {
		if(in_array($a, $this->path)) {
			return true;
		} else {
			return false;
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
}