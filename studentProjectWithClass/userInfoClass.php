<?php


class UserInfoClass extends PageClass{
	
	/*
	*For checking session is set or not
	*/
	public function checkSession(){
 
	if(!isset($_SESSION["user_id"])){
		header("Location:./index.php?action=login");

		}
	}

	public function infoFillHTML(){
		$this->checkSession();
		$strInfoFillHTML ='

				<div id="detail" >
				<fieldset>
				<legend>Information</legend>
				<form action="./index.php?action=info" method="post">


					<ul>
						<li>
							<div class="field_name">Name :</div>
							<div class="floatleft"><input type="text" name="stud_name"></div>
						</li>	
						
						<li>
							<div class="field_name">Date of Birth:</div>
							<div class="floatleft"><input type="text" name="stud_dob"></div>
			
						</li>	
						<li>
							<div class="field_name">Password:</div>
							<div class="floatleft"><input type="password" name="stud_password"></div>
			
						</li>	
						
						<li>
							<div class="field_name">Gender:</div>
							<div class="floatleft">
							<input type="radio" name="stud_gender" value="male">Male
							<input type="radio" name="stud_gender" value="female">female
							</div>
						</li>
						<li>
							<div class="field_name">Subjects:</div>
							<div class="floatleft" style="margin-left:-40px">
							<ul>
								<li>Subject&nbsp; &nbsp;&nbsp;Marks &nbsp;&nbsp;&nbsp;Month</li>
								<li>
									<input type="checkbox" name="maths" value="maths">Maths
									<input type="text" style="width:20px;margin-left:19px" name="m_mark">
									<input type="text" style="width:20px;margin-left:19px" name="m_month">
								</li>
								<li>	
									<input type="checkbox" name="english" value="english">English
									<input type="text" style="width:20px;margin-left:10px" name="e_mark">
									<input type="text" style="width:20px;margin-left:19px" name="e_month">
				
								</li>
								
								<li>
									<input type="checkbox" name="science" value="science">Science
									<input type="text" style="width:20px;margin-left:9px" name="s_mark">
									<input type="text" style="width:20px;margin-left:19px" name="s_month">

								</li>
								</ul>
							</div>
						</li>	
						
						<li>
						
							<div class="field_name">Address :</div>
							<div class="floatleft"><input type="text" name="stud_address"></div>

						</li>	
										
						<li>
							<div class="floatleft">
								<input type="submit"  name="submitInfo">
								<button type="reset" value="reset">Reset</button>
							</div>
						</li>

					</ul>

				</form>	

				</fieldset>
			</div>
			<div>
				
			</div>

		';
			
		
		$this->setFillInfo();
		return $strInfoFillHTML;
	}
	/*
	*For inserting data into user table
	*/
	public function setFillInfo(){

		if(isset($_POST['submitInfo']))
		{	
			
			
			$stud_name = $_POST['stud_name'];
			$stud_address = $_POST['stud_address'];
			$stud_dob = $_POST['stud_dob'];
			$stud_gender = $_POST['stud_gender'];
			
			$maths = $_POST['maths'];
			$english = $_POST['english'];
			$science = $_POST['science'];
			
			$m_mark = $_POST["m_mark"];
			$e_mark = $_POST["e_mark"];
			$s_mark = $_POST["s_mark"];
			$m_month = $_POST["m_month"];
			$e_month = $_POST["e_month"];
			$s_month = $_POST["s_month"];
			$stud_password = $_POST['stud_password'];
		
			$strInsertQuery = 
				"insert into stud_info values(NULL,'$stud_name','$stud_gender','$stud_dob','$stud_address','$stud_password')";
			parent::db_Connection();
			$result = parent::my_query($strInsertQuery);
			if(!$result)
				die('Invalid Query'.mysql_error());

			$sqlLastInsertId =parent::my_query('select LAST_INSERT_ID() as student_id');
			if(!$sqlLastInsertId)
				die('Invalid Query'.mysql_error());

			$arrLastInserId = mysql_fetch_row($sqlLastInsertId);
			$intStudentId = $arrLastInserId[0];
			if($maths == "maths")
				parent::my_query("insert into marks values($intStudentId,1,'$m_mark','$m_month')");
			if($english == "english")
				parent::my_query("insert into marks values($intStudentId,2,'$e_mark','$e_month')");
			if($science == "science")
				parent::my_query("insert into marks values($intStudentId,3,'$e_mark','$s_month')");
			echo "Data inserted successfully";
			header('Location: ./index.php?action=filterByName'); 
		}   	
	}
	/*
	*Filter by month
	*/
	public function filterByMonthHTML(){
		$this->checkSession();
		//$arrMonth = array("Jan","Feb","March","April","May","Jun","Jully","Aug","Sep","Oct","Nov","Dec");
		$strFilterByMonthHTML = '
			<div id="detail" >
				<fieldset>
				<legend>Filter By Month</legend>
					<form action="./index.php?action=filterByMonth" method="post">
						<ul>
							<li>
								Select month to see see information of that month
								<select name="month">
		';
		$strFilterByMonthHTML .= $this->getSelectOptionList();
		$strFilterByMonthHTML .= '
				</select>
				<input type="submit"  name="submit">
				<a href="./index.php?action=filterByMonth"><input type="button" name="reset" value="Reset"></a>
				
				</li>
				<div>
				<br>
		';
		$arrUserInfo = $this->getFilterByMonthInfo();
		//echo "<pre>";
		//print_r($arrUserInfo);
		//exit;
		$strFilterByMonthHTML .='
			<table border=1>
							<tr>
								
								<th>Student Name</th>
								<th>Maths</th>
								<th>English</th>
								<th>Science</th>
								
								
							</tr>';
							
							foreach ($arrUserInfo as $key => $value) {
								
							
							$strFilterByMonthHTML .= "<tr>"."<td>";
							$strFilterByMonthHTML .= $value['Name'];
							$strFilterByMonthHTML .= "</td>"."<td>";
							$strFilterByMonthHTML .= $value['maths'];
							$strFilterByMonthHTML .= "</td>"." <td>";
							$strFilterByMonthHTML .= $value['english'];
							$strFilterByMonthHTML .= "</td>"." <td>";
							$strFilterByMonthHTML .= $value['science'];
							$strFilterByMonthHTML .= "</td> "."</tr>";
								}


							
			
				$strFilterByMonthHTML .='</table>
								</fieldset>
							</div>
						</form>	
					</fieldset>
				</div>';
		return $strFilterByMonthHTML;
	}
	/*
	*For getting information about users of respective month
	*/

