<?php

$query = "SELECT * FROM categories WHERE cat_id = {$board} ";

$select_categories_by_name = mysqli_query($connection, $query);


while($row = mysqli_fetch_assoc($select_categories_by_name)) {
	$cat_id = $row['cat_id'];
	$cat_title = $row['cat_title'];
	$cat_info = $row['cat_info'];
}
	
?>

<?php

if(isset($_GET['p_id'])) {	
	$the_post_id = $_GET['p_id'];	
}

$sel_query = "SELECT post_author FROM posts_member WHERE post_id = {$the_post_id} ";
$sel_query_res = mysqli_query($connection, $sel_query);
$res = mysqli_fetch_assoc($sel_query_res);

if($res['post_author'] != $_SESSION['user_id']) {
	header("Location: page.php?board=member&p_cat=0&page=1");
	exit;
}

$select_query = "SELECT * FROM posts_member WHERE post_id = $the_post_id ";
$select_posts_by_id = mysqli_query($connection, $select_query);


while($row = mysqli_fetch_assoc($select_posts_by_id)) {
	$post_id = $row['post_id'];
	$post_category = $row['post_category'];
	$post_title = $row['post_title'];
	$post_author = $row['post_author'];
	$post_date = $row['post_date'];
	$post_content = $row['post_content'];
  $post_image = $row['post_image'];
	$post_views_count = $row['post_views_count'];
	
	$major_query = "SELECT * FROM majors WHERE major_id = $post_category ";
	$select_majors = mysqli_query($connection, $major_query);
}


?>


<?php

if(isset($_POST['update_post'])) {
	
	$update_post_id = $row['post_id'];
	$update_post_category = escape($_POST['post_category']);
	$update_post_title = escape($_POST['post_title']);
	$update_post_content = escape($_POST['post_content']);
  $update_post_image = $_FILES['image']['name'];
  $update_post_image_temp = $_FILES['image']['tmp_name'];
	
	$error = [	
		'blank'=>''	
	];
	
	if($update_post_title == '' or $update_post_content == '') {
  	$error['blank'] = '　空欄がないように記入してください。';
	}
	
	foreach ($error as $key => $value) {
		if(empty($value)) {
			unset($error[$key]);	
		}		
	}
	
	if(empty($error)) {
		$allowed_ext = array('jpg','jpeg','png','gif');
		if($update_post_image != NULL) {
			$ext = @array_pop(explode('.', $update_post_image));
			if(!in_array($ext, $allowed_ext)) {
				header("Location: edit.php?board=member&p_id=$the_post_id&error=imgext");
				exit;
			} else {
				// 画像が回転されている時の修正
				$exifData = exif_read_data($update_post_image_temp); 
        if($exifData['Orientation'] == 6) { 
            $degree = 270; 
        } 
        else if($exifData['Orientation'] == 8) { 
            $degree = 90; 
        } 
        else if($exifData['Orientation'] == 3) { 
            $degree = 180; 
        } 
        if($degree) { 
            if($exifData[FileType] == 1) { 
                $source = imagecreatefromjpg($update_post_image_temp); 
                $source = imagerotate ($source , $degree, 0); 
                imagejpg($source, $update_post_image_temp); 
            } 
            else if($exifData[FileType] == 2) { 
                $source = imagecreatefromjpeg($update_post_image_temp); 
                $source = imagerotate ($source , $degree, 0); 
                imagejpeg($source, $update_post_image_temp); 
            } 
            else if($exifData[FileType] == 3) { 
                $source = imagecreatefrompng($update_post_image_temp); 
                $source = imagerotate ($source , $degree, 0); 
                imagepng($source, $update_post_image_temp); 
            } 

            imagedestroy($source);
				}
				
				$update_post_image = time() . $post_author . $update_post_image;
				move_uploaded_file($update_post_image_temp, "./files/images/$update_post_image");
			}
		}

		$update_query = "UPDATE posts_member SET ";
		$update_query .= "post_title = '{$update_post_title}', ";
		$update_query .= "post_category = '{$update_post_category}', ";
		$update_query .= "post_content = '{$update_post_content}' ";
		$update_query .= "WHERE post_id = $the_post_id ";


		$update_post_query = mysqli_query($connection, $update_query);

		if($update_post_image != NULL) {
			$up_img_query = "UPDATE posts_member SET ";
			$up_img_query .= "post_image = '{$update_post_image}' ";
			$up_img_query .= "WHERE post_id = $the_post_id ";

			$up_img = mysqli_query($connection, $up_img_query);
		}

		header("Location: view.php?board=member&p_id=$the_post_id&cmt=1");
	}
}

