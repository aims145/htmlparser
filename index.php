<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$servername = "devopsindia.in";
$username = "devopsindia";
$password = "nector145@";

// Create connection
$conn = new mysqli($servername, $username, $password, 'devopsindia');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
require "vendor/autoload.php";
use PHPHtmlParser\Dom;

$dom = new Dom;
$dom->loadFromFile('example.html');
$question_text = $dom->find('.qtext');
$selects = $dom->find('.prompt');
$answers = $dom->find('.answer');
$answergeneralfeedback = $dom->find('.generalfeedback');
$rightanswer = $dom->find('.rightanswer');
//echo count($contents);
$count = count($question_text);
$correct_answer = ["1","4","1,3","4","3","3","2","2,4","2","1","2","3","1","4","2","3","2","1,2","2,5","3","2","1","1","1","4","1","2","3","1","1","1","3","2","2","3","2","2","2","2","3","3","2,3","2","4","4","1","4","4","1","2","1","3","1,4","3","1","3","1,3","3","1","2","1,2,3","1,4","2,4","3","1,4"];
$allowed_options = ["1","1","2","1","1","1","1","2","1","1","1","1","1","1","1","1","1","2","2","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","2","1","1","1","1","1","1","1","1","1","1","2","1","1","1","2","1","1","1","3","2","2","1","2"];
for($i=0; $i<$count;$i++){
    //echo "<h1>".($i+1)."</h1>";
    $options_array = array();
    $newdom = new Dom;
    $answer = $answers[$i]->innerHtml;
    $newdom->load($answer);
    $options = $newdom->find('.m-l-1');
    $select = $selects[$i]->innerHTML;
    $optioncount = count($options);
    foreach ($options as $selectoption){
        array_push($options_array, $selectoption->innerHtml);
    }
    $question_section = addslashes($question_text[$i]."<br>".$select."<br>");
    if (strpos($answer, 'radio') == true) {
        $multichoice = 0;
    }else{
        $multichoice = 1;
    }
    $all_options = addslashes(json_encode($options_array));
    
    $answersection = addslashes($answergeneralfeedback[$i].$rightanswer[$i]);
    $sql = "insert into wp_my_quiz_questions (question,options,multichoice,numberofoptions,correctanswer,answerallowed,answerdescription,quiz_id) values ('$question_section','$all_options','$multichoice','$optioncount','1','1','$answersection','36')";

    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully ".($i+1);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

}

$conn->close();
//
//
//
//foreach ($question_text as $content)
//{
//	// get the class attr
//	$class = $content->getAttribute('class');
//	
//	// do something with the html
//	$html = $content->innerHtml;
//
//	// or refine the find some more
//	$child   = $content->firstChild();
//        
//	$info = $child->nextSibling();
//
//        echo "<pre><xmp>$content</xmp></pre>";
//	
//	
//}