	public function getFilterByMonthInfo(){
				if (isset($_POST['submit'])) {
					$intMonth = (int)$_POST["month"];
					$strWhereCond = "";
					if ($intMonth >0) {
						$strWhereCond = " AND m.month = '$intMonth'";
					} 
				} else {
							$strWhereCond = " AND m.month = 1 ";
				}
						
				$arrStudentInfo = array();
				parent::db_Connection();
				$strStudName = parent::my_query(" select stud_id,stud_name from stud_info ");
				//$result = mysql_query('select * from stud_info',$link);
						
				if(!$strStudName)
					die('Invalid Query1'.mysql_error());
					//$rowCount = mysql_num_rows($strStudName);
					//echo "No. of records in table".$rowCount;
					while ($arrStudentIdName = mysql_fetch_assoc($strStudName)) {
							$resultMarks = parent::my_query("
								SELECT sub.sub_name, m.marks
								FROM marks AS m JOIN subject AS sub ON m.sub_id = sub.sub_id
								WHERE m.stud_id = ".$arrStudentIdName['stud_id'] . $strWhereCond);
							//echo "
							//	SELECT sub.sub_name, m.marks
							//	FROM marks AS m JOIN subject AS sub ON m.sub_id = sub.sub_id
							//	WHERE m.stud_id = ". $arrStudentIdName["stud_id"] . $strWhereCond;
							//die;
							$stud_Id =  $arrStudentIdName['stud_id'];
							$arrStudentInfo[$stud_Id]['Name']=$arrStudentIdName['stud_name'];
							$arrStudentInfo[$stud_Id]['maths'] = "-";
							$arrStudentInfo[$stud_Id]['english'] = "-";
							$arrStudentInfo[$stud_Id]['science'] = "-";	
							while ($arrSubMarks = mysql_fetch_assoc($resultMarks)) {
							//echo "<pre>";print_r($arrSubMarks);
							//die;
						    	
							if($arrSubMarks['sub_name']=='maths')
									$arrStudentInfo[$stud_Id]['maths']=$arrSubMarks['marks'];

							if($arrSubMarks['sub_name']=='english') 
								$arrStudentInfo[$stud_Id]['english']= $arrSubMarks['marks'];
							
							if($arrSubMarks['sub_name']=='science')
									$arrStudentInfo[$stud_Id]['science']=$arrSubMarks['marks'];

						}

					}
			//echo "<pre>";
			//print_r($arrStudentInfo);
			//exit;		
			return $arrStudentInfo ;			//echo "<pre>";print_r($arrStudentInfo);
		}
		/*
		*For getting month list
		*/
		public function getSelectOptionList(){
			$arrMonth = array("Jan","Feb","March","April","May","Jun","Jully","Aug","Sep","Oct","Nov","Dec");
			for ($i=0; $i <12; $i++) { 
				$strSelected = "";
				if ($_POST["month"] == $i+1) {
					$strSelected = "selected";
				}
			
				$strSelectList .= "<option value=";

				$strSelectList .= $i+1; 

				$strSelectList .= " ".$strSelected.">".$arrMonth[$i]."</option>";

			}

			return $strSelectList;
		}

		/*
		*Filter by name
		*/
		public function filterByNameHTML(){

			$this->checkSession();
			$strFilterByNameHTML = '
				<div id="detail" >
					<fieldset>
						<legend>Filter By Name</legend>
							<form action="./index.php?action=filterByName" method="post">
								<ul>
									<li> Enter key you want to search';
			//$strKey = 	(string)$_POST["inputKey"]!=""?	$_POST["inputKey"] : " " ;					
			$strKey = "";
					if ((string)$_POST["inputKey"]!="") {
						# code...
						$strKey = $_POST["inputKey"];
					}	

			$strFilterByNameHTML .= '
							<input type="text" name="inputKey" value="'.$strKey.'">
							<input type="submit" name="submit">
							<a href="./index.php?action=filterByName" style="text-decoration:none;"><input type="button" name="reset" value="Reset"></a>
							</li>
							<div>
							<br> ';

			$arrUserInfo = $this->getFilterByNameInfo();
			//echo "<pre>";
			//print_r($arrUserInfo);
			$strFilterByNameHTML .= '
							<table border=1>
							<tr>
								
								<th>Student Name</th>
								<th>Maths</th>
								<th>English</th>
								<th>Science</th>
								<th>Action</th>
								<th>Edit_Marks</th>
								<th>Edit_profile</th>
							</tr>';
							
								foreach ($arrUserInfo as $key => $value) {
							
				$strFilterByNameHTML .= '<tr>
								<td>'.$value['Name'].'</td>
								<td>'.$value['maths'].'</td>
								<td>'.$value['english'].'</td>
								<td>'.$value['science'].'</td>
								<td><a href="./index.php?action=viewProfile&sid='.$key.'">viewProfile</td>	
								<td><a href="./index.php?action=editMarks&sid='.$key.'">editMarks</td>
								<td><a href="./index.php?action=editProfile&sid='.$key.'">editProfile</td>
							</tr>';
								}
							
				$strFilterByNameHTML .= '</table>
									</fieldset>
									</div>
								</ul>
							</form>	
					</fieldset>
				</div>';



			return $strFilterByNameHTML;

		}
		
		/*
		*For getting filter by name info
		*/
		public function getFilterByNameInfo(){

			if (isset($_POST['submit'])) {
							$strKey = (string)$_POST["inputKey"];
							
							$strWhereCond = "";
							if ($strKey!="") {
								$strWhereCond = " WHERE stud_name LIKE '%$strKey%'";
							}
						}

						parent::db_Connection();
						$arrStudentInfo = array();
						$strStudName = parent::my_query("
							SELECT stud_id,stud_name 
							FROM stud_info" 
							.$strWhereCond);
						//$result = mysql_query('select * from stud_info',$link);
						
						if(!$strStudName)
							die('Invalid Query'.mysql_error());
						//$rowCount = mysql_num_rows($strStudName);
						//echo "No. of records in table".$rowCount;
						while ($arrStudentIdName = mysql_fetch_assoc($strStudName)) {

		# code...																
							$resultMarks = parent::my_query("
								SELECT sub.sub_name, m.marks
								FROM marks AS m JOIN subject AS sub ON m.sub_id = sub.sub_id
								WHERE m.stud_id = ".$arrStudentIdName['stud_id']);
							$stud_Id =  $arrStudentIdName['stud_id'];

							$arrStudentInfo[$stud_Id]['Name']=$arrStudentIdName['stud_name'];
							$arrStudentInfo[$stud_Id]['maths'] = "-";
							$arrStudentInfo[$stud_Id]['english'] = "-";
							$arrStudentInfo[$stud_Id]['science'] = "-";	
							while ($arrSubMarks = mysql_fetch_assoc($resultMarks)) {
							//echo "<pre>";print_r($arrSubMarks);

						    	
							if($arrSubMarks['sub_name']=='maths')
									$arrStudentInfo[$stud_Id]['maths']=$arrSubMarks['marks'];

							if($arrSubMarks['sub_name']=='english') 
								$arrStudentInfo[$stud_Id]['english']= $arrSubMarks['marks'];
							
							if($arrSubMarks['sub_name']=='science')
									$arrStudentInfo[$stud_Id]['science']=$arrSubMarks['marks'];
						}
					}
						//echo "<pre>";print_r($arrStudentInfo);
					return $arrStudentInfo;


		}//end of getFilterByNameInfo
		/*
		*For view user profile 
		*/
		public function viewProfileHTML(){
				$this->checkSession();		
				$strViewProfileHTML ='
					<div>
						<div id="detail" >
						<fieldset>
							<legend>Profile</legend>
								<form action="./index.php?action=filterByName" method="post">';
			$arrUserInfo = $this->getViewProfileInfo();
			//echo "<pre>";
			//print_r($arrUserInfo);
			$strViewProfileHTML .='<ul>';
								
						foreach ($arrUserInfo as $key => $value) {
									
						
						$strViewProfileHTML .='	
						<li>
							<div class="field_name"> Student Name: </div>
							<div>'.$value['Name'].'</div>
						</li>	
					
						<li>
							<div class="field_name"> Gender:</div>
							<div>'.$value['Gender'].'</div>
							
						</li>	
						<li>
							<div class="field_name"> Date of Birth:</div>
							<div>'.$value['Date of Birth'].'</div>
							
						</li>	
						<li>
							<div class="field_name">Address:</div>
							<div>'.$value['Address'].'</div>
							
						</li>

				<li>
					<div class="field_name">Subjects:</div>
					<div class="floatleft"	style="margin-left:-40px">
					<ul>
						<li>Subject&nbsp; &nbsp;&nbsp;Marks &nbsp;&nbsp;&nbsp;Month</li>
						<li>
							Maths
							<input type="text" disabled="" style="width:20px;margin-left:39px" name="m_mark"  value="'.$value['maths']['marks'].'">

							<input type="text" disabled="" style="width:20px;margin-left:19px" name="m_month" value="'.$value['maths']['month'].'">
						</li>
						<li>	
							English
							<input type="text" disabled="" style="width:20px;margin-left:30px" name="e_mark"  value="'.$value['english']['marks'].'">

							<input type="text" disabled="" style="width:20px;margin-left:19px" name="e_month" value="'.$value['english']['month'].'">
		
						</li>
						
						<li>
							Science
							<input type="text" disabled="" style="width:20px;margin-left:29px" name="s_mark" value="'.$value['science']['marks'].'">

							<input type="text" disabled="" style="width:20px;margin-left:19px" name="s_month" value="'.$value['science']['month'].'">

						</li>
						</ul>
					</div>
				</li>';	
				
				}	
			$strViewProfileHTML .='					
				<li>
					<div class="floatleft">
							
							<li><button type="submit"  name="submit">Previous Page </button>

					</div>
				</li>

			</ul>

		</form>	

		</fieldset>
	</div>
	<div>
	</div>';
		return $strViewProfileHTML; 									
	}//End of viewProfileHTML

		/*
		*For getting user info
		*/
		public function getViewProfileInfo(){



						$sid = $_GET['sid'];
						// 'male' == 'male'?print "True":print "False";
						
						parent::db_Connection();					
						
						$strStudName = parent::my_query("
							SELECT * 
							FROM stud_info 
							WHERE stud_id = $_GET[sid] ");
						//$result = mysql_query('select * from stud_info',$link);
						
						if(!$strStudName)
							die('Invalid Query'.mysql_error());
						//$rowCount = mysql_num_rows($strStudName);
						//echo "No. of records in table".$rowCount;
						while ($arrStudentIdName = mysql_fetch_assoc($strStudName)) {

		# code...																
							$resultMarks = parent::my_query("
								SELECT sub.sub_name, m.marks, m.month
								FROM marks AS m JOIN subject AS sub ON m.sub_id = sub.sub_id
								WHERE m.stud_id = ". $arrStudentIdName['stud_id']);
							$stud_Id =  $arrStudentIdName['stud_id'];

							$arrStudentInfo[$stud_Id]['Name']=$arrStudentIdName['stud_name'];
							$arrStudentInfo[$stud_Id]['Gender']=$arrStudentIdName['stud_gen'];
							$arrStudentInfo[$stud_Id]['Date of Birth']=$arrStudentIdName['stud_dob'];
							$arrStudentInfo[$stud_Id]['Address']=$arrStudentIdName['stud_add'];
							$arrStudentInfo[$stud_Id]['maths']['marks'] = "-";
							$arrStudentInfo[$stud_Id]['maths']['month'] = "-";
							$arrStudentInfo[$stud_Id]['english']['marks'] = "-";
							$arrStudentInfo[$stud_Id]['english']['month'] = "-";
							$arrStudentInfo[$stud_Id]['science']['marks'] = "-";
							$arrStudentInfo[$stud_Id]['science']['month'] = "-";	
								while ($arrSubMarks = mysql_fetch_assoc($resultMarks)) {
							//echo "<pre>";print_r($arrSubMarks);

						    	
							if($arrSubMarks['sub_name']=='maths'){
									$arrStudentInfo[$stud_Id]['maths']['marks']=$arrSubMarks['marks'];
									$arrStudentInfo[$stud_Id]['maths']['month']=$arrSubMarks['month'];
							}		
							if($arrSubMarks['sub_name']=='english'){ 
								$arrStudentInfo[$stud_Id]['english']['marks']= $arrSubMarks['marks'];
								$arrStudentInfo[$stud_Id]['english']['month']= $arrSubMarks['month'];

							}
							if($arrSubMarks['sub_name']=='science'){
									$arrStudentInfo[$stud_Id]['science']['marks']=$arrSubMarks['marks'];
									$arrStudentInfo[$stud_Id]['science']['month']=$arrSubMarks['month'];
							}							
								
							
						}
						

				
												
							
						}
						//echo "<pre>";print_r($arrStudentInfo);
						//die;
				return $arrStudentInfo;		

		}//End of getViewProfileInfo

		/*
		*For edit marks 
		*/
		public function editMarksHTML(){
				$this->checkSession();	
				$strEditMarksHTML .='
						<div id="detail" >
							<fieldset>
								<legend>Edit Marks</legend>
									<form action="./index.php?action=editMarks&sid='.$_GET['sid'].'" method="post">';
				$this->setEditMarksInfo();
				$arrUserInfo = $this->getViewProfileInfo();
				$strEditMarksHTML .='<ul>';
				foreach ($arrUserInfo as $key => $value) {
								
				$strEditMarksHTML .='
						<li>
							<div class="field_name"> Student Name: </div>
							<div>'.$value['Name'].'</div>
						</li>	
					
						<li>
							<div class="field_name"> Gender:</div>
							<div>'.$value['Gender'].'</div>
							
						</li>	
						<li>
							<div class="field_name"> Date of Birth:</div>
							<div>'.$value['Date of Birth'].'</div>
							
						</li>	
						<li>
							<div class="field_name">Address:</div>
							<div>'.$value['Address'].'</div>
							
						</li>

				<li>
					<div class="field_name">Subjects:</div>
					<div class="floatleft"	style="margin-left:-40px">
					<ul>
						<li>Subject&nbsp; &nbsp;&nbsp;Marks &nbsp;&nbsp;&nbsp;Month</li>
						<li>
							Maths
							<input type="text" style="width:20px;margin-left:39px" name="m_mark"  value="'.$value['maths']['marks'].'">

							<input type="hidden" name="prev_m_mark"  value="'.$value['maths']['marks'].'">

							<input type="text" style="width:20px;margin-left:19px" name="m_month" value="'.$value['maths']['month'].'">
						</li>
						<li>	
							English
							<input type="text" style="width:20px;margin-left:30px" name="e_mark"  value="'.$value['english']['marks'].'">

							<input type="hidden" name="prev_e_mark"  value="'.$value['english']['marks'].'">
							<input type="text" style="width:20px;margin-left:19px" name="e_month" value="'.$value['english']['month'].'">
		
						</li>
						
						<li>
							Science
							<input type="text" style="width:20px;margin-left:29px" name="s_mark" value="'.$value['science']['marks'].'">

							<input type="hidden" name="prev_s_mark" value="'.$value['science']['marks'].'">

							<input type="text" style="width:20px;margin-left:19px" name="s_month" value="'.$value['science']['month'].'">

						</li>
						</ul>
					</div>
				</li>';	
				
				}	
								
				$strEditMarksHTML .= '
								<li>
									<div class="floatleft">
									<li><button type="submit" name="submit">Edit</button></li>
									</div>
								</li>
							</ul>
						</form>	
					</fieldset>
					</div>';						
				return $strEditMarksHTML;						
		}//End of editMarksHTML

		/*
		*set Editing marks profile
		*/
		public function setEditMarksInfo() {
			$sid = $_GET['sid'];
						
						parent::db_Connection();

						if(isset($_POST['submit']))
						{
							$m_mark = $_POST['m_mark'];
							$e_mark = $_POST['e_mark'];
							$s_mark = $_POST['s_mark'];
							$m_month = $_POST['m_month'];
							$e_month = $_POST['e_month'];
							$s_month = $_POST['s_month'];
							$prev_m_mark = (int)$_POST['prev_m_mark'];
							$prev_e_mark = (int)$_POST['prev_e_mark'];
							$prev_s_mark = (int)$_POST['prev_s_mark'];	
							
						
							
							if(($m_mark > 0 AND $m_mark != $prev_m_mark) AND $prev_m_mark != 0){
							parent::my_query("
								UPDATE marks set marks = $m_mark , month = $m_month
								WHERE stud_id = $sid and sub_id = 1 " 
								);
								echo "Updated successfully";
							}else if(($prev_m_mark == 0 AND $m_mark > 0) AND $m_mark != $prev_m_mark ) {
								parent::my_query("
									Insert into marks VALUES($sid,1,$m_mark,$m_month)" 	
									);
								echo "Inserted successfully";	
							}

							if(($e_mark > 0 AND $e_mark != $prev_e_mark) AND $prev_e_mark != 0){	

							parent::my_query("
								UPDATE marks set marks = $e_mark , month = $e_month
								WHERE stud_id = $sid AND sub_id = 2"
								);
								echo "Updated successfully";
							}elseif(($prev_e_mark == 0 AND $e_mark > 0) AND $e_mark != $prev_e_mark){
								parent::my_query("
									Insert into marks VALUES($sid,2,$e_mark,$e_month)" 	
									);
								echo "Inserted successfully";
							}
							if(($s_mark > 0 AND $s_mark != $prev_s_mark)AND $prev_s_mark != 0){
							
							parent::my_query("
								UPDATE marks set marks = $s_mark , month = $s_month
								WHERE stud_id = $sid sub_id = 3"
								);
							echo "Updated successfully";
							}else if(($prev_s_mark == 0 AND $s_mark > 0) AND $s_mark != $prev_s_mark) {
									parent::mys_query("
									Insert into marks VALUES($sid,3,$s_mark,$s_month)" 	
									);
							echo "Inserted successfully";
							}
							header("Location:./index.php?action=filterByName");
						
								
						}

		}//End setEditMarksInfo
		
		/*
		*For edit profile 
		*/
		public function editProfileHTML(){
				$this->checkSession();
				$strEditProfileHTML = '
					<div id="detail">
					<fieldset>
					<legend>Profile</legend>
					<form action="./index.php?action=editProfile&sid='.$_GET['sid'].'" method="post">
				';
				$this->setEditProfile();
				$this->removeProfile();
				$arrUserInfo = $this->getViewProfileInfo();
				
				$strEditProfileHTML .= '<ul>';
						
						foreach ($arrUserInfo as $key => $value) {
						$strMaleChecked = ($value['Gender'] == 'male')?"checked":"";
						$strFemaleCheked =	($value['Gender'] == 'female')?"checked":"";	
						$strEditProfileHTML .= '
						<li>
							<div class="field_name"> Student Name: </div>
							<div class="floatleft"><input type="text" name="stud_name" value="'.$value['Name'].'"></div>
							
						</li>	
					
						<li>
							<div class="field_name"> Gender:</div>
							<div>
							
							<input type="radio" name="stud_gender" value="male" '.$strMaleChecked.'>Male
							<input type="radio" name="stud_gender" value="female"'.$strFemaleCheked.'>Female
							
							</div>
						
							
						</li>	
						<li>
							<div class="field_name"> Date of Birth:</div>
							<div class="floatleft"><input type="text" name="stud_dob" value="'.$value['Date of Birth'].'"></div>						
							
							
						</li>	
						<li>
							<div class="field_name">Address:</div>
							<div class="floatleft"><input type="text" name="stud_add" value="'.$value['Address'].'"></div>						
							
							
							
						</li>

				<li>
					<div class="field_name">Subjects:</div>
					<div class="floatleft"	style="margin-left:-40px">
					<ul>
						<li>Subject&nbsp; &nbsp;&nbsp;Marks &nbsp;&nbsp;&nbsp;Month</li>
						<li>
							Maths
							<input type="text" disabled="" style="width:20px;margin-left:39px" name="m_mark"  value="'.$value['maths']['marks'].'">

							<input type="text" disabled="" style="width:20px;margin-left:19px" name="m_month" value="'.$value['maths']['month'].'">
						</li>
						<li>	
							English
							<input type="text" disabled="" style="width:20px;margin-left:30px" name="e_mark"  value="'.$value['english']['marks'].'">

							<input type="text" disabled="" style="width:20px;margin-left:19px" name="e_month" value="'.$value['english']['month'].'">
		
						</li>
						
						<li>
							Science
							<input type="text" disabled="" style="width:20px;margin-left:29px" name="s_mark" value="'.$value['science']['marks'].'">

							<input type="text" disabled="" style="width:20px;margin-left:19px" name="s_month" value="'.$value['science']['month'].'">

						</li>
						</ul>
					</div>
				</li>';	
				
				}	
				$strEditProfileHTML .= '				
									<li>
										<div class="floatleft">
												
												<li><button type="submit"  name="submit">Edit</button>
												<button type="submit"  name="delete">Delete</button></li>

										</div>
									</li>

								</ul>

							</form>	

							</fieldset>
						</div>';
				
				print $strEditProfileHTML;	exit;

		}//End of editProfileHTML
		/*
		*set user profile info
		*/
		public function setEditProfile(){

						$sid = $_GET['sid'];
						parent::db_Connection();

						if(isset($_POST['submit']))
						{	
							$stud_Name = $_POST['stud_name'];
							$stud_Gen = $_POST['stud_gender'];
							$stud_Dob = $_POST['stud_dob'];
							$stud_Add = $_POST['stud_add'];
							mysql_query("
								UPDATE stud_info set stud_name = '$stud_Name' , stud_gen = '$stud_Gen',
								stud_dob = '$stud_Dob' ,stud_add = '$stud_Add' 
								WHERE stud_id = $sid " 
								);
						
							echo "Information Updated successfully";
							header("Location:./index.php?action=filterByName");
										
								
						}
						if(isset($_POST['delete']))
						{
							mysql_query("
								Delete from stud_info
								WHERE stud_id = $sid "
								);
							

							echo "Data is deleted sudccessfully";
							header("Location:./index.php?action=filterByName");
    
	
						}

		}//End of setEditProfileHTML
		/*
		*remove user profile info
		*/
		public function removeProfile(){

						$sid = $_GET['sid'];
						parent::db_Connection();
						if(isset($_POST['delete']))
						{
							mysql_query("
								Delete from stud_info
								WHERE stud_id = $sid "
								);
							

							echo "Data is deleted sudccessfully";
							header("Location:./index.php?action=filterByName");
    
	
						}

		}//End of setEditProfileHTML

}



?>