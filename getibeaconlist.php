<?php

$query = "SELECT * FROM ibeacons";

$result = mysql_query($query) or die(mysql_error());

$num = mysql_numrows($result);

mysql_close();

$rows = array();
$data = array();
while($r = mysql_fetch_assoc($result))
{
	$rows[] = $r;
	$data['ibeacons'] = $rows;
}

	echo json_encode($data);

?>