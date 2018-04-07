<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php

$FirstPost = 0;
$LastPost = $FirstPost + 10;

header('Content-Type:text/html; charset=UTF-8');
$b = 1;
$p = 1;
$blogs = array_filter(glob('./Content/*'), 'is_dir');



FUNCTION RemoveBS($Str) {  
  $StrArr = STR_SPLIT($Str); $NewStr = '';
  FOREACH ($StrArr AS $Char) {    
    $CharNo = ORD($Char);
    IF ($CharNo == 163) { $NewStr .= $Char; CONTINUE; } // keep £ 
    IF ($CharNo > 31 && $CharNo < 127) {
      $NewStr .= $Char;    
    }
  }  
  RETURN $NewStr;
}

foreach($blogs as $entries){
	/*
	print "<br>";
	print $entries;
	print "<br>";
	print "<p>Images</p>";
	*/
	#get all the JPG s in the blog folder
	$images = array_filter(glob("$entries/*.JPG"));
	
	#get Textblock and title txt files for verbage....
	$textblock = file_get_contents("$entries/Textblock.txt");
	$title = file_get_contents("$entries/Title.txt");
	
	#get date for post
	$PostDatestr = substr($entries,-8);
	$PostDate = date("d M Y", strtotime($PostDatestr));
		
	#Create Entry regardless of type:
	?>
<div id="Notice">
  <div id="Title"><h2><?echo $title;?></h2></div>
    <section class="Wrapper">
      <header class="Wrapper"><h1><?echo $PostDate;?></h1></header>
        <article>
	<?
	
	
	#print the Blog post....  if one or less photos in DIR
	if (count($images) <= 1){
	#Don't use img tag if there are 0 images.
		if (count($images) === 1){
			?><img src="<?echo $images[0];?>" style="float:left; margin-right:10px; Max-width: 680px; Max-height:680px; width:auto; height:auto;">
			<?
		}
		echo $textblock;

	}
	#print the Blog post.... if there is more than 1 photo in DIR
	if (count($images) > 1){
		#get info for each photo
		
		?>
		<div class="thumbnails" style="width;100%; height:auto; display:block; overflow:hidden;">
		<?
		foreach($images as $img){
		
		$exif = exif_read_data($img, 0, true);
		
		$Ititle =  RemoveBS($exif['IFD0']['Title']);
		$Isubject = RemoveBS($exif['IFD0']['Subject']);
		$Icomment = RemoveBS($exif['IFD0']['Comments']);
				
		$m = "<p>Title: ".$Ititle."<BR>Subject: ".$Isubject."<BR>Comments: ".$Icomment."</p>";
		
		#echo $exif===false ? "No header data found.<br />\n" : "Image contains headers<br />\n";
		?>
		
		<img onmouseover="document.getElementById('exifdata<?echo $b;?>').innerHTML = '<?echo $m;?>'; preview<?echo $b;?>.src=img<?echo $p;?>.src" name="img<?echo $p;?>" src="<?echo $img;?>" style="float:left; margin-right:10px; Max-width: 100px; Max-height:100px; width:auto; height:auto;">
				<?
		$p++;
		$lastimg = $img;
		}
		?>
		</div>
		<br><br>
		
		<div class="preview<?echo $b;?>" align="center" Style="width:640px; margin:0 auto; overflow:hidden;">
			<img name="preview<?echo $b;?>" src="<?echo $lastimg;?>" style="float:left; margin-right:10px; Max-width: 680px; Max-height:680px; width:auto; height:auto;" alt=""/>
		</div>
		<div style="width:680px; height:auto; overflow:hidden; background: rgba(66, 95, 149, 1);">
		<p id='exifdata<?echo $b;?>'>testing
		</p>
		  </div>

	
	<?
	}
	?>
	    </article>
    </Section>
 </div> 

<?
	$b++;
	}
	
?>	
<form action="slice.php" method="get" id="forwardform">
<input type="hidden" name="a" value="<?echo $BackID;?>">
</form>

<form action="slice.php" method="get" id="backform">
<input type="hidden" name="a" value="<?echo $NextID;?>">
</form>

<div id="Menu"> <h2 style="margin-top:0;"><center>
<button class="myButton" type="submit" form="backform" value="Submit" style="<?echo $hidemeb;?>">Older Posts</button>
Fouts Family Propaganda
<button class="myButton" type="submit" form="forwardform" value="Submit" style="<?echo $hidemea;?>">Newer Posts</button>
</h2></center>
</div>


</body>
</html>