<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
if($_GET["a"] === null || $_GET["a"] === "") {
	$FirstPost = 0;
	print "no";
}
elseif(isset($_GET["a"])) {
	$FirstPost = $_GET["a"];
	print "yes";
}

$blogs = array_reverse(array_filter(glob('./Content/*'), 'is_dir'));
$TotalEntries = count($blogs);

if(count($blogs) > 10){
	$page = array_slice($blogs, $FirstPost, 10);
	}
else {
	$page = $blogs;
}
print "<h1> $FirstPost </h1>";
foreach($page as $entries){
	$PostDatestr = substr($entries,-8);
	$PostDate = date("d M Y", strtotime($PostDatestr));
	echo "<p> $PostDate </p>";
	}
	
#what will the Starting ID be if we go back

#don't display back button if already at 0
if($FirstPost == 0) $hidemea = "display:none;";
#get id for next page
$NextID = $FirstPost + 10;
#if on last page, bring id back down to last one
if($NextID >= $TotalEntries) $NextID = $TotalEntries;
#don't display forward button if no more entries exist
if($TotalEntries <= $NextID) $hidemeb = "display:none;";

$BackID = $FirstPost - 10;
if($BackID < 0) $BackID = 0;


echo "total number of entries $TotalEntries";
echo "<br> This page is starting at $FirstPost";
echo "<br> back equals newer to id $BackID";
echo "<br> Next equals older dates starting at $NextID <br>";


?>
<form action="slice.php" method="get" id="forwardform">
<input type="hidden" name="a" value="<?echo $BackID;?>">
</form>
<button type="submit" form="forwardform" value="Submit" style="<?echo $hidemea;?>">Newer Posts</button>
<form action="slice.php" method="get" id="backform">
<input type="hidden" name="a" value="<?echo $NextID;?>">
</form>
<button type="submit" form="backform" value="Submit" style="<?echo $hidemeb;?>">Older Posts</button>




</body>
</html>