?>
			
			<article>
				<div id="jumbotron_edit" class="jumbotron text-white text-shadow">
					<div class="container">
						<h2><?php echo $cat_title;?></h2>
						<p class="lead">
  						<?php echo $cat_info;?>
						</p>
					</div>
				</div>
				
				<div id="container" class="container">
				
					<form action="" method="post" enctype="multipart/form-data">

						<div class="card mb-5">
							<div class="card-header text-center font-weight-bold">
								メンバー募集ポストの修正
							</div>
							<div class="card-body">
								<?php if(isset($_GET['error'])) { echo "<div class='alert alert-danger px-1 py-1 my-4' role='alert'>　<i class='fas fa-exclamation-triangle'></i>　アップロードしたファイルはイメージファイルではありません。もう一度確認してください。</div>"; } ?>
								<?php echo isset($error['blank']) ? "<div class='alert alert-danger px-1 py-1 my-4' role='alert'>　<i class='fas fa-times-circle'></i>" . $error['blank'] . "</div>" : ''; ?>
								
								<div class="form-group">
									<label for="post_author">作成者</label>
									<input type="text" readonly class="form-control-plaintext" name="post_author" value="<?php echo $_SESSION['user_id'];?>">
								</div>
								
								<div class="form-group">
									<label for="category">募集分野</label>
									<select class="custom-select" name="post_category" required>
										<option value="1" <?php echo $post_category == 1 ? "selected" : ""?>>ゲーム系</option>
										<option value="2" <?php echo $post_category == 2 ? "selected" : ""?>>CG・映像系</option>
										<option value="3" <?php echo $post_category == 3 ? "selected" : ""?>>音楽系</option>
										<option value="4" <?php echo $post_category == 4 ? "selected" : ""?>>カーデザイン・ロボット系</option>
										<option value="5" <?php echo $post_category == 5 ? "selected" : ""?>>IT・WEB系</option>
									</select>
								</div>
								
								<div class="form-group">
									<label for="title">タイトル</label>
									<input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>" placeholder="例)「OOOプロジェクト」ロゴ制作者募集" autocomplete="off">
								</div>

								<div class="form-group">
									<label for="post_content">内容</label>
									<textarea class="form-control" name="post_content" id="body" rows="10" placeholder="例)「OOOプロジェクト」に協力してくれる人材を募集しています！
興味ある方はコメント欄にLINEのIDなどを残してください。	
残してくれたコメントは、作成者とコメント者以外は見えませんので、安心してください！
									" autocomplete="off"><?php echo $post_content;?></textarea>
								</div>

								<div class="form-group">
									<label for="post_image">イメージ</label>
									<div class="card col-md-3 px-0">
										<div class="card-header">
											前にアップロードしたイメージ
										</div>
										<div class="card-body text-center">
											<?php
											if($post_image != NULL) {
												echo "<img class='img-fluid' style='width: 200px;' src='./files/images/{$post_image}' alt='サムネイル'>";		
											}
											?>
										</div>
									</div>
									<input type="file" name="image">
								</div> 					
								
							</div>
							<div class="card-footer text-muted text-center">
								<button type="reset" class="btn btn-outline-warning" name="reset_post">
									リセット
								</button>

								<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modifyChk">
									修正する
								</button>
							</div>
						</div>
					
							<!-- 投稿確認のモダル -->
							<div class="modal fade" id="modifyChk" tabindex="-1" role="dialog" aria-labelledby="modifyCheck" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="postCheck">ポスト修正</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											ポストを修正しますか？
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
											<button type="submit" name="update_post" class="btn btn-primary">修正する</button>
										</div>
									</div>
								</div>
							</div>
					
					</form>
					
				</div>

			</article>