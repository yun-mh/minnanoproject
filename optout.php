<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    
    <title>みんなのプロジェクト</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/page.css">
 	  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
  	  
  	  
			<!--　ヘッダ　-->
			<?php include "includes/header.php";?>


<?php

if(isset($_SESSION['user_id'])) {
	
	$user_id = $_SESSION['user_id'];
	
	$query = "SELECT * FROM users WHERE user_id = '{$user_id}' ";
	$select_user_info_query = mysqli_query($connection, $query);
	confirmQuery($select_user_info_query);
	
	while($row = mysqli_fetch_array($select_user_info_query)) {
		
		$db_user_id = $row['user_id'];
		$db_user_password = $row['user_password'];
			
	}
	
}

?>		

<!-- 会員脱退完了のモーダル -->
<div class="modal fade" id="delresult" tabindex="-1" role="dialog" aria-labelledby="delmodal" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">会員脱退完了</h5>
      </div>
      <div class="modal-body">
        会員脱退が完了しました。今までありがとうございました！
      </div>
      <div class="modal-footer">
        <a href="index.php" class="btn btn-success">確認</a>
      </div>
    </div>
  </div>
</div>		
				
								

<?php

if(isset($_POST['delete_id'])) {

	$user_password = mysqli_real_escape_string($connection, $_POST['user_password']);
	
	
	$error = [
		
		'blank'=>'',
		'wrong'=>''
		
	];
	
	if(!password_verify($user_password, $db_user_password) && $user_password != '') {
		
		$error['wrong'] = 'パスワードを確認してください。';
		
	}
	
	if($user_password == '') {
			
  	$error['blank'] = 'パスワードを入力してください。';
		
	}
	

	foreach ($error as $key => $value) {
	
		if(empty($value)) {

			unset($error[$key]);
		
		}
		
	}	
	
	if(empty($error)) {
			
			$query = "DELETE FROM users ";
			$query .= "WHERE user_id = '{$db_user_id}' ";
			
			$delete_id_query = mysqli_query($connection, $query);

			confirmQuery($delete_id_query);
		
			$_SESSION = array();
			session_destroy();
		
			echo '<script type="text/javascript"> $("#delresult").modal("show")</script>';
			
		
	}
	
}
		
		
?>
				
	
			<article>
				<div id="jumbotron_optout" class="jumbotron text-white text-shadow">
					<div class="container">
						<h2>会員脱退</h2>
						<p class="lead">
  						ここで会員から脱退することができます。
						</p>
					</div>
				</div>
				
				<div class="container">
					<div class="row">
						<div class="mx-auto">
							<div class="card mt-5" style="width: 600px;">
								<div class="card-body">
								
								<?php echo isset($error['wrong']) ? "<div class='alert alert-danger px-1 py-1 my-1' role='alert'><i class='fas fa-times-circle'></i><small>　" . $error['wrong'] . "</small></div>" : ""; ?>	
								<?php echo isset($error['blank']) ? "<div class='alert alert-danger px-1 py-1 my-1' role='alert'><i class='fas fa-times-circle'></i><small>　" . $error['blank'] . "</small></div>" : ""; ?>
		
									<form action="" method="post">
										<table class="mx-auto mt-3" style="width: 350px;">
											<tr>
												<td class="font-weight-bold text-right pr-3">ID</td>
												<td><input type="text" class="form-control my-2" value="<?php echo $user_id;?>" disabled></td>
											</tr>
											<tr>
												<td class="font-weight-bold text-right pr-3">パスワード</td>
												<td><input type="password" id="password" class="form-control my-2" name="user_password"></td>
											</tr>
										</table>
										<div class="row">
											<div class="mx-auto mt-3">
												<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteID">
													脱退する
												</button>
											</div>
											<!-- 脱退確認のモーダル -->
											<div class="modal fade" id="deleteID" tabindex="-1" role="dialog" aria-labelledby="modifyCheck" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="postCheck">会員脱退</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															本当に会員から脱退しましか？
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
															<button type="submit" name="delete_id" class="btn btn-danger">脱退する</button>
														</div>
													</div>
												</div>
											</div>
				
										</div>
									</form>
								</div>
							</div>
						</div>	
					</div>
				</div>
				
				
				
			</article>
			
		<?php include "includes/footer.php";?>

 		                                
 	  <script src="js/bootstrap-validate.js"></script>
    
    <script>
			bootstrapValidate('#password','required:パスワードを入力してください。');
		</script>
  </body>    
</html>