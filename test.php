<?php
$PosLineUps = array();
$FinalLineups = array();

$QBS = array
	(
	array(0 => "qA", 1 => 100, 2=> 1000),
	array("qB",99,999),
	array("qC",98,1000),
	array("qD",97,980),
	array("qE",96,970)
	);
$WRS = array
	(
	array("wA",100,1000),
	array("wB",99,1000),
	array("wC",98,700),
	array("wD",97,600),
	array("wE",96,650),
	array("wF",95,700),
	array("wG",94,950)
	);
$RBS = array
	(
	array("rA",100,1000),
	array("rB",99,1000),
	array("rC",98,900),
	array("rD",97,900),
	array("rE",96,900),
	array("rF",95,850),
	array("rG",94,850)
	);
$TES = array
	(
	array("tA",100,500),
	array("tB",99,490),
	array("tC",98,480),
	array("tD",97,480),
	array("tE",96,460)
	);
$DSS = array
	(
	array("dA",100,300),
	array("dB",99,300),
	array("dC",98,250),
	array("dD",97,250),
	array("dE",96,200)
	);
$count = 0;
Foreach($QBS as $qb){
	$z = array_merge($qb);
	#grab WRS
	foreach($WRS as $wr1){
		$y = array_merge($wr1);
		foreach($WRS as $wr2){
			if($wr2 != $y) $x = array_merge($wr2);
			foreach($WRS as $wr3){
				if($wr3 != $x && $wr3 != $y) $w = array_merge($wr3);
				if(isset($x) && isset($w)) {
					/*
					print "QB - $z[0]";
					print "WR1 - $y[0]";
					print "WR2 - $x[0]";
					print "WR3 - $w[0]";
					print " Total Cost: ";
					print $y[2] + $x[2] + $w[2];
					print "<br>";
					*/
					$PosLineUps[] = array("QB" => $z, "WR1" => $y, "WR2" => $x, "WR3" => $w);
				}
				
				/*
				print "<b>QB</b>";
				print $z[0];
				print "<b>WR1</b>";
				print $y[0];
				print "<b>WR2</b>";
				print $x[0];
				print "<b>WR3</b>";
				print $w[0];
				print "</br>";
				*/
				}
			}
		}
	}
#print_r($PosLineUps[0]['QB']);

$entry = 0;
#print "<table><tr><td>option</td><td>QB</td><td>WR1</td><td>WR2</td><td>WR3</td><td>TotalCost</td><td>TotalPoints</td></tr>";
foreach($PosLineUps as $line){
	/*
	print "<tr><td>$entry</td><td>";
	Print $line['QB'][0];
	Print "</td><td>";
	Print $line['WR1'][0];
	Print "</td><td>";
	Print $line['WR2'][0];
	Print "</td><td>";
	Print $line['WR3'][0];
	Print "</td><td>";
	print $line['QB'][2] + $line['WR1'][2] + $line['WR2'][2] + $line['WR3'][2];
	*/
	$cost = $line['QB'][2] + $line['WR1'][2] + $line['WR2'][2] + $line['WR3'][2];
	
	#Print "</td><td>";
	#print $line['QB'][1] + $line['WR1'][1] + $line['WR2'][1] + $line['WR3'][1];
	$pts = $line['QB'][1] + $line['WR1'][1] + $line['WR2'][1] + $line['WR3'][1];
	#print "</td></tr>";
	$entry++;
	$FinalLineups[] = array("QB" => $line['QB'][0], "WR1" => $line['WR1'][0], "WR2" => $line['WR2'][0], "WR3" => $line['WR3'][0], "Cost" => $cost, "Points" => $pts);
	}
#print "</table>";
usort($FinalLineups, function($a, $b) {
	return $b['Points'] - $a['Points'];
});
#$Cleaned1 = array_unique($FinalLineups, SORT_REGULAR);

$entry = 0;
print "<table><tr><td>option</td><td>QB</td><td>WR1</td><td>WR2</td><td>WR3</td><td>TotalCost</td><td>TotalPoints</td><td>check</td></tr>";
foreach($FinalLineups as $sorted){
	$qw = $entry + 1;
	$color = "#ffffff";
	if ($FinalLineups[$qw]['Cost'] === $sorted['Cost'] && $FinalLineups[$qw]['Points'] === $sorted['Points']) $color = "#ffff00";
	else {
		print "<tr><td>$entry</td><td>";
		Print $sorted['QB'];
		Print "</td><td>";
		Print $sorted['WR1'];
		Print "</td><td>";
		Print $sorted['WR2'];
		Print "</td><td>";
		Print $sorted['WR3'];
		Print "</td><td BGCOLOR='$color'>";
		print $sorted['Cost'];
		Print "</td><td BGCOLOR='$color'>";
		print $sorted['Points'];
		print "</td><td>";
		print $FinalLineups[$qw]['Cost'];
		print " - ";
		print $sorted['Cost'];
		print "</td></tr>";
	}
	$entry++;
}
print "</Table>";

?>
