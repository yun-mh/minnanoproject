<?php ob_start(); ?>
<?php session_start(); ?> 
<?php include "db.php"; ?>
<?php include "functions.php"; ?>

<?php
if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}

?>
		

		<link rel="stylesheet" href="css/frame.css">
		<link rel="stylesheet" href="css/all.min.css">
		<link rel="shortcut icon" href="images/favicon.ico">
	</head>   
	 
  <body>
    <header>
    	<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow justify-content-between" style="background-color: #f5f5f5;">
    		<div class="container">
    			<a class="navbar-brand" href="home.php">
    				<img src="images/hewlogo.gif" width="30" height="30" class="d-inline-block align-top" alt="">
    				みんなのプロジェクト
    			</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav mr-auto">
							<li class='nav-item'>
								<a class='nav-link' href='about.php'>紹介</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='page.php?board=notice&p_cat=0&page=1'>お知らせ</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='page.php?board=member&p_cat=0&page=1'>メンバー募集</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='page.php?board=project&p_cat=0&page=1'>プロジェクトルーム</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='page.php?board=qna&p_cat=0&page=1'>Q&amp;A</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='page.php?board=stage&p_cat=0&page=1'>ステージ</a>
							</li>
							
						</ul>
							
						<ul class="navbar-nav">
							<li class="nav-item dropdown">
								<a href="" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fas fa-user-circle fa-fw"></i>    <?php echo '<b>'. $_SESSION['user_id'] . '</b> さん'; ?><b class="caret"></b></a>
								<div class="dropdown-menu">
									<a href="profile.php" class="dropdown-item"><i class="fas fa-user-edit fa-fw"></i> 情報変更</a>
									<a href="logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt fa-fw"></i> ログアウト</a>
								</div>
							</li>
						</ul>
					</div>
    		</div>
			</nav>
		</header>
