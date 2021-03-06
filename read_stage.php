<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
 	  
<script type="text/javascript" src="js/bootstrap.min.js"></script>


<?php 

$cat_query = "SELECT * FROM categories WHERE cat_id = $board ";

$select_categories_by_name = mysqli_query($connection, $cat_query);


while($row = mysqli_fetch_assoc($select_categories_by_name)) {
	$cat_id = $row['cat_id'];
	$cat_title = $row['cat_title'];
	$cat_info = $row['cat_info'];
}
	
?>
		
<?php

if(isset($_GET['p_id'])) {
	$the_post_id = $_GET['p_id'];
	
	$view_query = "UPDATE posts_stage SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id ";
	$send_view_query = mysqli_query($connection, $view_query);
	
}

$read_query = "SELECT * FROM posts_stage WHERE post_id = $the_post_id ";
$select_read_query = mysqli_query($connection, $read_query);


while($row = mysqli_fetch_assoc($select_read_query)) {
	$post_id = $row['post_id'];
	$post_category = $row['post_category'];
	$post_title = $row['post_title'];
	$post_author = $row['post_author'];
	$post_teamname = $row['post_teamname'];
	$post_date = $row['post_date'];
	$post_content = $row['post_content'];
	$post_comment_count = $row['post_comment_count'];
	$post_views_count = $row['post_views_count'];
	$post_image = $row['post_image'];
	$post_file = $row['post_file'];
	
	$major_query = "SELECT * FROM majors WHERE major_id = $post_category ";
	$select_majors = mysqli_query($connection, $major_query);

	while($major_row = mysqli_fetch_assoc($select_majors)) {
		$post_category_name = $major_row['major_name'];
	}
	
}

?>

<?php

if(isset($_POST['liked'])) {

	$post_id = $_POST['post_id'];
	$user_num = $_POST['user_num'];
	
	// ポストを選ぶ
	
	$search_post = "SELECT * FROM posts_stage WHERE post_id = $post_id ";
	$post_result = mysqli_query($connection, $search_post);
	$post = mysqli_fetch_array($post_result);
	$up = $post['up'];
	
	if(mysqli_num_rows($post_result) >= 1) {
		echo $post_id;
	}
	
	// ポストにアップを更新する
	
	mysqli_query($connection, "UPDATE posts_stage SET up=$up+1 WHERE post_id = $post_id ");
	
	
	// ポストへアップを作る
	
	mysqli_query($connection, "INSERT INTO up_stage(user_num, post_id) VALUES($user_num, $post_id)");
	
	exit();
	
}


if(isset($_POST['unliked'])) {

	$post_id = $_POST['post_id'];
	$user_num = $_POST['user_num'];
	
	// アップを取る
	$search_post = "SELECT * FROM posts_stage WHERE post_id = $post_id ";
	$post_result = mysqli_query($connection, $search_post);
	$post = mysqli_fetch_array($post_result);
	$up = $post['up'];
	
	// アップDBの情報を削除する	
	mysqli_query($connection, "DELETE FROM up_stage WHERE post_id = $post_id AND user_num=$user_num ");
	
	// ポストにアップ情報を更新する	
	mysqli_query($connection, "UPDATE posts_stage SET up=$up-1 WHERE post_id = $post_id ");
	
	exit();
	
}

