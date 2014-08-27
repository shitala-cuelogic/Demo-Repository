<?php

	$strKey = (string)$_GET['inputKey'];
	$strWhereCond = "";
	
	if ($strKey!="") {
			$strWhereCond = " WHERE stud_name LIKE '%$strKey%'";
	}

						$strlink = mysql_connect('localhost','root','');

						if(!$strlink)
							die('Could not connect: '.mysql_error()); 

						$db_student =mysql_select_db('db_student',$strlink);
			
						if(!$db_student)
							die('<br>Cant use student database'.mysql_error());
						
						$arrStudentInfo = array();
						$strStudName = mysql_query("
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
							$resultMarks = mysql_query("
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

			$strFilterByNameHTML ='	<table border=1>
							<tr>
								
								<th>Student Name</th>
								<th>Maths</th>
								<th>English</th>
								<th>Science</th>
								<th>Action</th>
								<th>Edit_Marks</th>
								<th>Edit_profile</th>
							</tr>';
							
								foreach ($arrStudentInfo as $key => $value) {
							
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

	$strFilterByNameHTML .= '</table>';							
echo $strFilterByNameHTML;exit;
?>