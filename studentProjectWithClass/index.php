<?php 
//session_destroy();
//session_unset();
//die;
require("pageClass.php");

$objPageClass = new PageClass();
//Include header
echo $objPageClass->header();

//Add Header Menu
echo $objPageClass->menuHTML();

//
$objPageClass->content();

//Include Footer
echo $objPageClass->footer();


 echo 'hellothis is modified by avadhut';





?>
