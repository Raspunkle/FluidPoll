<?php
require_once ('libs/class.CookiesManager.php');
CookiesManager::init(1);

require_once ('libs/class.Poll.php');
require_once ('libs/class.Vote.php');
 

dbConnect::init();



//$CurrentPoll = new Poll;

//echo $CurrentPoll->getStatement();

//$CurrentPoll->setStatement("Polen zijn nodig voor onze economie");
//$CurrentPoll->setName('SimplePollv2');

//echo $CurrentPoll->getStatement();
//echo $CurrentPoll->getName();

//if	(!is_object($TestVote = new Vote('82.171.43.213', 1))) {//82.171.43.213
//	echo "false";
//} else {
//	echo $TestVote->comment;
//}

//echo '<p>' . $CurrentPoll->addVote( 4, true,'Zukini') . '</p>';



$CurrentPoll = new Poll();

$yn = $CurrentPoll->addVote(5, true, 'Helemaal mee eens');
include ('includes/header.html');

echo $vyn;

include ('includes/footer.html');
?>

