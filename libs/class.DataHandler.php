<?php

require ('../../class.dbConnect.php');


//Static Class: DataHandler

class DataHandler {
	
	/* Poll Handling
	 *
	 */
	 
	 public static function FetchDataPoll() {
		$q = "SELECT poll_id, poll_name, statement FROM poll LIMIT 1";
		$r = mysqli_query(dbConnect::dbGetLink(), $q);
		if ($r) {
			$row = mysqli_fetch_array($r,MYSQLI_NUM);
			$data['poll_id'] = $row[0];
			$data['poll_name'] = $row[1];
			$data['statement'] = $row[2];
			return $data;
		} else {
			echo 'System Error1';
		}
	}
	
	public static function FetchVoteRefsPoll($pID) {
		$q = "SELECT vote_id FROM votes, poll WHERE poll.poll_id = $pID";
		$r = mysqli_query(dbConnect::dbGetLink(), $q);
		if ($r) {
			while ($row = mysqli_fetch_assoc($r)) {
				$vrefs[] = $row['vote_id'];
			}
			return $vrefs;
		} else {
			echo 'System Error2';
		}
	}
	
	public function UpdatePoll($pID, $method, $item1, $item2=NULL, $item3=NULL) {
		switch ($method) {
			case 'setStatement':
				$item1 = mysqli_real_escape_string(dbConnect::dbGetLink(), trim($item1));
				$q = "UPDATE poll SET statement='$item1' WHERE poll_id = $pID";
				$r = mysqli_query(dbConnect::dbGetLink(), $q);
				if ($r = false) {
					return false;
				} else {
					return true;
				}
				break;
			case 'setName':
				$item1 = mysqli_real_escape_string(dbConnect::dbGetLink(), trim($item1));
				$q = "UPDATE poll SET poll_name='$item1' WHERE poll_id = $pID";
				$r = mysqli_query(dbConnect::dbGetLink(), $q);
				if ($r = false) {
					$succes = false;
				} else {
					$succes = true;
				}
				break;
		}
		return $succes;
	}
	
	/*Vote Handling
	 *
	 */
	 
	public static function FetchVoteData($vID) {
		$q = "SELECT stance, votetime, username, comment, commenttime FROM votes, users WHERE vote_id = $vID AND votes.user_id = users.user_id";
		$r = @mysqli_query(dbConnect::dbGetLink(), $q);
		if ($r) {
			if (mysqli_num_rows($r) == 1) {
				$data = array(true, mysqli_fetch_assoc($r));
				mysqli_free_result($r);
				return $data;
			} else {
				$data = array(false);
				return false;
			}
			$data = array(false);
			return false;
		}
	}
	 
	public static function insertRegVote ($pID, $uID, $vStance, $vComment) {
		mysqli_real_escape_string(dbConnect::dbGetLink(),$vComment);
		if (CookiesManager::GetUserState() != 'closed') {
			if (CookiesManager::GetUserState() == 'only_voted') {
				$vID = CookiesManager::vGetCookie();
				$q = "UPDATE votes SET stance=$vStance, user_id=$uID, comment='$vComment', commenttime=NOW() WHERE vote_id = $vID";
				$r = mysqli_query(dbConnect::dbGetLink(), $q);
				if ($r) {
					$outcome[] = (mysqli_affected_rows(dbConnect::dbGetLink()) == 1) ? true : false;
					$outcome[] = $vID;
					return $outcome;
				} else {
					return $outcome[] = false;
				}
			} else {
				$q = "INSERT INTO votes (poll_id, stance, votetime, user_id, comment, commenttime) VALUES ($pID, $vStance, NOW(), $uID, '$vComment', NOW())";
				$r = mysqli_query(dbConnect::dbGetLink(), $q);
				if ($r) {
					if (mysqli_affected_rows(dbConnect::dbGetLink()) == 1) {
						$outcome[] = true;
						$outcome[] = mysqli_insert_id(dbConnect::dbGetLink());
						return $outcome;
					} else {
						return $outcome[] = false;
					}
				} else {
					return $outcome[] = false;
				}
			}
		}
	}
	
	private function escapeStrings ($string) {
		return mysqli_real_escape_string(dbConnect::dbGetLink(), $string);
	}
}
?>