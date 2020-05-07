<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    
    <title>みんなのプロジェクト</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/page.css">
  	<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
  	<link rel="stylesheet" href="css/font-awesome-animation.min.css">
  	
  	  
			<!--　ヘッダ　-->
			<?php include "includes/header.php";?>
			
			
				
				<?php
				
					if(isset($_GET['board'])) {
						$board = $_GET['board'];
					} else {
						$board = '';
					}
				
					switch($board) {
							
							case 'notice';
								$board = 1;
								include "read_notice.php";
							break;
							
							case 'member';
								$board = 2;
								include "read_member.php";
							break;
							
							case 'project';
								$board = 3;
								include "read_project.php";
							break;
							
							case 'qna';
								$board = 4;
								include "read_qna.php";
							break;
							
							case 'stage';
								$board = 5;
								include "read_stage.php";
							break;
							
					}
				
				?>

			 
</html>
