<?php include "includes/db.php"; ?>
<?php include "includes/functions.php"; ?>

<?php

	require './vendor/autoload.php';

	if(!isset($_GET['val'])) {
		header("Location: index.php");
	}

	if(ifItIsMethod('post')){
  	if(isset($_POST['email']) && isset($_POST['user_id'])) {
			$email = $_POST['email'];
			$user_id = $_POST['user_id'];
			$length = 50;
			$token = bin2hex(openssl_random_pseudo_bytes($length));
			
			$error = [	
					'id_noexist'=>'',
					'mail_noexist'=>''
				];
				
			if(userID_exists($user_id) == false) {
				$error['id_noexist'] = '登録されていないIDです。';
			}

			if(email_exists($email) == false) {
				$error['mail_noexist'] = '登録されていないメールアドレスです。';
			}
			
			if(validate_account($user_id, $email) == false) {
				$error['nomatch'] = 'IDかメールアドレスが一致しません。';
			}
								
			foreach ($error as $key => $value) {
				if(empty($value)) {
					unset($error[$key]);
				}
			}
	
			if(validate_account($user_id, $email) && empty($error)) {
				if($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email= ?")) {
						
					mysqli_stmt_bind_param($stmt, "s", $email);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);
					
					$mail = new PHPMailer\PHPMailer\PHPMailer();

					/*$mail->isSMTP();*/ /*学校で実行し、解除*/
					$mail->Host = 'smtp.naver.com';
					$mail->Username = 'hew_project';
					$mail->Password = 'nhs80416';
					$mail->Port = 587;
					$mail->SMTPSecure = 'tls';
					$mail->SMTPAuth = true;
					$mail->isHTML(true);
					$mail->CharSet = 'UTF-8';
					
					$mail->setFrom('hew_project@naver.com', 'Hew_admin');
					$mail->addAddress($email);

					$mail->Subject = '[みんなのプロジェクト] パスワード再設定案内';

					$mail->Body = '<p>こんにちは！みんなのプロジェクトです。</p><p>パスワード再設定の案内メールです。</p><p>次のリンクをクリックするとパスワード再設定ページが開きます。</p>

					<a href="http://localhost:1024/hew/reset.php?email='.$email.'&token='.$token.' ">http://localhost:1024/hew/reset.php?email='.$email.'&token='.$token.'</a>

					';
					
					if($mail->send()){
							$emailSent = true;
					} else {
							echo "Mailer エラー: " . $mail->ErrorInfo;
					}	
				}					
			}	
		}
	}
?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    
    <title>みんなのプロジェクト</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/index.css">
  	<link rel="shortcut icon" href="images/favicon.ico">
  	<link rel="stylesheet" href="css/all.min.css">
  	
	</head>  
			
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
						
						<?php echo isset($error['id_noexist']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['id_noexist'] . "</small></div>" : ''; ?>
						<?php echo isset($error['nomatch']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['nomatch'] . "</small></div>" : ''; ?>
						<?php echo isset($error['mail_noexist']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['mail_noexist'] . "</small></div>" : ''; ?>
						

						<?php if(!isset($emailSent)): ?>

							<h4 class="text-center"><i class="fas fa-lock text-secondary"></i> パスワードを忘れましたか？</h4>
							<p class="text-justify"><small>登録したメールアドレス宛にパスワード再設定用リンクを送ります。</small></p>
							
								<form id="register-form" role="form" autocomplete="off" class="form" method="post">
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-user fa-fw"></i></span>
											</div>
											<input id="user_id" name="user_id" placeholder="ID" class="form-control" type="text">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-at fa-fw"></i></span>
											</div>
											<input id="email" name="email" placeholder="メールアドレス" class="form-control" type="email">
										</div>
									</div>
									<div class="form-group">
										<input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="送信" type="submit">
									</div>
									<input type="hidden" class="hide" name="token" id="token" value="">
								</form>

						<?php else: ?>

						<div class='alert alert-success px-1 py-1 mt-1 mb-3' role='alert'><small><i class="fas fa-envelope"></i> メールを送信しました!<br>メール箱をチェックしてください。</small></div>

						<?php endIf; ?>

						</div>
					</div>
				</div>
			</div>
		</article>

                          
 	  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-validate.js"></script>

		<script>
			bootstrapValidate('#user_id','required:IDを入力してください。');		
			bootstrapValidate('#email','required:メールアドレスを入力してください。');
		</script>	

  </body>    
</html>