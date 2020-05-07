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
								include "post_notice.php";
							break;
							
							case 'member';
								$board = 2;
								include "post_member.php";
							break;
							
							case 'project';
								$board = 3;
								include "post_project.php";
							break;
							
							case 'qna';
								$board = 4;
								include "post_qna.php";
							break;
							
							case 'stage';
								$board = 5;
								include "post_stage.php";
							break;
							
					}
				
				?>

				

			<?php include "includes/footer.php";?>

 		                                
 	  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>   
  </body>    
</html>
