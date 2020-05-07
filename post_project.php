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

if(isset($_POST['create_post'])) {
	
	$post_category = escape($_POST['post_category']);
	$post_title = escape($_POST['post_title']);
	$post_author = escape($_POST['post_author']);
	$post_date = escape(date('y-m-d'));
	$post_content = escape($_POST['post_content']);
	$post_password = escape($_POST['post_password']);
	$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];
	
	$error = [
		
		'blank'=>'',
		'format'=>'',
		'content_blank'=>''
		
	];
	
	if($post_password == ''){

  	$error['blank'] = 'パスワードを設定してください。';

	}
	
	if($post_title == '' or $post_content == '') {
  	$error['content_blank'] = '　空欄がないように記入してください。';
	}
	
	if(strlen($post_password) != 4 || !preg_match("/^[0-9]/i", $post_password)){

  	$error['format'] = 'パスワードは数字4桁のみ設定できます。';

	}
	
	foreach ($error as $key => $value) {
	
		if(empty($value)) {

			unset($error[$key]);
		
		}
		
	}
	
	if(empty($error)) {
		
		$allowed_ext = array('jpg','jpeg','png','gif');
		if($post_image != NULL) {
			$ext = @array_pop(explode('.', $post_image));
			if(!in_array($ext, $allowed_ext)) {
				header("Location: post.php?board=project&error=imgext");
				exit;
			} else {
				// 画像が回転されている時の修正
				$exifData = exif_read_data($post_image_temp); 
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
                $source = imagecreatefromjpg($post_image_temp); 
                $source = imagerotate ($source , $degree, 0); 
                imagejpg($source, $post_image_temp); 
            } 
            else if($exifData[FileType] == 2) { 
                $source = imagecreatefromjpeg($post_image_temp); 
                $source = imagerotate ($source , $degree, 0); 
                imagejpeg($source, $post_image_temp); 
            } 
            else if($exifData[FileType] == 3) { 
                $source = imagecreatefrompng($post_image_temp); 
                $source = imagerotate ($source , $degree, 0); 
                imagepng($source, $post_image_temp); 
            } 

            imagedestroy($source);
				}
				
				$post_image = time() . $post_author . $post_image;
				move_uploaded_file($post_image_temp, "./files/images/$post_image");
			}
		}

		$post_query = "INSERT INTO posts_project(post_category, post_title, post_author, post_password, post_date, post_content, post_image) ";
		$post_query .= "VALUES('{$post_category}', '{$post_title}', '{$post_author}', '{$post_password}', '{$post_date}', '{$post_content}', '{$post_image}') ";

		$create_post_query = mysqli_query($connection, $post_query);

		confirmQuery($create_post_query);

		header("Location: page.php?board=project&p_cat=0&page=1");
		
	}

}

?>

			<article>
				<div id="jumbotron_post" class="jumbotron text-white text-shadow">
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
								プロジェクトルーム作成
							</div>
							<div class="card-body">
								<?php if(isset($_GET['error'])) { echo "<div class='alert alert-danger px-1 py-1 my-4' role='alert'>　<i class='fas fa-exclamation-triangle'></i>　アップロードしようとするファイルはイメージファイルではありません。もう一度確認してください。</div>"; } ?>
								<?php echo isset($error['blank']) ? "<div class='alert alert-danger px-1 py-1 my-4' role='alert'>　<i class='fas fa-exclamation-triangle'></i>　" . $error['blank'] . "</div>" : ''; ?>
								<?php echo isset($error['format']) ? "<div class='alert alert-danger px-1 py-1 my-4' role='alert'>　<i class='fas fa-exclamation-triangle'></i>　" . $error['format'] . "</div>" : ''; ?>
								<?php echo isset($error['content_blank']) ? "<div class='alert alert-danger px-1 py-1 my-4' role='alert'>　<i class='fas fa-times-circle'></i>" . $error['content_blank'] . "</div>" : ''; ?>
								
								<div class="form-group">
									<label for="post_author">作成者</label>
									<input type="text" readonly class="form-control-plaintext" name="post_author" value="<?php echo $_SESSION['user_id'];?>">
								</div>

								<div class="form-group">
									<label for="category">プロジェクト分野</label>
									<select class="custom-select" name="post_category" required>
										<option value="1" <?php echo $_SESSION['user_major'] == 1 ? "selected" : ""?>>ゲーム系</option>
										<option value="2" <?php echo $_SESSION['user_major'] == 2 ? "selected" : ""?>>CG・映像系</option>
										<option value="3" <?php echo $_SESSION['user_major'] == 3 ? "selected" : ""?>>音楽系</option>
										<option value="4" <?php echo $_SESSION['user_major'] == 4 ? "selected" : ""?>>カーデザイン・ロボット系</option>
										<option value="5" <?php echo $_SESSION['user_major'] == 5 ? "selected" : ""?>>IT・WEB系</option>
									</select>
								</div>

								<div class="form-group">
									<label for="title">プロジェクト名</label>
									<input type="text" class="form-control" name="post_title" placeholder="例)「OOOプロジェクト」" autocomplete="off">
								</div>

								<div class="form-group">
									<label for="password">ルームパスワード</label>
									<input type="password" id="roompw" class="form-control" name="post_password" placeholder="数字4桁">
								</div>

								<div class="form-group">
									<label for="post_content">プロジェクト紹介</label>
									<textarea class="form-control" name="post_content" id="body" rows="10" placeholder="例) 世界を救うためのプロジェクトです。
									" autocomplete="off"></textarea>
								</div>

								<div class="form-group">
									<label for="post_image">イメージ</label>
									<input type="file" name="image">
								</div>

							</div>
							<div class="card-footer text-muted text-center">
								<button type="reset" class="btn btn-outline-warning" name="reset_post">
									リセット
								</button>

								<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#postChk">
									作成する
								</button>
							</div>
						</div>

							<!-- 投稿確認のモダル -->
							<div class="modal fade" id="postChk" tabindex="-1" role="dialog" aria-labelledby="postCheck" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="postCheck">プロジェクトルーム作成</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											プロジェクトルームを作成しますか？
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
											<button type="submit" name="create_post" class="btn btn-primary">作成する</button>
										</div>
									</div>
								</div>
							</div>

					</form>
					
				</div>

			</article>
			
		<script src="js/bootstrap-validate.js"></script>
    
    <script>
			bootstrapValidate('#roompw','required:パスワードを入力してください。');
			bootstrapValidate('#roompw','numeric:パスワードは数字でのみ設定できます。');
			bootstrapValidate('#roompw','max:4:パスワードは数字4桁のみ設定できます。');
			bootstrapValidate('#roompw','min:4:パスワードは数字4桁のみ設定できます。');
		</script>