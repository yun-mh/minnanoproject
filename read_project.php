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
	$view_query = "UPDATE posts_project SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id ";
	$send_view_query = mysqli_query($connection, $view_query);	
}

$read_query = "SELECT * FROM posts_project WHERE post_id = $the_post_id ";
$select_read_query = mysqli_query($connection, $read_query);

while($row = mysqli_fetch_assoc($select_read_query)) {
	$post_id = $row['post_id'];
	$post_category = $row['post_category'];
	$post_title = $row['post_title'];
	$post_author = $row['post_author'];
	$post_date = $row['post_date'];
	$post_content = $row['post_content'];
	$post_image = $row['post_image'];
	
	$major_query = "SELECT * FROM majors WHERE major_id = $post_category ";
	$select_majors = mysqli_query($connection, $major_query);

	while($major_row = mysqli_fetch_assoc($select_majors)) {
		$post_category_name = $major_row['major_name'];
	}
}

?>
		
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
						
	if(isset($_POST['comment_content'])) {
		$the_post_id = $_GET['p_id'];
		$comment_author = escape($_POST['comment_author']);
		$comment_content = escape($_POST['comment_content']);

		if($comment_content == '') {
			echo '<script type="text/javascript"> $("#cmt_chk").modal("show")</script>';
		} else {
			$cmt_query = "INSERT INTO comments_project (comment_post_id, comment_author, comment_content, comment_date) ";
			$cmt_query .= "VALUES ('{$the_post_id}', '{$comment_author}', '{$comment_content}', now()) ";

			$create_comment_query = mysqli_query($connection, $cmt_query);

			if(!$create_comment_query) {
				die('query f' . mysqli_error($connection));
			}

			header("Location: view.php?board=project&p_id=$the_post_id&min=1&cmt=1&file=1");
		}
	}

?>
		
		<!-- コメント空欄の時のエラーモーダル -->
			<div class="modal fade" id="min_chk" tabindex="-1" role="dialog" aria-labelledby="min_chk" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="min_chk">注意</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							会議録の内容を記入してください。
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">確認</button>
						</div>
					</div>
				</div>
			</div>
		
		
<?php 
						
	if(isset($_POST['create_minute'])) {
		$the_post_id = $_GET['p_id'];

		$minute_author = escape($_POST['minute_author']);
		$minute_content = escape($_POST['minute_content']);
		$minute_date = escape($_POST['minute_date']);

		if($minute_content == '') {									
			echo '<script type="text/javascript"> $("#min_chk").modal("show")</script>';
		} else {
			$min_cre_query = "INSERT INTO minutes_project (post_author, post_content, post_date, post_id) ";
			$min_cre_query .= "VALUES ('{$minute_author}', '{$minute_content}', '{$minute_date}', '{$the_post_id}') ";

			$create_minutes_query = mysqli_query($connection, $min_cre_query);

			if(!$create_minutes_query) {
				die('query f' . mysqli_error($connection));
			}

			header("Location: view.php?board=project&p_id=$the_post_id&min=1&cmt=1&file=1");
		}
	}

?>

<!-- ファイルアップロードしてない時のモーダル -->
<div class="modal fade" id="failresult" tabindex="-1" role="dialog" aria-labelledby="delmodal" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delmodal">ファイル無し</h5>
      </div>
      <div class="modal-body">
        ファイルを選択してください。
      </div>
      <div class="modal-footer">
      	<a href="view.php?board=project&p_id=<?=$the_post_id?>&min=1&cmt=1&file=1" class="btn btn-danger">確認</a>
      </div>
    </div>
  </div>
