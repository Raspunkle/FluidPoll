<?php

require ('../../sql_fparanta.php');


$q = "SELECT votes.vote_id FROM poll, votes WHERE poll.poll_id = votes.poll_id";
$r = mysqli_query($dbc, $q);
$vrefs = array();
while ($row = mysqli_fetch_assoc($r)) {
	array_push($vrefs, $row['vote_id']);
}
$q = "SELECT poll_id, poll_name, statement FROM poll LIMIT 1";
$r = mysqli_query($dbc, $q);
$row = mysqli_fetch_array($r,MYSQLI_NUM);
$polldata['poll_id'] = $row[0];
$polldata['poll_name'] = $row[1];
$polldata['statement'] = $row[2];
$data = array(poll => $polldata, votes => $vrefs);
var_dump ($data);



echo $data[1][2];



?>