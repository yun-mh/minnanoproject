<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    
    <title>みんなのプロジェクト</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/page.css">
  	  
  	  
			<!--　ヘッダ　-->
			<?php include "includes/header.php";?>


			<article>
				<div id="jumbotron_about" class="jumbotron text-shadow">
					<div class="container">
						<h2 class="text-right">みんなのプロジェクトとは？</h2>
						<p>　</p>
					</div>
				</div>
				
				<div id="container" class="container">
					<div class="my-5">
						<h3>
							企画背景
							<small class="text-info">「HALの多様性を活用しよう」</small>
						</h3>
						<p class="mt-3">様々な学科からなるHAL。ゲーム系, CG系, 音楽, カーデザイン, ロボット, IT・WEBの学生たちが一つの所で集まって、一緒にチームを組んで作品を作り出したり、お互いに情報を交換したりすることが出来たら良いかなという考えから生まれました。</p>
					</div>
					
					<hr>
					
					<div class="my-5">
						<h3>
							目標
							<small class="text-info">「みんなの力でより大きな夢へ」</small>
						</h3>
						<p class="mt-3">
						みんなの協力でプロジェクトを作り上げることで、HAL生の成長に役に立てることを目指しています。
						</p>
					</div>
					
					<hr>
					
					<div class="my-5">
						<h3>
							機能紹介
							<small class="text-info">「みんなのプロジェクトではこんなことができます！」</small>
						</h3>
						
						<div class="accordion mt-4" id="accordion">
							<div class="card">
								<div class="card-header bg-light px-1 py-1" id="headingOne">
									<h2 class="mb-0">
										<button class="btn btn-link text-decoration-none text-info font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											メンバー募集
										</button>
									</h2>
								</div>

								<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
									<div class="card-body">
										プロジェクトに必要な人を募集できる空間です。募集するときには、必要になっている分野を決めて募集しましょう。
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header bg-light px-1 py-1" id="headingTwo">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed text-decoration-none text-info font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											プロジェクトルーム
										</button>
									</h2>
								</div>
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
									<div class="card-body">
										プロジェクトのメンバー同士で、プロジェクトに対した会議録や意見・ファイルの共有ができるプロジェクト専用の仮想会議室です。
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header bg-light px-1 py-1" id="headingThree">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed text-decoration-none text-info font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
											Q&amp;A
										</button>
									</h2>
								</div>
								<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
									<div class="card-body">
										プロジェクトの途中でぶつかる技術的な問題を、みんなの力で解決できる空間です。必要であれば、質問に関したイメージやファイルなども一緒にアップロードできます。
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header bg-light px-1 py-1" id="headingFour">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed text-decoration-none text-info font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
											ステージ
										</button>
									</h2>
								</div>
								<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
									<div class="card-body">
										みんなの前で作品を公開する舞台です。人から評価やフィードバックをもらい、より良い作品になるように頑張りましょう！
									</div>
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