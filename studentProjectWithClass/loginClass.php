<?php 

/**
* 
*/
class LoginClass extends PageClass
{
	/*
	*for Login html page
	*/
	public function loginHTML(){

		$strLogin = '
			<div id="detail" >
				<fieldset>
				<legend>Login</legend>
				<form action="./index.php?action=login" method="post">';

		$this->getLoginData();
		
				
		 		
		$strLogin .= '
				<ul>
				<li>
					<div class="field_name">Username :</div>
					<div class="floatleft"><input type="text" name="username" value=';
		if(isset($_COOKIE["userNameCookie"])) 
			$strLogin .= $_COOKIE["userNameCookie"];			

			$strLogin .='></div>
						</li>	
					<li>
					<div class="field_name">Password:</div>
					<div class="floatleft"><input type="password" name="password" value=';

		if(isset($_COOKIE["userPasswordCookie"])) 
			$strLogin .= $_COOKIE["userPasswordCookie"];
				$strLogin .='></div>
	
				</li>
				<li>
					<div class="floatleft">
						<button type="submit" value="submit" name="submit">Login</button>
						<a href="studentlogin.php"></a><button type="reset" value="reset">Reset</button></a>
					</div>
				</li>
			</ul>		
		</form>

	</div>

		';	
		return $strLogin;		
		
	}

	/*
	*Get login data
	*/
	public function getLoginData(){

		if (!isset($_SESSION["user_id"])) { 
					session_start();
		}
		if (isset($_POST['submit'])) {
						
					$str_Username = $_POST['username'];
					$str_Password = $_POST['password'];
					$strMySQLQuery = "
						SELECT * 
						FROM stud_info where stud_name like '$str_Username'
						AND stud_password like '$str_Password'
						" ;
					
					parent::db_Connection();
					$result = parent::my_query($strMySQLQuery);  
					
					if(!$result)
						die('Invalid Query'.mysql_error());	

					if(mysql_num_rows($result)>0)
					{		
						while($arrStudIdName = mysql_fetch_assoc($result)){
							$_SESSION['user_id'] = $arrStudIdName['stud_id'];
							$_SESSION['user_name'] = $arrStudIdName['stud_name'];
							setcookie("userNameCookie", $_SESSION['user_name']);
							setcookie("userPasswordCookie", $str_Password);

						}
								
						header("Location:./index.php?action=info");
					}else{  
						echo '<span style="color:red;">Invalid username password</span>';
					}
				}
		
	}
	/*
	*For signUp HTML
	*/

	public function signUpHTML(){

		$strSignUpHtml ='
				<div id="detail" >
				<fieldset>
				<legend>SignUp</legend>
				<form action="./index.php?action=info" method="post">
				<ul>
				<li>
					<div class="field_name">Username :</div>
					<div class="floatleft"><input type="text" name="username"></div>
				</li>	
				
				<li>
					<div class="field_name">Email Id :</div>
					<div class="floatleft"><input type="text" name="emailId"></div>
				</li>	
				

				<li>
					<div class="field_name">Password:</div>
					<div class="floatleft"><input type="password" name="password"></div>
	
				</li>
				<li>
					<div class="field_name">Confirm Password:</div>
					<div class="floatleft"><input type="password" name="confirmPassword"></div>
	
				</li>
				<li>
					<div class="floatleft">
						<button type="submit" value="submit" name="submit">Signup</button>
						<a href="studentlogin.php"></a><button type="reset" value="reset">Reset</button></a>
					</div>
				</li>
			</ul>		
		</form>

	</div>
	
		';

		return $strSignUpHtml;
	}

	public function Logout(){
		session_destroy();
	 	session_unset();
	 	header("Location:./index.php?action=home");
	}



}


?>