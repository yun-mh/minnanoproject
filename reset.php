<?php  include "includes/db.php"; ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    
    <title>みんなのプロジェクト</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/index.css">
  	<link rel="stylesheet" href="css/all.min.css">
  	<link rel="shortcut icon" href="images/favicon.ico">
  	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
  	
	</head> 


<!-- パスワード再設定完了のモーダル -->
<div class="modal fade" id="result" tabindex="-1" role="dialog" aria-labelledby="pw_success" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pw_success">パスワード再設定完了</h5>
      </div>
      <div class="modal-body">
        パスワードを再設定しました。
      </div>
      <div class="modal-footer">
        <a href="index.php" class="btn btn-success">確認</a>
      </div>
    </div>
  </div>
</div>


<?php

if(!isset($_GET['email']) && !isset($_GET['token'])) {	
	header("Location: index.php");
}

if($stmt = mysqli_prepare($connection, 'SELECT user_id, user_email, token FROM users WHERE token=?')) {
	mysqli_stmt_bind_param($stmt, "s", $_GET['token']);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $user_id, $user_email, $token);
	mysqli_stmt_fetch($stmt);
	mysqli_stmt_close($stmt);

	if(isset($_POST['password']) && isset($_POST['confirmPassword'])) {
		
		$error = [	
			'blank'=>'',
			'notmatch'=>'',
			'format_pw'=>''
		];

		if(strlen($_POST['password']) < 5 || !preg_match("/^[\w]+$/",$_POST['password'])) {
			$error['format_pw'] = 'パスワードは5文字数以上の英・数字で記入してください。';
		}

		if($_POST['password'] == '' or $_POST['confirmPassword'] == '') {
			$error['blank'] = '全ての記入欄を埋めてください。';
		}

		if($_POST['password'] !== $_POST['confirmPassword']) {
			$error['notmatch'] = 'パスワードが一致しません。';
		}
		
		foreach ($error as $key => $value) {	
			if(empty($value)) {
				unset($error[$key]);
			}
		}
		
		if(($_POST['password'] === $_POST['confirmPassword']) && empty($error)){
			$password = $_POST['password'];
			$hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

			if($stmt = mysqli_prepare($connection, "UPDATE users SET token='', user_password='{$hashedPassword}' WHERE user_email = ?")){
				mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
				mysqli_stmt_execute($stmt);

				if(mysqli_stmt_affected_rows($stmt) >= 1)	{ 
					echo '<script type="text/javascript"> $("#result").modal("show")</script>';
				}

				mysqli_stmt_close($stmt);

			}
		}
	}
}

?>
			
	<body>
		
		<header>
			<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow">
				<div class="container">
					<a class="navbar-brand" href="index.php">
    				<img src="images/hewlogo.gif" width="30" height="30" class="d-inline-block align-top" alt="">
    				みんなのプロジェクト
    			</a>
					<span class="navbar-text">
						みんなの力で、より大きな夢へ
					</span>
				</div>
			</nav>
		</header>

		<article class="index-bg">
			<div class="container h-100">
				<div class="row h-100 align-items-center">
					<div class="card text-center mx-auto shadow" style="width: 400px;">
						<div class="card-header">
							パスワード再設定
						</div>
						<div class="card-body">										
							<p class="mb-0">パスワードを再設定してください。</p>
							
							<?php echo isset($error['format_pw']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['format_pw'] . "</small></div>" : ''; ?>
							<?php echo isset($error['blank']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['blank'] . "</small></div>" : ''; ?>
							<?php echo isset($error['notmatch']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['notmatch'] . "</small></div>" : ''; ?>
							
							<div class="card-body">
								<form id="register-form" role="form" autocomplete="off" class="form" method="post">
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-key fa-fw"></i></span>	
											</div>
											<input id="password" name="password" placeholder="新しいパスワード" class="form-control"  type="password">
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-eye fa-fw"></i></span>
											</div>
											<input id="confirm_password" name="confirmPassword" placeholder="パスワード確認" class="form-control"  type="password">
										</div>
									</div>

									<div class="form-group">
										<input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="再設定" type="submit">
									</div>

									<input type="hidden" class="hide" name="token" id="token" value="">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

		</article>
  
    <script src="js/bootstrap-validate.js"></script>
    
    <script>
			bootstrapValidate('#password','required:パスワードを設定してください。');
			bootstrapValidate('#password','min:5:5文字以上の英数字で設定してください。');
			bootstrapValidate('#password','alphanum:英字または数字で設定してください。');
			bootstrapValidate('#confirm_password','matches:#password:パスワードが一致しません。');
			bootstrapValidate('#confirm_password','required:パスワードを入力してください。');
		</script>   
  </body>    
</html>

