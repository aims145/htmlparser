<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require "vendor/autoload.php";
use PHPHtmlParser\Dom;

$dom = new Dom;
$dom->loadFromFile('example.html');
$contents = $dom->find('.que');
echo count($contents);

foreach ($contents as $content)
{
	// get the class attr
	$class = $content->getAttribute('class');
	
	// do something with the html
	$html = $content->innerHtml;

	// or refine the find some more
	$child   = $content->firstChild();
	
	$info = $child->nextSibling();
	
	echo "<xmp>$info</xmp>";
	
	
}
