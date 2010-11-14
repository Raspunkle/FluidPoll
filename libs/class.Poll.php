<?php

//Class: Poll

require ('libs/class.Validator.php');
require ('libs/class.DataHandler.php');

class Poll {
	private $id;
	private $name;
	private $statement;
	private $data;
	public $voterefs;

	function __construct() {
				
		$this->data = Datahandler::FetchDataPoll();

		$this->id = $this->data['poll_id'];
		$this->statement = $this->data['statement'];
		$this->name = $this->data['poll_name'];
		
		$this->voterefs = Datahandler::FetchVoteRefsPoll($this->id);
	}
		
	public function getStatement() {
		return $this->statement;
	}
	
	public function setStatement($pStatement) {
		$chk = DataHandler::UpdatePoll($this->id, 'setStatement', $pStatement);
		if ($chk = true) {
			$this->statement = $pStatement;
		} else {
			echo 'Fail';
		}	
	}
	
	public function getName() {
		return $this->name; 	
	}
	
	public function setName($pName) {
		$chk = DataHandler::UpdatePoll($this->id, 'setName',  $pName);
		if ($chk = true) {
			$this->name = $pName;
		} else {
			echo 'fail';
		}
	}
	
	private function getID() {
		return $this->id;
	}
	
	public function addVote($uID, $iStance, $iComment) {
		$input = array('stance' => $iStance, 'comment' => $iComment);
		$rtn = Validator::init('addVote', $input);
		if (is_array($rtn)) {
			foreach ($rtn as $key => $value) {
				if ($rtn[$key]  != 'valid') {
					$flag = false;
				}
			}
		} else {
			return false;
		}
		if (!isset($flag)) {
			$rtn = DataHandler::insertRegVote($this->getID(), $uID, $iStance, $iComment);
			if ($rtn[0] == true) {
				if (is_numeric($rtn[1])) {
					array_push($this->voterefs, $rtn);
					CookiesManager::SetCookies($this->id, $rtn[1]);
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return 'Invalid Input';
		}
	}
}