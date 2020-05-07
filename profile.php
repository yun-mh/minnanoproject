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

if(isset($_SESSION['user_id'])) {
	
	$user_id = $_SESSION['user_id'];
	
	$query = "SELECT * FROM users WHERE user_id = '{$user_id}' ";
	$select_user_info_query = mysqli_query($connection, $query);
	confirmQuery($select_user_info_query);
	
	while($row = mysqli_fetch_array($select_user_info_query)) {
		
		$db_user_password = $row['user_password'];
		$user_email = $row['user_email'];
		$user_major = $row['user_major'];
			
	}
	
}

?>		
		

<?php

if(isset($_POST['update_profile'])) {

	$user_password_pre = mysqli_real_escape_string($connection, $_POST['user_password_pre']);
	$user_password_new = mysqli_real_escape_string($connection, $_POST['user_password_new']);
	$user_password_chk = mysqli_real_escape_string($connection, $_POST['user_password_chk']);
	$user_major = mysqli_real_escape_string($connection, $_POST['user_major']);
	
	$error = [
		
		'blank'=>'',
		'notmatch'=>'',
		'wrong'=>'',
		'pw'=>''
		
	];
	
	if(!password_verify($user_password_pre, $db_user_password) && $user_password_pre != '') {
		
		$error['wrong'] = '既に登録されているパスワードとは違うパスワードを入力しました。';
		
	}
	
	if($user_password_pre == '') {
			
  	$error['blank'] = '現在使っているパスワードを記入してください。';
		
	}
	
	if($user_password_new != $user_password_chk) {
		$error['notmatch'] = '新しいパスワードとパスワード確認が一致しません。';
	}
	
	if(($user_password_new == '' && $user_password_chk != '') || ($user_password_new != '' && $user_password_chk == '')) {
		$error['pw'] = '新しいパスワード欄やパスワード確認欄に、入力漏れがあります。';
	}
	
	foreach ($error as $key => $value) {
	
		if(empty($value)) {

			unset($error[$key]);
		
		}
		
	}	
	
	if(empty($error)) {
		
		$user_password = password_hash($user_password_new, PASSWORD_BCRYPT, array('cost' => 12));
		
		if($user_password_new != '' && $user_password_chk != '') {
			
			$query = "UPDATE users SET ";
			$query .= "user_password = '{$user_password}', ";
			$query .= "user_major = '{$user_major}' ";
			$query .= "WHERE user_id = '{$user_id}' ";

			$update_user_query = mysqli_query($connection, $query);

			confirmQuery($update_user_query);
			$_SESSION['user_major'] = $user_major;
			
		} elseif($user_password_new == '' && $user_password_chk == '') {
			
			$query = "UPDATE users SET ";
			$query .= "user_major = '{$user_major}' ";
			$query .= "WHERE user_id = '{$user_id}' ";
			
			$update_user_query = mysqli_query($connection, $query);

			confirmQuery($update_user_query);
			$_SESSION['user_major'] = $user_major;
		
		} 
		
		
		$success = '会員情報を成功的に変更しました。'; 
		
	}
	
}
		
		
?>
				
	
			<article>
				<div id="jumbotron_profile" class="jumbotron text-white text-shadow">
					<div class="container">
						<h2>会員情報変更</h2>
						<p class="lead">
  						ここで登録した会員情報を変更できます。(変更可能な項目：パスワード・学科)
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
								<?php echo isset($error['notmatch']) ? "<div class='alert alert-danger px-1 py-1 my-1' role='alert'><i class='fas fa-times-circle'></i><small>　" . $error['notmatch'] . "</small></div>" : ""; ?>
								<?php echo isset($error['pw']) ? "<div class='alert alert-danger px-1 py-1 my-1' role='alert'><i class='fas fa-times-circle'></i><small>　" . $error['pw'] . "</small></div>" : ""; ?>
								<?php echo isset($success) ? "<div class='alert alert-success px-1 py-1 my-1' role='alert'><i class='fas fa-check-circle'></i><small>　" . $success . "</small></div>" : ""; ?>
		
									<form action="" method="post">
										<table class="mt-3" style="width: 560px;">
											<tr>
												<td class="font-weight-bold text-right pr-3">ID</td>
												<td><input type="text" class="form-control my-2" value="<?php echo $user_id;?>" disabled></td>
												<td><button type="button" class="btn btn-danger ml-2" onclick="location.href='optout.php'">会員脱退</button></td>
											</tr>
											<tr>
												<td class="font-weight-bold text-right pr-3">メールアドレス</td>
												<td><input type="email" class="form-control my-2" value="<?php echo $user_email;?>" disabled></td>
												<td></td>
											</tr>
											<tr>
												<td class="font-weight-bold text-right pr-3">現在のパスワード</td>
												<td><input type="password" id="prepw" class="form-control my-2" name="user_password_pre"></td>
												<td></td>
											</tr>
											<tr>
												<td class="font-weight-bold text-right pr-3">
													<span class="text-secondary" data-toggle="tooltip" data-placement="left" title="パスワード変更時のみ入力">
														<i class="fas fa-info-circle"></i> 新しいパスワード
													</span>
												</td>
												<td><input type="password" id="newpw" class="form-control my-2" name="user_password_new"></td>
												<td></td>
											</tr>
											<tr>
												<td class="font-weight-bold text-right pr-3">
													<span class="text-secondary" data-toggle="tooltip" data-placement="left" title="パスワード変更時のみ入力">
														<i class="fas fa-info-circle"></i> パスワード確認
													</span>
												</td>
												<td><input type="password" id="chkpw" class="form-control my-2" name="user_password_chk"></td>
												<td></td>
											</tr>
											<tr>
												<td class="font-weight-bold text-right pr-3">学科</td>
												<td>
													<select name="user_major" class="custom-select my-2">
														<option value="1" <?php echo $user_major == 1 ? "selected" : ""?>>ゲーム系</option>
														<option value="2" <?php echo $user_major == 2 ? "selected" : ""?>>CG・映像系</option>
														<option value="3" <?php echo $user_major == 3 ? "selected" : ""?>>音楽系</option>
														<option value="4" <?php echo $user_major == 4 ? "selected" : ""?>>カーデザイン・ロボット系</option>
														<option value="5" <?php echo $user_major == 5 ? "selected" : ""?>>IT・WEB系</option>
													</select>
												</td>
												<td></td>
											</tr>	 
										</table>
										<div class="row">
											<div class="mx-auto mt-3">
												<input type="reset" class="btn btn-outline-warning mr-4" value="リセット">
												<input type="submit" class="btn btn-outline-success mr-4" value="変更する" name="update_profile">
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

 		                                
 	  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
 	  <script src="js/popper.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-validate.js"></script>
    
    
    <script>			
			bootstrapValidate('#chkpw','matches:#newpw:パスワードが一致しません。');
			bootstrapValidate('#prepw','required:パスワードを入力してください。');
		</script>
		
		<script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();   
			});
		</script>
		
  </body>    
</html>