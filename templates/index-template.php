<?php
require('config/template-config.php');
require('templates/template-common.php');
?><!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../ceur-ws.css">
<title>CEUR-WS.org/Vol-<?=$volume?> - Workshop Proceedings from <?=$full_conference_title?> (<?=$acronym?> <?=$year?>)</title>
</head>
<!--CEURLANG=eng -->
<body>

<table style="border: 0; border-spacing: 0; border-collapse: collapse; width: 95%">
<tbody><tr>
<td style="text-align: left; vertical-align: middle">
<a href="http://ceur-ws.org/"><div id="CEURWSLOGO"></div></a>
</td>
<td style="text-align: right; vertical-align: middle">

<span class="CEURVOLNR">Vol-<?=$volume?></span> <br>
<span class="CEURURN">urn:nbn:de:0074-<?=$volume?>-C</span>
<p class="unobtrusive copyright" style="text-align: justify">Copyright &copy;
<span class="CEURPUBYEAR"><?=$year?></span> for the individual papers
by the papers' authors. Copying permitted for private and academic purposes.
This volume is published and copyrighted by its editors.</p>
</td>
</tr>
</tbody></table>

<hr>

<br><br><br>


<img src="logo.png" alt="[<?=$acronym?> <?=$year?> Workshops]" style="width: 100%"/>

<h1><a href="<?=$conference_website?>"><span class="CEURVOLACRONYM"><?=$acronym?> <?=$year?></span></a><br>
<span class="CEURVOLTITLE"><?=$acronym?> <?=$year?> Workshops</span></h1>
<br>

<h3>
<span class="CEURFULLTITLE">Workshop Proceedings from <?=$full_conference_title?></span><br>
</h3>
<h3><span class="CEURLOCTIME"><?=$city?>, <?=$country?>, <?=$month_name?> <?=$days?>, <?=$year?></span>.</h3> 
<br>
<b> Edited by </b>
<p>

<p></p><h3>
<?php 
$used_institutions = array();
foreach($editors as $editor) { 
	$institution = $author_institutions[$editor];
	if(!isset($used_institutions[$institution])) {
		$asterisks = '';
		for($i=0; $i<=count($used_institutions); $i++) { 
			$asterisks .= '*'; 
		}
		$used_institutions[$institution] = $asterisks;
	}
	
?>
   <?php if($author_home_pages[$editor]) { ?><a href="<?=$author_home_pages[$editor]?>"><?php } ?>
     <span class="CEURVOLEDITOR"><?=$editor?></span>
   <?php if($author_home_pages[$editor]) { ?></a><?php } ?>
   <?=$asterisks?><br>
<?php } ?>

</h3>
<?php foreach($used_institutions as $institution => $asterisks) { ?>
<?=$asterisks?> <a href="<?=$institution_websites[$institution]?>"><?=$institution?></a>,
  <?=$institution_addresses[$institution]?><br>
<?php } ?>

<hr>

<br><br><br>


<div class="CEURTOC">
<h2> Table of Contents </h2>

<ul>
<li id="frontmatter">
<a href="frontmatter.pdf">Front Matter</a><br><br>
<span class="CEURPAGES"><?=get_pages_string(pdf_length("$target/frontmatter.pdf"))?></span>
</li>
</ul>


<?php foreach($workshops as $workshop) { 
	skip_preface_pages();
?>

<h3><a href="<?=$workshop['shortname']?>_proc.pdf"><span class="CEURSESSION"><?=$workshop['title']?></span></a></h3>
<span class="AUXAUTHORS"><?=format_names_html($workshop['editors'])?></span>

<ul>
<?php foreach($workshop['papers'] as $paper) { ?>
<li id="paper<?=$current_paper?>"><a href="paper<?=$current_paper?>.pdf">
<span class="CEURTITLE"><?=$paper['title']?></span></a>
<span class="CEURPAGES"><?=get_pages_string($paper['length'])?></span><br>
<span class="CEURAUTHORS"><?=format_names_html($paper['authors'])?></span>  
</li>
<?php 
	$current_paper++;

} ?>
</ul>


<?php } ?>
</div> <!-- end CEURTOC -->
<br>
<p>Download the complete <a href="<?=$acronym?><?=$year?>_workshop_proceedings.pdf"><?=$acronym?> <?=$year?> Workshop Proceedings</a> in a single volume.</p>

<hr>
<span class="unobtrusive">
<?=$year?>-<?=$submission_month?>-<?=$submission_day?>: submitted by <?=$submitting_editor?>, 
            metadata incl. bibliographic data published under <a href="http://creativecommons.org/publicdomain/zero/1.0/">Creative Commons CC0</a><br>
<span class="CEURPUBDATE">yyyy-mm-dd</span>: published on CEUR-WS.org 
	|<a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fceur-ws.org%2FVol-<?=$volume?>%2F">valid HTML5</a>|
</span>

</body></html>
