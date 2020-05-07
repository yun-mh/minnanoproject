<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    
    <title>みんなのプロジェクト</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/home.css">
  	  
  	  
			<!--　ヘッダ　-->
			<?php include "includes/header.php";?>

			<!-- カルーセル -->
			<div id="carousel" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carousel" data-slide-to="0" class="active"></li>
					<li data-target="#carousel" data-slide-to="1"></li>
					<li data-target="#carousel" data-slide-to="2"></li>
					<li data-target="#carousel" data-slide-to="3"></li>
					<li data-target="#carousel" data-slide-to="4"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active" data-interval="7000">
						<img src="images/notice.jpg" class="d-block w-100" alt="お知らせイメージ">
						<div class="carousel-caption text-right d-none d-md-block">
							<h2 class="text-shadow">お知らせ</h2>
							<p class="text-shadow">管理者からのお知らせをチェック！</p>
						</div>
					</div>
					<div class="carousel-item" data-interval="7000">
						<img src="images/member.jpg" class="d-block w-100" alt="メンバー募集イメージ">
						<div class="carousel-caption text-right d-none d-md-block">
							<h2 class="text-shadow">メンバー募集</h2>
							<p class="text-shadow">プロジェクトに必要な仲間を集めよう！</p>
						</div>
					</div>
					<div class="carousel-item" data-interval="7000">
						<img src="images/project.jpg" class="d-block w-100" alt="プロジェクトルームイメージ">
						<div class="carousel-caption text-right d-none d-md-block">
							<h2 class="text-shadow">プロジェクトルーム</h2>
							<p class="text-shadow">プロジェクトついてメンバー間で話し合おう！</p>
						</div>
					</div>
					<div class="carousel-item" data-interval="7000">
						<img src="images/qna.jpg" class="d-block w-100" alt="Q&Aイメージ">
						<div class="carousel-caption text-right d-none d-md-block">
							<h2 class="text-shadow">Q&amp;A</h2>
							<p class="text-shadow">みんなの力で問題を解決！</p>
						</div>
					</div>
					<div class="carousel-item" data-interval="7000">
						<img src="images/stage.jpg" class="d-block w-100" alt="ステージイメージ">
						<div class="carousel-caption text-right d-none d-md-block">
							<h2 class="text-shadow">ステージ</h2>
							<p class="text-shadow">みんなの前で作品を公開しよう！</p>
						</div>
					</div>
				</div>
				<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">前へ</span>
				</a>
				<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">次へ</span>
				</a>
			</div>


			<article>
			
				<div class="container">
					
					<div class="row mb-4">
						<div class="col-lg-6 mb-4">
							<div id="notice" class="card col-lg-12 px-0">
								<div class="card-header d-flex justify-content-between">
									お知らせ
									<a href="page.php?board=notice&p_cat=0&page=1">
										<small>
											<i class="fas fa-caret-right fa-fw"></i>もっと見る
										</small> 
									</a>
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered table-hover">
										<th class="text-center" style="width: 45px;">項番</th>
										<th class="text-center">タイトル</th>
										<?php
										
										$ntc_query = "SELECT * FROM posts_notice ORDER BY post_id DESC LIMIT 0, 3 ";
										$select_ntc = mysqli_query($connection, $ntc_query);
											
										while($row = mysqli_fetch_assoc($select_ntc)) {
											$ntc_post_id = $row['post_id'];
											$ntc_post_title = mb_strimwidth($row['post_title'],0,50,'…');
											$ntc_post_author = $row['post_author'];							
										
											echo "<tr>";
											echo "<td class='text-center'>$ntc_post_id</td>";
											echo "<td class='text-left'><a href='view.php?board=notice&p_id=$ntc_post_id&cmt=1'>$ntc_post_title</a></td>";
											echo "</tr>";										
										}
										
										?>
									</table>
								</div>
							</div>
						</div>

						<div class="col-lg-6">
							<div id="member" class="card col-lg-12 px-0">
								<div class="card-header d-flex justify-content-between">
									メンバー募集
									<a href="page.php?board=member&p_cat=0&page=1">
										<small>
											<i class="fas fa-caret-right fa-fw"></i>もっと見る
										</small> 
									</a>
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered table-hover">
										<th class="text-center" style="width: 45px;">項番</th>
										<th class="text-center" style="width: 170px;">分類</th>
										<th class="text-center">タイトル</th>
									
										<?php
										
										$mem_query = "SELECT * FROM posts_member ORDER BY post_id DESC LIMIT 0, 3 ";
										$select_mem = mysqli_query($connection, $mem_query);
											
										while($row = mysqli_fetch_assoc($select_mem)) {
											$mem_post_id = $row['post_id'];
											$mem_post_category = $row['post_category'];
											$mem_post_title = mb_strimwidth($row['post_title'],0,32,'…');
											$mem_post_author = $row['post_author'];								
										
											$major_query = "SELECT * FROM majors WHERE major_id = $mem_post_category ";
											$select_majors = mysqli_query($connection, $major_query);
											
											while($major_row = mysqli_fetch_assoc($select_majors)) {
													$mem_post_category_name = $major_row['major_name'];
											}

											echo "<tr>";
											echo "<td class='text-center'>$mem_post_id</td>";
											switch($mem_post_category_name) {
												case 'ゲーム系';
													echo "<td class='text-center'><span class='badge badge-pill badge-success'> $mem_post_category_name</span></td>";
												break;

												case 'CG・映像系';
													echo "<td class='text-center'><span class='badge badge-pill badge-danger'> $mem_post_category_name</span></td>";
												break;

												case '音楽系';
													echo "<td class='text-center'><span class='badge badge-pill badge-secondary'> $mem_post_category_name</span></td>";
												break;

												case 'カーデザイン・ロボット系';
													echo "<td class='text-center'><span class='badge badge-pill badge-warning'> $mem_post_category_name</span></td>";
												break;

												case 'IT・WEB系';
													echo "<td class='text-center'><span class='badge badge-pill badge-info'> $mem_post_category_name</span></td>";
												break;
											}	
											echo "<td class='text-left'><a href='view.php?board=member&p_id=$mem_post_id&cmt=1'>$mem_post_title</a></td>";
											echo "</tr>";										
										}
										
										?>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6 mb-4">
							<div id="qna" class="card col-lg-12 px-0">
								<div class="card-header d-flex justify-content-between">
									Q&amp;A
									<a href="page.php?board=qna&p_cat=0&page=1">
										<small>
											<i class="fas fa-caret-right fa-fw"></i>もっと見る
										</small>
									</a>
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered table-hover">
										<th class="text-center" style="width: 45px;">項番</th>
										<th class="text-center" style="width: 170px;">分類</th>
										<th class="text-center">タイトル</th>
										<?php
										
										$qna_query = "SELECT * FROM posts_qna ORDER BY post_id DESC LIMIT 0, 3 ";
										$select_qna = mysqli_query($connection, $qna_query);
											
										while($row = mysqli_fetch_assoc($select_qna)) {
											$qna_post_id = $row['post_id'];
											$qna_post_category = $row['post_category'];
											$qna_post_title = mb_strimwidth($row['post_title'],0,32,'…');
											$qna_post_author = $row['post_author'];								
										
											$major_query = "SELECT * FROM majors WHERE major_id = $qna_post_category ";
											$select_majors = mysqli_query($connection, $major_query);
											
											while($major_row = mysqli_fetch_assoc($select_majors)) {
													$qna_post_category_name = $major_row['major_name'];
											}

											echo "<tr>";
											echo "<td class='text-center'>$qna_post_id</td>";
											switch($qna_post_category_name) {
												case 'ゲーム系';
													echo "<td class='text-center'><span class='badge badge-pill badge-success'> $qna_post_category_name</span></td>";
												break;

												case 'CG・映像系';
													echo "<td class='text-center'><span class='badge badge-pill badge-danger'> $qna_post_category_name</span></td>";
												break;

												case '音楽系';
													echo "<td class='text-center'><span class='badge badge-pill badge-secondary'> $qna_post_category_name</span></td>";
												break;

												case 'カーデザイン・ロボット系';
													echo "<td class='text-center'><span class='badge badge-pill badge-warning'> $qna_post_category_name</span></td>";
												break;

												case 'IT・WEB系';
													echo "<td class='text-center'><span class='badge badge-pill badge-info'> $qna_post_category_name</span></td>";
												break;
											}	
											echo "<td class='text-left'><a href='view.php?board=qna&p_id=$qna_post_id&cmt=1'>$qna_post_title</a></td>";
											echo "</tr>";										
										}
										
										?>
									</table>
								</div>
							</div>
						</div>

						<div class="col-lg-6">
							<div id="stage" class="card col-lg-12 px-0">
								<div class="card-header d-flex justify-content-between">
									ステージ
									<a href="page.php?board=stage&p_cat=0&page=1">
										<small>
											<i class="fas fa-caret-right fa-fw"></i>もっと見る
										</small>
									</a>
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered table-hover">
										<th class="text-center" style="width: 45px;">項番</th>
										<th class="text-center" style="width: 170px;">分類</th>
										<th class="text-center">タイトル</th>
										<?php
										
										$stg_query = "SELECT * FROM posts_stage ORDER BY post_id DESC LIMIT 0, 3 ";
										$select_stg = mysqli_query($connection, $stg_query);
											
										while($row = mysqli_fetch_assoc($select_stg)) {
											$stg_post_id = $row['post_id'];
											$stg_post_category = $row['post_category'];
											$stg_post_title = mb_strimwidth($row['post_title'],0,32,'…');
											$stg_post_teamname = $row['post_teamname'];							
										
											$major_query = "SELECT * FROM majors WHERE major_id = $stg_post_category ";
											$select_majors = mysqli_query($connection, $major_query);
											
											while($major_row = mysqli_fetch_assoc($select_majors)) {
													$stg_post_category_name = $major_row['major_name'];
											}

											echo "<tr>";
											echo "<td class='text-center'>$stg_post_id</td>";
											switch($stg_post_category_name) {
												case 'ゲーム系';
													echo "<td class='text-center'><span class='badge badge-pill badge-success'> $stg_post_category_name</span></td>";
												break;

												case 'CG・映像系';
													echo "<td class='text-center'><span class='badge badge-pill badge-danger'> $stg_post_category_name</span></td>";
												break;

												case '音楽系';
													echo "<td class='text-center'><span class='badge badge-pill badge-secondary'> $stg_post_category_name</span></td>";
												break;

												case 'カーデザイン・ロボット系';
													echo "<td class='text-center'><span class='badge badge-pill badge-warning'> $stg_post_category_name</span></td>";
												break;

												case 'IT・WEB系';
													echo "<td class='text-center'><span class='badge badge-pill badge-info'> $stg_post_category_name</span></td>";
												break;
											}	
											echo "<td class='text-left'><a href='view.php?board=stage&p_id=$stg_post_id&cmt=1'>$stg_post_title</a></td>";
											echo "</tr>";										
										}
										
										?>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>

			</article>     

		
		<?php include "includes/footer.php";?>	                              
		                                
 		                                
 	  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>   
  </body>    
</html>