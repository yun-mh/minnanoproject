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

if($_SESSION['user_auth'] != 'admin') {
	header("Location: page.php?board=notice&p_cat=0&page=1");
}

?>


<?php

if(isset($_POST['create_post'])) {
	
	$post_title = escape($_POST['post_title']);
	$post_author = escape($_POST['post_author']);
	$post_date = escape(date('y-m-d'));
	$post_content = escape($_POST['post_content']);
	$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];
	
	$error = [	
		'blank'=>''	
	];
	
	if($post_title == '' or $post_content == '') {
  	$error['blank'] = '　空欄がないように記入してください。';
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
				header("Location: post.php?board=notice&error=imgext");
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

		$post_query = "INSERT INTO posts_notice(post_title, post_author, post_date, post_content, post_image) ";
		$post_query .= "VALUES('{$post_title}', '{$post_author}', '{$post_date}', '{$post_content}', '{$post_image}') ";

		$create_post_query = mysqli_query($connection, $post_query);

		confirmQuery($create_post_query);

		header("Location: page.php?board=notice&p_cat=0&page=1");
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

					<div class="card mb-5">
						<div class="card-header text-center font-weight-bold">
							お知らせ投稿
						</div>
						<form action="" method="post" enctype="multipart/form-data">
						
							<div class="card-body">
							
								<?php if(isset($_GET['error'])) { echo "<div class='alert alert-danger px-1 py-1 my-4' role='alert'>　<i class='fas fa-exclamation-triangle'></i>　アップロードしようとするファイルはイメージファイルではありません。もう一度確認してください。</div>"; } ?>
								<?php echo isset($error['blank']) ? "<div class='alert alert-danger px-1 py-1 my-4' role='alert'>　<i class='fas fa-times-circle'></i>" . $error['blank'] . "</div>" : ''; ?>
							
								<div class="form-group">
									<label for="post_author">作成者</label>
									<input type="text" readonly class="form-control-plaintext" name="post_author" value="<?php echo $_SESSION['user_id'];?>">
								</div>

								<div class="form-group">
									<label for="title">タイトル</label>
									<input type="text" class="form-control" name="post_title">
								</div>

								<div class="form-group">
									<label for="post_content">内容</label>
									<textarea class="form-control" name="post_content" id="body" rows="10"></textarea>
								</div>

								<div class="form-group">
									<label for="post_image">イメージ</label>
									<input type="file" name="image">
								</div>

									<!-- 投稿確認のモダル -->
									<div class="modal fade" id="postChk" tabindex="-1" role="dialog" aria-labelledby="postCheck" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="postCheck">お知らせ投稿</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													投稿しますか？
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
													<button type="submit" name="create_post" class="btn btn-primary">投稿する</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							<div class="card-footer text-muted text-center">
								<button type="reset" class="btn btn-outline-warning mx-3" name="reset_post">
									リセット
								</button>

								<button type="button" class="btn btn-outline-primary mx-3" data-toggle="modal" data-target="#postChk">
									投稿する
								</button>
							</div>
					</form>
					</div>	
					
				</div>

			</article>