<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    
    <title>みんなのプロジェクト</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/page.css">
  	
  	  
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
								include "notice_board.php";
							break;
							
							case 'member';
								$board = 2;
								include "member_board.php";
							break;
							
							case 'project';
								$board = 3;
								include "project_board.php";
							break;
							
							case 'qna';
								$board = 4;
								include "qna_board.php";
							break;
							
							case 'stage';
								$board = 5;
								include "stage_board.php";
							break;
							
					}
				
				?>

			<?php include "includes/footer.php";?>

 		                                
 	  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
 	  
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
 
  </body>    
</html>