?>					
			<article>
				<div id="jumbotron_read" class="jumbotron text-white text-shadow">
					<div class="container">
						<h2><?php echo $cat_title;?></h2>
						<p class="lead">
  						<?php echo $cat_info;?>
						</p>
					</div>
				</div>
				
				<div id="post_tool">
					<nav class="navbar navbar-light bg-light">
						<div class="container">　　
							<div id='list_btn'>
								<input type='button' class='btn btn-outline-secondary' value='リストへ' onclick="location.href='page.php?board=stage&p_cat=0&page=1'">
							</div>	
						</div>
					</nav>
				</div>
			
				<div id="container" class="container">
					<div class="card mb-5">
						<div class="card-header">
							<div class="row">
								<div class="col-8">
									<div class="font-weight-bold">
										
										<?php 
											switch($post_category_name) {
												case 'ゲーム系';
													echo "<span class='badge badge-pill badge-success'> $post_category_name</span>";
												break;

												case 'CG・映像系';
													echo "<span class='badge badge-pill badge-danger'> $post_category_name</span>";
												break;

												case '音楽系';
													echo "<span class='badge badge-pill badge-secondary'> $post_category_name</span>";
												break;

												case 'カーデザイン・ロボット系';
													echo "<span class='badge badge-pill badge-warning'> $post_category_name</span>";
												break;

												case 'IT・WEB系';
													echo "<span class='badge badge-pill badge-info'> $post_category_name</span>";
												break;
											}	
										?>			
										
										
										<?php echo "　" . $post_title; ?>
									</div>
								</div>
								<div class="col-2">
										<?php
										if($_SESSION['user_id'] == $post_author) {
											echo "<a href='edit.php?board=stage&p_id={$post_id}' class='btn btn-outline-warning'>修正</a>";
										}
										?>
								</div>
								<div class="col-2">

										<?php
										if($_SESSION['user_id'] == $post_author) {
											echo "<a rel='$post_id' href='javascript:void(0)' class='btn btn-outline-danger delete_link' data-toggle='modal' data-target='#deleteChk'>削除</a>";
										}
										?>			
										
										<!-- ポスト削除のモーダル -->
										<div class="modal fade" id="deleteChk" tabindex="-1" role="dialog" aria-labelledby="postCheck" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="postCheck">削除確認</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														ポストを削除しますか？
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
														<a href="" class="btn btn-danger modal_delete_link" value="<?php echo $post_id;?>">削除する</a>
													</div>
												</div>
											</div>
										</div>
								</div>
							</div>
							
						</div>
						<div class="card-header bg-light">
							<div class="row">
								<div class="col-3">チーム名：<?php echo $post_teamname; ?>
								</div>
								<div class="col-3">作成者：<?php echo $post_author; ?>
								</div>
								<div class="col-3">作成日：<?php echo $post_date; ?>
								</div>
								<div class="col-3">照会数：<?php echo $post_views_count; ?>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="container text-center">
								<div class="row">
									<div class="col-8 mx-auto">
										<?php
								
									if($post_image != NULL) {
										echo "<img class='rounded img-fluid' src='./files/images/{$post_image}' alt='イメージ'>";
									}

									?>
									</div>
								</div>
								
								<div class="row">
									<p class="col-12 my-5 text-left"><?php echo nl2br($post_content); ?></p>
								</div>	
								
								<div class="row">
									<table class="mx-auto">
									<tr>
										<td>
											<a class="<?php echo userUp($the_post_id) ? 'unup btn btn-warning faa-parent animated-hover' : 'up btn btn-success faa-parent animated-hover' ?>" href="" style="width: 160px;">
											<?php echo userUp($the_post_id) ? '<i class="fas fa-angle-double-up fa-rotate-180 fa-lg fa-fw faa-flash faa-slow"></i>' : '<i class="fas fa-angle-double-up fa-lg fa-fw faa-vertical"></i>'?><?php echo userUp($the_post_id) ? ' アップ取消し' : ' アップ！' ?>
											</a>
										</td>
									</tr>
									<tr>
										<td>
											<div class="text-white bg-secondary font-weight-bold">総アップ数：<?php getPostUp($the_post_id);?></div>
										</td>
									</tr>
								</table>
								
							</div>
									
							</div>
						</div>
						
							
							<div class="card-footer bg-light py-0 px-0">
								<div class="card-header">
									<span class="font-weight-bold">ファイル</span>
								</div>
							
								<div class="card-body py-4">
									<div class="form-inline">
										<label for="download">ダウンロード</label>
										<div class="form-group">
											　<?php echo "<a href='files/files/$post_file'>{$post_file}</a>"; ?>
										</div>
									</div>									
								</div>		
							
							</div>

							<div class="card-footer bg-light py-0 px-0">
								<div class="card-header">
									<span class="font-weight-bold">コメント一覧</span>
								</div>
							
								<div class="card-body py-2">
									<div class="container bg-light rounded">
										<table class="my-2">
											<tbody>
								
									<?php
									
									$list = 20;
									$block = 3;
									
									$page = ($_GET['cmt'])? $_GET['cmt'] : 1;

									
									$cmt_query_count = "SELECT * FROM comments_stage WHERE comment_post_id = $post_id ";
									$find_count = mysqli_query($connection, $cmt_query_count);
									$num = mysqli_num_rows($find_count);
									
									$page_num = ceil($num / $list);
									$block_num = ceil($page_num / $block);
									$now_block = ceil($page / $block);
									
									$s_page = ($now_block * $block) - ($block - 1);
									
									if($s_page <= 1) {
										$s_page = 1;
									}
									
									$e_page = $now_block * $block;
									if($page_num <= $e_page) {
										$e_page = $page_num;
									}
									
									
									$s_point = ($page-1) * $list;
																					
									$show_cmt_query = "SELECT * FROM comments_stage WHERE comment_post_id = {$the_post_id} ORDER BY comment_id DESC LIMIT $s_point, $list ";
									$select_comment_query = mysqli_query($connection, $show_cmt_query);
									if(!$select_comment_query) {
										die('query f' . mysqli_error($connection));
									}
									while ($row = mysqli_fetch_array($select_comment_query)) {
										$comment_date = $row['comment_date'];
										$comment_content = $row['comment_content'];
										$comment_author = $row['comment_author'];


									?>
										<tr>
											<td class="text-black" style="width: 100px">
												<?php echo "　". $comment_author;?>
											</td>
											<td class="p-2">
												<div class="border border-light text-white rounded p-2" style="background-color: #a9a9a9;">
													<?php echo nl2br($comment_content);?>
												</div>
											</td>
											<td class="text-black"  style="width: 100px; text-align: center;">
												<?php echo $comment_date;?>
											</td>		
										</tr>
									
						<?php	} ?>
										</tbody>
									</table>
								</div>
								
								<div class="row justify-content-center">
									<div id="page_box">
										<nav>
											<ul class="pagination">

											<?php
											if($s_page != 1) {										
											?>
											
												<li class="page-item"><a class="page-link" href="view.php?board=stage&p_id=<?=$post_id?>&cmt=<?=$s_page-1?>">前へ</a></li>

											<?php
											}
											?>
											
												<?php

												for($i=$s_page; $i<=$e_page; $i++) {

													if($i == $page) {
														echo "<li class='page-item active'><a class='page-link' href='view.php?board=stage&p_id=$post_id&cmt={$i}'>{$i}</a></li>";
													} else {
														echo "<li class='page-item'><a class='page-link' href='view.php?board=stage&p_id=$post_id&cmt={$i}'>{$i}</a></li>";
													}	
												}

												?>

												<?php
												if($e_page != $page_num) {
												?>
											
												<li class="page-item"><a class="page-link" href="view.php?board=stage&p_id=<?=$post_id?>&cmt=<?=$e_page+1?>">次へ</a></li>

												<?php
												}
												?>
										
											</ul>
										</nav>
									</div>
								</div>	
							</div>	
							
							<!-- コメント空欄の時のエラーモーダル -->
								<div class="modal fade" id="cmt_chk" tabindex="-1" role="dialog" aria-labelledby="cmt_chk" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="cmt_chk">注意</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												コメントの内容を記入してください。
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">確認</button>
											</div>
										</div>
									</div>
								</div>
							
							<?php 
						
							if(isset($_POST['create_comment'])) {
								$the_post_id = $_GET['p_id'];
								
								$comment_author = escape($_POST['comment_author']);
								$comment_content = escape($_POST['comment_content']);
								
								if($comment_content == '') {									
									echo '<script type="text/javascript"> $("#cmt_chk").modal("show")</script>';
								} else {
								
									$cmt_query = "INSERT INTO comments_stage (comment_post_id, comment_author, comment_content, comment_date) ";
									$cmt_query .= "VALUES ('{$the_post_id}', '{$comment_author}', '{$comment_content}', now()) ";

									$create_comment_query = mysqli_query($connection, $cmt_query);

									if(!$create_comment_query) {
										die('query f' . mysqli_error($connection));
									}

									$cmt_num_query = "UPDATE posts_stage SET post_comment_count = post_comment_count + 1 ";
									$cmt_num_query .= "WHERE post_id = $the_post_id ";

									$update_cmt_num = mysqli_query($connection, $cmt_num_query);

									header("Location: view.php?board=stage&p_id=$the_post_id&cmt=1");
								}
							}
						
							?>
							
							
							<div class="card-footer bg-light py-0 px-0">
							<div class="card-header">
								<span class="font-weight-bold">コメントを残す</span>
							</div>
							
							<div class="card-body">
								<form action="" method="post">
									<div class="form-group">
										<label for="author">コメント者</label>
										<div class="form-group">
											<input type="text" readonly class="form-control-plaintext mx-3 font-weight-bold" name="comment_author" value="<?php echo $_SESSION['user_id']; ?>">
										</div>
									</div>

									<div class="form-group">
										<label for="comment">コメント内容</label>
										<div class="form-group">
											<textarea class="form-control" name="comment_content" id="" cols="30" rows="3"></textarea>
										</div>
									</div>

									<div class="form-group">
										<button class="btn btn-outline-primary" name="create_comment" type="submit">
										コメント
										</button>
									</div>

								</form>
							</div>
						</div>
						</div>
					</div>
				</div>
			
			</article>
			
			
			<?php include "includes/footer.php";?>
			

 
 		<script>
		
			$(document).ready(function(){
				
				$('.delete_link').on('click', function(){
					
					var id = $(this).attr("rel");
					
					var delete_url = "page.php?board=stage&p_cat=0&page=1&delete="+ id +" ";
					
					$(".modal_delete_link").attr("href", delete_url);
					
					$("#deleteChk").modal('show');

				});
				
			});
		
		</script>
		
		<script>

			$(document).ready(function(){
				
				var post_id = <?php echo $the_post_id;?>;
						
				var user_num = <?php echo loggedInUserNum();?>;
				
				// アップの時
				$('.up').click(function(){
					
					$.ajax({
						
						url: "view.php?board=stage&p_id=<?php echo $the_post_id;?>&cmt=1",
						type: 'post',
						data: {
								'liked': 1,
								'post_id': post_id,
								'user_num': user_num
						}
						
					});
					
				});
				
				
				//アップ取消し
				$('.unup').click(function(){
					
					$.ajax({
						
						url: "view.php?board=stage&p_id=<?php echo $the_post_id;?>&cmt=1",
						type: 'post',
						data: {
								'unliked': 1,
								'post_id': post_id,
								'user_num': user_num
						}
						
					});
					
				});
				
				
				
			});	
		
		</script>
 
  </body>    
</html>
