<?php 
//session_destroy();
//session_unset();
//die;
require("pageClass.php");
 echo 'I am going to merge branch';
$objPageClass = new PageClass();
//Include header
echo $objPageClass->header();

//Add Header Menu
echo $objPageClass->menuHTML();

//
$objPageClass->content();

//Include Footer
echo $objPageClass->footer();
?>
