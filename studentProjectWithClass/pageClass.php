<?php 

class PageClass{

	static $strlink;

	function __construct(){
			session_start();
			error_reporting(E_ALL&~E_NOTICE & ~E_DEPRECATED&~E_WARNING);
	}

	/*
	* For including header  
	*/
	function header(){

		$strHTML = "
			<!DOCTYPE html>
			<html>
			<head>
			<title></title>
			<link rel='stylesheet' type='text/css' href='external.css'>
			<style type='text/css'>
				body {
		    				background-image: url('./demo/images.jpeg');
		    				background-repeat: no-repeat;
		    				background-size: 100% 100%;
		    				min-height: 640px;
						}
				li{
							list-style-type: none;
					}
			


			</style>
			</head>
		";
		return $strHTML;
	}

	/*
	*It adds header menu dependiting on session starts or not
	*/
	public function menuHTML(){
		$strMenu = '
			<header>
				<h2 style="font-style:italic;"align="center">Student Information</h2>
				<div style="background:black;height:30px">
					<ul style="margin: 0;padding: 0;">
						<li class="menualign"><a class="menu" href="./index.php">Home</a></li>';
			
			$strMenu .= (!isset($_SESSION['user_id']))? $this->subLoginSignup():$this->subUserMenu();
				
		$strMenu .= '</ul>
				</div>
			</header>
			<body>';

		return $strMenu ;	
	}

	/*
	*	For selecting sub menu 
	*/

	public function subMenu(){


		if(!isset($_SESSION['user_id'])){
			return 1;
		}
		return 0;
	}

	/*
	* For selecting submenu
	*/
	public function subLoginSignup()
	{
		$strLoginSigup = "";
		if($_GET["action"] != "login")
			$strLoginSigup .= '
				<li class="menualign"><a class="menu" href="./index.php?action=login">Login</a></li>
				';
		if($_GET["action"] != "signup"){
			$strLoginSigup .= '<li class="menualign"><a class="menu" href="./index.php?action=signup">Signup</a></li>';
		}

		return $strLoginSigup; 
	}
	
	/*
	*For getting user menu
	*/
	public function subUserMenu(){

		$strSubUserMenu = '
			<li class="menualign"><a class="menu" href="./index.php?action=info">Fillinfo</a></li>
										<li class="menualign"><a class="menu" href="./index.php?action=filterByMonth">Filterby month</a></li>
										<li class="menualign"><a class="menu" href="./index.php?action=filterByName">Filterby Name</a></li>
										<li class="menualign"><a class="menu" href="./index.php?action=subject">Subject</a></li>
										<li class="menualign"><a class="menu" href="./index.php?action=logout">Logout</a></li>
										<li class="menualign" style="padding-left: 200px;">
											<a class="menu"style="color:purple;background-color: white">';

		$strSubUserMenu .="Login user : ".$_SESSION["user_name"];
											
		$strSubUserMenu .= '</a>
					</li>';
		return $strSubUserMenu;			
	}

	/*
	*For selecting content
	*/
	public function homePage(){
		$strHomePage = '
						<div align="center">
							<img src="./demo/images.jpg"  alt="student" width="950" height="500">
						</div>';
		return $strHomePage;				
	}

	/*
	*check server connection and db connection
	*/
	public function db_Connection(){
		self::$strlink = mysql_connect('localhost','root','');

		if(!self::$strlink)
			die('Could not connect: '.mysql_error()); 

		$db_student =mysql_select_db('db_student',self::$strlink);
			
		if(!$db_student)
				die('<br>Cant use student database'.mysql_error());
	}

	/*
	*execute query
	*/
	public function my_query($myQuery){
		
		$resultQuery = mysql_query("$myQuery",self::$strlink);
		return $resultQuery;
	}
	/*
	*content selection
	*/
	public function content(){

		$strAction = $_GET["action"];
		require('loginClass.php');
		require('userInfoClass.php');
		require('ajaxClass.php');
		require('subjectClass.php');
		switch ($strAction) {
			
			case "":
			case 'home':
				echo $this->homePage();
				break;
			case 'login':
				$objLoginClass = new LoginClass();
				echo $objLoginClass->loginHTML();	
				break;	
			case 'signup':
				$objLoginClass = new LoginClass();
				echo $objLoginClass->signUpHTML();				
				break;
			case 'logout':
				$objLoginClass = new LoginClass();
				$objLoginClass->logout();
				break;	
			case 'info':
				$objUserInfoClass = new UserInfoClass();
				echo $objUserInfoClass->infoFillHTML();		
				break;
			case 'filterByMonth':
				$objUserInfoClass = new UserInfoClass();
				echo $objUserInfoClass->filterByMonthHTML();			
				break;
			/*case 'filterByName' :
				$objUserInfoClass = new UserInfoClass();
				echo $objUserInfoClass->filterByNameHTML();			
				break;*/
			case 'filterByName' :
				$objUserInfoClass = new ajaxClass();
				echo $objUserInfoClass->filterByNameHTML();			
				break;	
			case 'viewProfile':
				$objUserInfoClass = new UserInfoClass();
				echo $objUserInfoClass->viewProfileHTML();
				break;	
			case 'editMarks' :
				$objUserInfoClass = new UserInfoClass();
				echo $objUserInfoClass->editMarksHTML();			
				break;
			case 'editProfile' :
				$objUserInfoClass = new UserInfoClass();
				echo $objUserInfoClass->editProfileHTML();			
				break;
			case 'subject' :
				$objSubjectClass = new SubjectClass();
				echo $objSubjectClass->subjectHTML();			
				break;
			case 'editSubject':
					$objSubjectClass = new SubjectClass();
				echo $objSubjectClass->editSubjectHTML();
				break;
			case 'addSubject':
					$objSubjectClass = new SubjectClass();
				echo $objSubjectClass->addSubjectHTML();
				break;		
											
			default :
				echo "default";
					
		}
	 	
	}

	public function footer(){

		$strFooter = '
			<div style="width:100%;height:80px;position:absolute;bottom:0;left:0;background:#ee5;">
			<footer>
  				<p>Posted by: Cuelogic</p>
  				<p>Contact information: <a href="http://www.cuelogic.com/">www.cuelogic.com</a>.</p>
			</footer>
			</div>
			</body>
			</html>';

		return $strFooter ;	
	}



}

?>