</div>		
				
								
<?php 
						
	if(isset($_POST['create_upload'])) {
		$the_post_id = $_GET['p_id'];

		$upload_author = escape($_POST['upload_author']);
		$upload_file = $_FILES['file']['name'];
		$upload_file_temp = $_FILES['file']['tmp_name'];
		$upload_file_intro = escape($_POST['upload_intro']);
		$upload_file_date = escape(date('y-m-d'));

		if($upload_file != '') {	
			$upload_file = time() . $upload_author . $upload_file;
			move_uploaded_file($upload_file_temp, "./files/files/$upload_file");
		} else {
			echo '<script type="text/javascript"> $("#failresult").modal("show")</script>';
			exit;
		}

		$file_cre_query = "INSERT INTO files_project (file_post_id, file_uploader, file_name, file_intro, file_date) ";
		$file_cre_query .= "VALUES ('{$the_post_id}', '{$upload_author}', '{$upload_file}', '{$upload_file_intro}', '{$upload_file_date}') ";

		$create_files_query = mysqli_query($connection, $file_cre_query);

		if(!$create_files_query) {
			die('query f' . mysqli_error($connection));
		}
		
		header("Location: view.php?board=project&p_id=$the_post_id&min=1&cmt=1&file=1");

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
								<div class="col-sm text-left p-1">
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
							</div>
							<div class="col-sm text-center p-1">
								<span class="font-weight-bold"><?php echo "　" . $post_title; ?></span>
							</div>			
	
							<!-- ルーム削除確認のモーダル -->
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
											プロジェクトルームを削除しますか？
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
											<a href="" class="btn btn-danger modal_delete_link" value="<?php echo $post_id;?>">削除する</a>
										</div>
									</div>
								</div>
							</div>
										
								
							<div class="col-sm text-right">
								<?php
									if($_SESSION['user_id'] == $post_author) {
										echo "<a href='edit.php?board=project&p_id={$post_id}' class='btn btn-outline-warning'>修正</a>";
									}
								?>
								<?php
									if($_SESSION['user_id'] == $post_author) {
										echo "<a rel='$post_id' href='javascript:void(0)' class='btn btn-outline-danger delete_link' data-toggle='modal' data-target='#deleteChk'>削除</a>";
									}
								?>
								<input type='button' class='btn btn-outline-secondary' value='リストへ' onclick="location.href='page.php?board=project&p_cat=0&page=1'">
							</div>	
						</div>							
					</nav>
				</div>
			
				<div id="container" class="container">
				
					<div class="card mb-3">
						<div class="card-header font-weight-bold">
							会議録
						</div>
						<div class="card-body">
							<table>
								<?php
								$m_list = 10;
								$m_block = 3;

								$m_page = ($_GET['min'])? $_GET['min'] : 1;

								$min_query_count = "SELECT * FROM minutes_project WHERE post_id = $the_post_id ";
								$min_find_count = mysqli_query($connection, $min_query_count);
								$m_num = mysqli_num_rows($min_find_count);

								$m_page_num = ceil($m_num / $m_list);
								$m_block_num = ceil($m_page_num / $m_block);
								$m_now_block = ceil($m_page / $m_block);
								$m_s_page = ($m_now_block * $m_block) - ($m_block - 1);

								if($m_s_page <= 1) {
									$m_s_page = 1;
								}

								$m_e_page = $m_now_block * $m_block;
								if($m_page_num <= $m_e_page) {
									$m_e_page = $m_page_num;
								}									

								$m_s_point = ($m_page-1) * $m_list;


								$read_minutes_query = "SELECT * FROM minutes_project WHERE post_id = $the_post_id ORDER BY minute_id DESC LIMIT $m_s_point, $m_list ";
								$select_minutes_query = mysqli_query($connection, $read_minutes_query);

								while($subrow = mysqli_fetch_assoc($select_minutes_query)) {
									$min_post_id = $subrow['minute_id'];
									$min_post_author = $subrow['post_author'];
									$min_post_date = $subrow['post_date'];
									$min_post_content = $subrow['post_content'];
								?>
									<tr>
										<td class="text-black" style="width: 100px">
											<?php echo "　". $min_post_author;?>
										</td>
										<td class="p-2">
											<div class="border border-light bg-light rounded p-2">
												<a data-toggle="modal" href="<?php echo '#a'.$min_post_id?>">
													<?php echo $min_post_date;?>の記録
												</a>
												<!-- Modal -->
												<div class="modal fade" id="<?php echo 'a'.$min_post_id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-lg" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel"><?php echo $min_post_date;?></h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<?php echo nl2br($min_post_content);?>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">確認</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</td>	
									</tr>
								<?php
								}
								?>

							</table>

							<div class="row justify-content-center">
								<div id="page_box">
									<nav>
										<ul class="pagination">

										<?php
										if($m_s_page != 1) {										
										?>

											<li class="page-item"><a class="page-link" href="view.php?board=project&p_id=<?=$the_post_id?>&min=<?=$m_s_page-1?>&cmt=1&file=1">前へ</a></li>

										<?php
										}
										?>

											<?php

											for($m=$m_s_page; $m<=$m_e_page; $m++) {

												if($m == $m_page) {
													echo "<li class='page-item active'><a class='page-link' href='view.php?board=project&p_id=$the_post_id&min={$m}&cmt=1&file=1'>{$m}</a></li>";
												} else {
													echo "<li class='page-item'><a class='page-link' href='view.php?board=project&p_id=$the_post_id&min={$m}&cmt=1&file=1'>{$m}</a></li>";
												}	
											}

											?>

											<?php
											if($m_e_page != $m_page_num) {
											?>	

											<li class="page-item"><a class="page-link" href="view.php?board=project&p_id=<?=$the_post_id?>&min=<?=$m_e_page+1?>&cmt=1&file=1">次へ</a></li>

											<?php
											}
											?>

										</ul>
									</nav>
								</div>
							</div>

							<hr>

							<form name="minute" action="" method="post">
								<div class="form-group">
									<label for="author">作成者</label>
									<div class="form-group">
										<input type="text" readonly class="form-control-plaintext mx-3 font-weight-bold" name="minute_author" value="<?php echo $_SESSION['user_id']; ?>">
									</div>
								</div>

								<div class="form-group" id="datepicker">
									<label for="min_date">日付</label>
									<div class="form-inline">
										<div class="input-group date">
											<input type="text" name="minute_date" class="form-control" id="startdate" placeholder="yyyy-mm-dd" autocomplete="off">
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="min_content">会議録内容</label>
									<div class="form-group">
										<textarea class="form-control" name="minute_content" id="" cols="30" rows="3"></textarea>
									</div>
								</div>

								<div class="form-group">
									<button class="btn btn-outline-primary" name="create_minute" type="submit">
									記録する
									</button>
								</div>
							</form>
						</div>
					</div>
					
					
					
					<div class="card mb-3">
						<div class="card-header font-weight-bold">
							意見共有
						</div>
						<div class="card-body">
							<table>
								<?php
								$list = 20;
								$block = 3;

								$page = ($_GET['cmt'])? $_GET['cmt'] : 1;

								$cmt_query_count = "SELECT * FROM comments_project WHERE comment_post_id = $the_post_id ";
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

								$read_comments_query = "SELECT * FROM comments_project WHERE comment_post_id = $the_post_id ORDER BY comment_id DESC LIMIT $s_point, $list ";
								$select_comments_query = mysqli_query($connection, $read_comments_query);

								while($subrow = mysqli_fetch_assoc($select_comments_query)) {
									$cmt_post_author = $subrow['comment_author'];
									$cmt_post_date = $subrow['comment_date'];
									$cmt_post_content = $subrow['comment_content'];
								?>
								<tr>
									<td class="text-black" style="width: 100px">
										<?php echo "　". $cmt_post_author;?>
									</td>
									<td class="p-2">
										<div class="border border-light text-white rounded p-2" style="background-color: #a9a9a9;">
											<?php echo nl2br($cmt_post_content);?>
										</div>
									</td>
									<td class="text-black"  style="width: 100px; text-align: center;">
										<?php echo $cmt_post_date;?>
									</td>		
								</tr>
							<?php
							}
							?>		

							</table>

							<div class="row justify-content-center">
								<div id="page_box">
									<nav>
										<ul class="pagination">

											<?php
											if($s_page != 1) {										
											?>

											<li class="page-item"><a class="page-link" href="view.php?board=project&p_id=<?=$the_post_id?>&min=1&cmt=<?=$s_page-1?>&file=1">前へ</a></li>

											<?php
											}
											?>											

											<?php

											for($i=$s_page; $i<=$e_page; $i++) {

												if($i == $page) {
													echo "<li class='page-item active'><a class='page-link' href='view.php?board=project&p_id=$the_post_id&min=1&cmt={$i}&file=1'>{$i}</a></li>";
												} else {
													echo "<li class='page-item'><a class='page-link' href='view.php?board=project&p_id=$the_post_id&min=1&cmt={$i}&file=1'>{$i}</a></li>";
												}	
											}

											?>

											<?php
											if($e_page != $page_num) {
											?>

											<li class="page-item"><a class="page-link" href="view.php?board=project&p_id=<?=$the_post_id?>&min=1&cmt=<?=$e_page+1?>&file=1">次へ</a></li>

											<?php
											}
											?>

										</ul>
									</nav>
								</div>
							</div>

							<hr>

							<form name="cmt" action="" method="post">
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
					
					
		
					<div class="card mb-3">
						<div class="card-header font-weight-bold">
							資料まとめ
						</div>
						<div class="card-body">
							<table>
								<?php

								$f_list = 5;
								$f_block = 3;

								$f_page = ($_GET['file'])? $_GET['file'] : 1;

								$file_query_count = "SELECT * FROM files_project WHERE file_post_id = $the_post_id ";
								$file_find_count = mysqli_query($connection, $file_query_count);
								$f_num = mysqli_num_rows($file_find_count);

								$f_page_num = ceil($f_num / $f_list);
								$f_block_num = ceil($f_page_num / $f_block);
								$f_now_block = ceil($f_page / $f_block);
								$f_s_page = ($f_now_block * $f_block) - ($f_block - 1);

								if($f_s_page <= 1) {
									$f_s_page = 1;
								}

								$f_e_page = $f_now_block * $f_block;
								if($f_page_num <= $f_e_page) {
									$f_e_page = $f_page_num;
								}									

								$f_s_point = ($f_page-1) * $f_list;


								$read_files_query = "SELECT * FROM files_project WHERE file_post_id = $the_post_id ORDER BY file_id DESC LIMIT $f_s_point, $f_list ";
								$select_files_query = mysqli_query($connection, $read_files_query);

								while($subrow = mysqli_fetch_assoc($select_files_query)) {
									$file_id = $subrow['file_id'];
									$file_uploader = $subrow['file_uploader'];
									$file_date = $subrow['file_date'];
									$file_name = $subrow['file_name'];
									$file_intro = $subrow['file_intro'];
								?>
									<tr>
										<td class="text-black" style="width: 100px">
											<?php echo "　". $file_uploader;?>
										</td>
										<td class="p-2">
											<div class="border border-light bg-light rounded p-2">
												<a data-toggle="modal" href="<?php echo '#f'.$file_id?>">
													<?php echo $file_name;?>
												</a>
												<?php echo "　  " . $file_date;?>

												<!-- Modal -->
												<div class="modal fade" id="<?php echo 'f'.$file_id?>" tabindex="-1" role="dialog" aria-labelledby="filemodal" aria-hidden="true">
													<div class="modal-dialog modal-lg" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="filemodal"><?php echo $file_uploader. "  " .$file_date;?></h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<?php echo nl2br($file_intro);?>
																<div class="form-inline">
																	<label for="download">ダウンロード　</label>
																	<div class="form-group">
																		 <?php echo "<a href='files/files/$file_name'>{$file_name}</a>"; ?>
																	</div>
																</div>	
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">確認</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</td>	
									</tr>
								<?php
								}
								?>

							</table>

							<div class="row justify-content-center">
								<div id="page_box">
									<nav>
										<ul class="pagination">

											<?php
											if($f_s_page != 1) {										
											?>

											<li class="page-item"><a class="page-link" href="view.php?board=project&p_id=<?=$the_post_id?>&min=1&cmt=1&file=<?=$f_s_page-1?>">前へ</a></li>

											<?php
											}
											?>

											<?php

											for($j=$f_s_page; $j<=$f_e_page; $j++) {

												if($j == $f_page) {
													echo "<li class='page-item active'><a class='page-link' href='view.php?board=project&p_id=$the_post_id&min=1&cmt=1&file={$j}'>{$j}</a></li>";
												} else {
													echo "<li class='page-item'><a class='page-link' href='view.php?board=project&p_id=$the_post_id&min=1&cmt=1&file={$j}'>{$j}</a></li>";
												}	
											}

											?>

											<?php
											if($f_e_page != $f_page_num) {
											?>	

											<li class="page-item"><a class="page-link" href="view.php?board=project&p_id=<?=$the_post_id?>&min=1&cmt=1&file=<?=$f_e_page+1?>">次へ</a></li>

											<?php
											}
											?>

										</ul>
									</nav>
								</div>
							</div>


							<hr>

							<form name="upfile" action="" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="author">作成者</label>
									<div class="form-group">
										<input type="text" readonly class="form-control-plaintext mx-3 font-weight-bold" name="upload_author" value="<?php echo $_SESSION['user_id']; ?>">
									</div>
								</div>

								<div class="form-group">
									<label for="file">ファイル：</label>
									<input type="file" name="file">
								</div>

								<div class="form-group">
									<label for="comment">ファイル説明</label>
									<div class="form-group">
										<textarea class="form-control" name="upload_intro" id="" cols="30" rows="3"></textarea>
									</div>
								</div>

								<div class="form-group">
									<button class="btn btn-outline-primary" name="create_upload" type="submit">
										アップロード
									</button>
								</div>
							</form>
						</div>
					</div>
				
				</div>
			
			</article>
			
			
			<?php include "includes/footer.php";?>
			
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    
    <script type="text/javascript" src="js/bootstrap-datepicker.ja.min.js"></script>
 
 		<script>
		
			$(document).ready(function(){
				
				$('.delete_link').on('click', function(){
					
					var id = $(this).attr("rel");
					
					var delete_url = "page.php?board=project&p_cat=0&page=1&delete="+ id +" ";
					
					$(".modal_delete_link").attr("href", delete_url);
					
					$("#deleteChk").modal('show');

				});
				
			});
		
		</script>
		
		<script>
			
			$('#startdate').datepicker({
        language: 'ja',
				autoclose: true,
				format: 'yyyy-mm-dd'
      }).datepicker("setDate",'now');
			
		</script>
 		
  </body>    
</html>
