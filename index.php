<?php include "includes/db.php"; ?>
<?php include "includes/functions.php"; ?>

<?php

checkIfLoggedIn('home.php');

if(ifItIsMethod('post')) {
	if(isset($_POST['username']) && isset($_POST['password'])){
		login_user($_POST['username'], $_POST['password']);
	} else {
		header("Location: index.php");
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
    				<img src="images/hewlogo.gif" width="30" height="30" class="d-inline-block align-top" alt="logo">
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
					<div class="card text-center mx-auto shadow" style="width: 300px;">
						<div class="card-header">
							LOGIN
						</div>
						<div class="card-body">
						
							<?php echo isset($_GET['msg']) ? "<div class='alert alert-danger px-1 py-1 mt-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> IDやパスワードを確認してください。</small></div>" : ''; ?>
						
							<form id="login-form" action="login.php" method="post" role="form">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-id-card fa-fw"></i></span>	
										</div>
										<input type="text" name="user_id" id="loginid" tabindex="1" class="form-control" placeholder="ID" autocomplete="off">
									</div>								
								</div>
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-key fa-fw"></i></span>	
										</div>
										<input type="password" name="user_password" id="loginpassword" tabindex="2" class="form-control" placeholder="パスワード">
									</div>									
								</div>
								<div class="form-group">     
									<input type="submit" name="login" id="login-submit" tabindex="4" class="form-control btn btn-primary" value="ログイン">
								</div>
								<div class="form-group col-12">
									<small><a href="findid.php">ID探し</a>
									　|　
									<a href="forgotpw.php?val=<?php echo uniqid(true);?>">パスワード再設定</a></small>
								</div>
							</form>
						</div>
						<div class="card-footer">
							<a href="registration.php">会員登録</a>
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