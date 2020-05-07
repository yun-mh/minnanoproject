<?php include "includes/db.php"; ?>
<?php include "includes/functions.php"; ?>

<?php
if(isset($_POST['findid'])) {
	
	$user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
	
	$error = [
		
		'blank'=>'',
		'noexists'=>'',
		
	];
	

	if($user_email == ''){

  	$error['blank'] = 'メールアドレスを入力してください。';

	}
	
	if(!email_exists($user_email)) {
		
		if($user_email == ''){

  		$error['blank'] = 'メールアドレスを入力してください。';

		} else {
			
			$error['noexists'] = '登録されていないメールアドレスです。';
		}
		
	}
	
	foreach ($error as $key => $value) {
	
		if(empty($value)) {

			unset($error[$key]);
		
		}
		
	}
	
	if(empty($error)) {
		
		$email_query = "SELECT user_id FROM users WHERE user_email = '$user_email'";
		$find_query = mysqli_query($connection, $email_query);
		
		$row = mysqli_fetch_assoc($find_query);
		$result = $row['user_id'];
		
		$success = 'IDを見つけました！<br>'; 
		
	}
	
} 

?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    
    <title>みんなのプロジェクト</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
  	<link rel="stylesheet" href="css/index.css">
  	<link rel="shortcut icon" href="images/favicon.ico">
  	
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
					<div class="card text-center mx-auto shadow" style="width: 350px;">
						<div class="card-header">
							ID探し
						</div>
						<div class="card-body">
							
							<?php echo isset($error['blank']) ? "<div class='alert alert-danger px-1 py-1 mt-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['blank'] . "</small></div>" : ''; ?>
							<?php echo isset($error['noexists']) ? "<div class='alert alert-danger px-1 py-1 mt-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['noexists'] . "<br><a href='registration.php'>会員登録</a></small></div>" : ''; ?>
							<?php echo isset($success) ? "<div class='alert alert-success px-1 py-1 mt-1 mb-3' role='alert'><small><i class='fas fa-check-circle'></i> " . $success . "あなたのID：<b>" . $result . "</b><br><a href='index.php'>ログインへ</a>". "</small></div>" : ''; ?>
							
							<h4 class="text-center"><i class="fas fa-id-card"></i> IDを忘れましたか？</h4>
							<p><small>メールアドレスの入力で、IDを探すことができます。</small></p>						
						
							<form id="login-form" action="findid.php" method="post" role="form">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-at fa-fw"></i></span>	
										</div>
										<input type="email" name="user_email" tabindex="1" class="form-control" placeholder="メールアドレス" autocomplete="off">
									</div>
								</div>
								<div class="form-group">     
									<input type="submit" name="findid" id="login-submit" tabindex="4" class="form-control btn btn-primary" value="ID検索">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</article>

                          
 	  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-validate.js"></script>

  </body>    
</html>