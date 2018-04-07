<?php
$PosLineUps = array();
$FinalLineups = array();
ini_set('memory_limit', '256M');
$QBS = array
	(
	array(1, "qA",100,1000),
	array(2, "qB",99,999),
	array(3, "qC",98,1000),
	array(4, "qD",97,980),
	array(5, "qE",96,970)
	);
$WRS = array
	(
	array(6, "wA",100,1000),
	array(7, "wB",99,1000),
	array(8, "wC",98,700),
	array(9, "wD",97,600),
	array(10, "wE",96,650),
	array(11, "wF",95,700),
	array(12, "wG",94,950)
	);
$RBS = array
	(
	array(13, "rA",100,800),
	array(14, "rB",99,800),
	array(15, "rC",98,600),
	array(16, "rD",97,600),
	array(17, "rE",96,600),
	array(18, "rF",95,500),
	array(19, "rG",94,500)
	);
$TES = array
	(
	array(20, "tA",100,250),
	array(21, "tB",99,250),
	array(22, "tC",98,240),
	array(23, "tD",97,240),
	array(24, "tE",96,200)
	);
$DSS = array
	(
	array(25, "dA",100,150),
	array(26, "dB",99,150),
	array(27, "dC",98,250),
	array(28, "dD",97,250),
	array(29, "dE",96,100)
	);

foreach($WRS as $wide1){
	$WR1 = $wide1;
	foreach($WRS as $wide2){
		$WR2 = $wide2;
		foreach($WRS as $wide3){
			$WR3 = $wide3;
			
			if($WR3 < $WR2) {
				$sb2 = $WR3;
				$sc2 = $WR2;
				$sa2 = $WR1;
			}
			else{
				$sa2 = $WR1;
				$sb2 = $WR2;
				$sc2 = $WR3;
			}
			if($sb2 < $sa2){
				$sa3 = $sb2;
				$sb3 = $sa2;
				$sc3 = $sc2;
			}
			else{
				$sa3 = $sa2;
				$sb3 = $sb2;
				$sc3 = $sc2;
			}
			if($sc3 < $sb3){
				$sb4 = $sc3;
				$sc4 = $sb3;
				$sa4 = $sa3;
			}
			else{
				$sa4 = $sa3;
				$sb4 = $sb3;
				$sc4 = $sc3;
			}
			
#Place Wide Receivers in Array
			$arr = array($sa4, $sb4, $sc4);
#not valid if same person is in two spots of the lineup
			if($sa4[0] != $sb4[0] && $sa4[0] != $sc4[0] && $sb4[0] != $sc4[0]){
				#print "A: $arr[0][0] B: $arr[1][0] C: $arr[2][0]";
				#print "<BR>";
				$WRSSETS[] = $arr;
			}
		}
	}
}

# Remove same lineup but in different order
$CWideReceivers = array_unique($WRSSETS, SORT_REGULAR);

/*
print "<h2>all possible Wide Receivers</h2>";
Foreach($CWideReceivers as $w){
	print $w[0][0];
	print " - ";
	print $w[1][0];
	print " - ";
	print $w[2][0];
	print "<br>";

}
*/

#Get Running Backs!

foreach($RBS as $run1){
	$RB1 = $run1;
	foreach($RBS as $run2){
		$RB2 = $run2;
		
		if($RB2 < $RB1){
			$sa5 = $RB2;
			$sb5 = $RB1;
		}
		else{
			$sa5 = $RB1;
			$sb5 = $RB2;
		}
		$arr = array($sa5, $sb5);
		if($sa5 != $sb5) $RBSETS[] = $arr;
	}
}

$CRunningBacks = array_unique($RBSETS, SORT_REGULAR);

/*
print "<h2>all possible Running Backs</h2>";
Foreach($CRunningBacks as $w){
	print $w[0][0];
	print " - ";
	print $w[1][0];
	print "<br>";

}
*/

#Making Lineups


Foreach($QBS as $Quarter){
	Foreach($DSS as $Defence){
		Foreach($TES as $Tide){
			Foreach($CRunningBacks as $Run){
				Foreach($CWideReceivers as $Receivers){
					$lineupPts = $Receivers[0][2] + $Receivers[1][2] + $Receivers[2][2] + $Quarter[2] + $Run[0][2] + $Run[1][2] + $Defence[2] + $Tide[2];
					$lineupCost = $Receivers[0][3] + $Receivers[1][3] + $Receivers[2][3] + $Quarter[3] + $Run[0][3] + $Run[1][3] + $Defence[3] + $Tide[3];
					
					$arr = array($Quarter, $Run[0][1], $Run[1][1], $Receivers[0][1], $Receivers[1][1], $Receivers[2][1], $Defence, $Tide, $lineupPts, $lineupCost);
					$FinalLineups[] = $arr;
				}
			}
		}
	}
}
#remove duplicates
$CleanFinalLineups = array_unique($FinalLineups, SORT_REGULAR);
#order by Points
usort($CleanFinalLineups, function($a, $b) {
	return $b[8] - $a[8];
});

print "<h2>all possible Lineups</h2>";
Foreach($CleanFinalLineups as $w){
	if($w[9] < 5000) {
		#Quarter
		print $w[0][1];
		print " - ";
		#Running back1
		print $w[1];
		print " - ";
		#Running back2
		print $w[2];
		print " - ";
		#Reciever1
		print $w[3];
		print " - ";
		#Reciever2
		print $w[4];
		print " - ";
		#Reciever3
		print $w[5];
		print " - ";
		#Defence
		print $w[6][1];
		print " - ";
		#Tide
		print $w[7][1];
		print " - ";
		#Pts
		print $w[8];
		print " - ";
		#Cost
		print $w[9];
		print "<br>";
	}
	

}


?>