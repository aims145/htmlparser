<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, 'sample');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
require "vendor/autoload.php";
use PHPHtmlParser\Dom;

$dom = new Dom;
$dom->loadFromFile('udemy_html.html');
$question_div = $dom->find('.question-review');
//echo count($question_div);
//die();
$question_text = $dom->find('#question-prompt');
//echo count($question_text);
$count = count($question_text);
for($i=0; $i<$count;$i++){
    //echo "<h1>".($i+1)."</h1><br/>";
    $options_array = array();
    //echo $question_text[$i]->innerHtml."<br/>";
    $newdom = new Dom;
    $newdom->load($question_div[$i]);
    $options = $newdom->find('.quiz-answer--question-copy--2TSpZ');
    $optioncount = count($options);
    $optionstype = $newdom->find('.quiz-answer--answer-body--2ZLoP');
    $answersection = $newdom->find('.quiz-question--explanation--1HS_E');
    $correct_option = array();
    if (strpos($optionstype[0]->innerHtml, 'radio') == true) {
        $multichoice = 0;
        //echo "<p style='color:red;'>radio</p>";
    }elseif(strpos($optionstype[0]->innerHtml, 'checkbox') == true){
        $multichoice = 1;
        //echo "<p style='color:red;'>checkbox</p>";
    }
    for($j=0;$j<$optioncount;$j++){
        array_push($options_array, $options[$j]->innerHtml);
        if(strpos($optionstype[$j], "(Correct)") == true){
            array_push($correct_option, ($j+1));
        }
    }
    
    echo "<br/><br/><br/><br/>";

    $sql = "insert into wp_my_ultimate_quiz_questions (question,options,multichoice,numberofoptions,correctanswer,answerallowed,answerdescription,quiz_id) values ('".$question_text[$i]->innerHtml."','".  json_encode($options_array)."','".$multichoice."','".$optioncount."','".implode(",", $correct_option)."','".count($correct_option)."','".addslashes($answersection[0]->innerHtml)."','3')";
//echo "<xmp>$sql</xmp>";
//die();
    
    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully ".($i+1)."<br/>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
    


}
//var_dump($correct_answer);
//var_dump($allowed_options);
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
