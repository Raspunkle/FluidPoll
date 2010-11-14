<?php

//Class: Vote

class Vote {
	public $v_id;
	private $v_time;
	private $username;
	private $stance;
	public $comment;
	private $c_time;
	
	private $data;
	
	
	function __construct($vID) {
		
		if (is_numeric($vID)) {
			$this->data = Datahandler::FetchVoteData($vID);
			if ($data[0] = true) {
				$this->v_id = $vID;
				$this->v_time = $this->data[1]['votetime'];
				$this->stance = $this->data[1]['stance'];
				$this->username = $this->data[1]['username'];
				$this->comment = $this->data[1]['comment'];
				$this->c_time = $this->data[1]['commenttime'];
			} else {
				echo "Failed to fetch Vote, we're terribly sorry!";
			}
		} else {
			echo 'Invalid vote reference';
		}
	}
}
?>