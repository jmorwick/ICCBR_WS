<?php

$target = "target/$acronym$year";

$symbol_patterns = array(
	"\\\"u" => "&uuml;",
	"\\\"o" => "&ouml;",
	"\\~n" => "&ntilde;",
	"\\~a" => "&atilde;",
	"\\'a" => "&aacute;",
	"\\'o" => "&oacute;",
	"\\'e" => "&eacute;",
	"\\'i" => "&iacute;",
	"\\v{c}" => "&#269;",
	"\\v{s}" => "&scaron;",
	"\\v{Z}" => "&#381;",
	"\\c{c}" => "&ccedil;"
);

function latex2html($str) {
	global $symbol_patterns;
	foreach($symbol_patterns as $latex => $html) {
		$str = str_replace($latex, $html, $str);
	}
	return $str;
}

function pdf_length($filename) {
	if(!file_exists($filename)) return 0;
	ob_start();
	$ret = system("cpdf -pages $filename");
	ob_end_clean();
	return $ret;
}

function trim_all($arr) {
	foreach($arr as $k => $v) {
		$arr[$k] = rtrim($v);
	}
	return $arr;
}

function get_pages_string($length) {
	global $current_page;
	$result = $length > 1 ? $current_page.'-'.($current_page+($length-1)) : $current_page;
	$current_page += $length;
	return $result;
}

function skip_preface_pages() {
	global $current_page;
	$current_page += ($current_page % 2 == 0 ? 1 : 0) + 4;
}

function format_names($names) {
	return implode(', ', $names);
}

function format_names_with_and($names) {
	$txt = '';
	if(count($names) == 1) return $names[0];
	if(count($names) == 2) return $names[0] . ' and ' . $names[1];
	foreach(array_reverse($names) as $name) {
		$txt = $txt ? $name . ', ' . $txt : 'and ' . $name;
	}
	return $txt;
}

function format_names_html($names) {
	foreach($names as $k => $name) {
		$names[$k] = latex2html($name);
	}
	return format_names($names);
}
// read in data from files
foreach(scandir("workshops") as $workshop) {
	if(!file_exists("workshops/$workshop/title.txt")) continue;
	if(!file_exists("workshops/$workshop/editors.txt")) continue;
	$contents = array();
	$contents['shortname'] = $workshop;
	$contents['title'] = rtrim(file_get_contents("workshops/$workshop/title.txt"));
	$contents['editors'] = trim_all(file("workshops/$workshop/editors.txt"));
	$papers = array();
	foreach(scandir("workshops/$workshop/papers") as $paper) {
		if(!file_exists("workshops/$workshop/papers/$paper/title.txt")) continue;
		if(!file_exists("workshops/$workshop/papers/$paper/authors.txt")) continue;
		$paper_info = array();
		$paper_info['number'] = $paper;
		$paper_info['title'] = rtrim(file_get_contents("workshops/$workshop/papers/$paper/title.txt"));
		$paper_info['authors'] = trim_all(file("workshops/$workshop/papers/$paper/authors.txt"));
		$paper_info['length'] = pdf_length("workshops/$workshop/papers/$paper/paper.pdf");
		$papers[$paper] = $paper_info;
	}
	$contents['papers'] = $papers;
	$workshops[$workshop] = $contents;
}
$current_page = 1;
$current_paper = 1;
?>
