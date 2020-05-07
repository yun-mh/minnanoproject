<?php include "includes/db.php"; ?>
<?php include "includes/functions.php"; ?>

<?php 
/*　会員登録の処理　*/
$user_id = "";
$user_email = "";

if(isset($_POST['regID'])) {
	
	$user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
	$user_password1 = mysqli_real_escape_string($connection, $_POST['user_password1']);
	$user_password2 = mysqli_real_escape_string($connection, $_POST['user_password2']);
	$user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
	$user_major = mysqli_real_escape_string($connection, $_POST['user_major']);	
	
	$error = [
		
		'user_id'=>'',
		'user_email'=>'',
		'user_major'=>'',
		'blank'=>'',
		'notmatch'=>'',
		'format'=>''
		
	];
	
	
	
	if($user_id == '' or $user_password1 == '' or $user_password2 == '' or $user_email == '' or $user_major == ''){
  	$error['blank'] = '全ての記入欄を埋めてください。';
	}
	
	if(userID_exists($user_id)) {
		$error['user_id'] = '既に登録されているIDです。';
	}
	
	if(email_exists($user_email)) {
		$error['user_email'] = '既に登録されているメールアドレスです。';
	}
	
	if($user_password1 != $user_password2) {
		$error['notmatch'] = 'パスワードが一致しません。';
	}
	
	if((strlen($user_id) < 5 || strlen($user_id) > 12) || !preg_match("/^[\w]+$/",$user_id)) {
		$error['format'] = 'IDは5~12文字数の英・数字で記入してください。';
	}
	
	if(strlen($user_password1) < 5 || !preg_match("/^[\w]+$/",$user_password1)) {
		$error['format_pw'] = 'パスワードは5文字数以上の英・数字で記入してください。';
	}
	
	foreach ($error as $key => $value) {
	
		if(empty($value)) {

			unset($error[$key]);
		
		}
		
	}
	
	if(empty($error)) {
		
		register_user($user_id, $user_password1, $user_email, $user_major);
		
		$success = '会員登録を完了しました！'; 
		
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
		<a href="index.php"></a>
		
		<article class="index-bg">
			<div class="container h-100">
				<div class="row h-100 align-items-center">
					<div class="card text-center mx-auto shadow" style="width: 350px;">
						<div class="card-header">
							SIGNUP
						</div>
						<div class="card-body">
							
								<?php echo isset($error['user_id']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['user_id'] . "</small></div>" : ''; ?>
								<?php echo isset($error['format']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['format'] . "</small></div>" : ''; ?>
								<?php echo isset($error['format_pw']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['format_pw'] . "</small></div>" : ''; ?>
								<?php echo isset($error['blank']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['blank'] . "</small></div>" : ''; ?>
								<?php echo isset($error['notmatch']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['notmatch'] . "</small></div>" : ''; ?>
								<?php echo isset($error['user_email']) ? "<div class='alert alert-danger px-1 py-1 mb-3' role='alert'><small><i class='fas fa-times-circle'></i> " . $error['user_email'] . "</small></div>" : ''; ?>
								<?php echo isset($success) ? "<div class='alert alert-success px-1 py-1 mb-3' role='alert'><small><i class='fas fa-check-circle'></i> " . $success . "<br><a href='index.php'>ログインへ</a>". "</small></div>" : ''; ?>
							
							<form id="register-form" action="" method="post" role="form">
								<div class="form-group">
									<input type="text" name="user_id" id="regid" tabindex="1" class="form-control" placeholder="ID(半角英数字・5~12文字)" autocomplete="off">
								</div>

								<div class="form-group">
									<input type="password" name="user_password1" id="regpw1" tabindex="2" class="form-control" placeholder="パスワード(半角英数字・5文字以上)">
								</div>
								<div class="form-group">
									<input type="password" name="user_password2" id="regpw2" tabindex="3" class="form-control" placeholder="パスワード確認">
								</div>
								<div class="form-group">
									<input type="email" name="user_email" id="regemail" tabindex="4" class="form-control" placeholder="メールアドレス" autocomplete="off">
								</div>
								<div class="form-group">
									<select class="custom-select" id="regmajor" name="user_major" tabindex="5">
										<option value="1">ゲーム系</option>
										<option value="2">CG・映像系</option>
										<option value="3">音楽系</option>
										<option value="4">カーデザイン・ロボット系</option>
										<option value="5">IT・WEB系</option>
									</select>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-12">
											<input type="submit" name="regID" id="register-submit" tabindex="6" class="form-control btn btn-success" value="登録する">
										</div>
									</div>
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
    
    <script>
			bootstrapValidate('#regid','min:5:5~12文字数の英数字で設定してください。');
			bootstrapValidate('#regid','max:12:5~12文字数の英数字で設定してください。');
			bootstrapValidate('#regid','alphanum:英字または数字で設定してください。');
			bootstrapValidate('#regid','required:IDを設定してください。');		
			bootstrapValidate('#regpw1','required:パスワードを設定してください。');
			bootstrapValidate('#regpw1','min:5:5文字以上の英数字で設定してください。');
			bootstrapValidate('#regpw1','alphanum:英字または数字で設定してください。');
			bootstrapValidate('#regpw2','matches:#regpw1:パスワードが一致しません。');
			bootstrapValidate('#regpw2','required:パスワードを入力してください。');
			bootstrapValidate('#regemail','email:メールアドレスのフォーマットで入力してください。');
			bootstrapValidate('#regemail','required:メールアドレスを入力してください。');
		</script>	
  </body>    
</html>