<?php
	
$cat_query = "SELECT * FROM categories WHERE cat_id = $board ";

$select_categories_by_name = mysqli_query($connection, $cat_query);


while($row = mysqli_fetch_assoc($select_categories_by_name)) {
	$cat_id = $row['cat_id'];
	$cat_title = $row['cat_title'];
	$cat_info = $row['cat_info'];
}

?>
			

			<article>
				<div id="jumbotron_search" class="jumbotron">
					<div class="container text-white text-shadow">
						<h2><?php echo $cat_title;?></h2>
						<p class="lead">
  						<?php echo $cat_info;?>
						</p>
					</div>
				</div>
				
				<div id="post_tool">
					<nav class="navbar navbar-light bg-light">
						<div class="container">
						
						  <!-- 検索フォーム -->
							<div id="search_box">
								<form class="form-inline" method="get" action="search.php">
									<input type="hidden" class="form-control-plaintext" name="board" value="stage">
									<input name="search_content" class="form-control mr-sm-2" placeholder="キーワード" aria-label="検索">
									<input type="hidden" class="form-control-plaintext" name="page" value="1">
									<button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索</button>
								</form>
							</div>
							
							<div id='list_btn'>
								<input type='button' class='btn btn-outline-secondary' value='全体リストへ' onclick="location.href='page.php?board=stage&p_cat=0&page=1'">
							</div>	
							
						</div>
					</nav>
				</div>
				

			
				<div id="container_search" class="container">
						
						<?php 
				
								
								if(isset($_GET['search_content'])) {
									
									$search = $_GET['search_content'];
									
									$list = 5;
									$block = 3;
									$page = ($_GET['page'])?$_GET['page']:1;

									$src_query = "SELECT * FROM posts_stage WHERE post_title LIKE '%$search%' OR post_content LIKE '%$search%' OR post_author LIKE '%$search%' ";
									$select_src_query = mysqli_query($connection, $src_query);

									$num = mysqli_num_rows($select_src_query);
									
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
									
									
									$query = "SELECT * FROM posts_stage WHERE post_title LIKE '%$search%' OR post_content LIKE '%$search%' OR post_author LIKE '$search' ORDER BY post_id DESC LIMIT $s_point, $list";
									$select_posts = mysqli_query($connection, $query);
									
									if($num == 0) {
										
										echo "<div class='alert alert-danger text-center mb-4' role='alert'><i class='fas fa-times-circle'></i> 検索結果がありません。</div>";
										echo "</tbody></table>";
										
									} else {
										
										echo "<div class='alert alert-info text-center mb-4' role='alert'><i class='fas fa-check-circle'></i> 検索結果：{$num}件</div>";
										
										while($row = mysqli_fetch_assoc($select_posts)) {
											$post_id = $row['post_id'];
											$post_category = $row['post_category'];
											$post_title = mb_strimwidth($row['post_title'],0,40,'…');
											$post_author = $row['post_author'];
											$post_teamname = $row['post_teamname'];
											$post_date = $row['post_date'];
											$post_content = mb_strimwidth($row['post_content'],0,124,'…');
											$post_image = $row['post_image'];
											$post_comment_count = $row['post_comment_count'];
											$post_views_count = $row['post_views_count'];


											$major_query = "SELECT * FROM majors WHERE major_id = $post_category ";
											$select_majors = mysqli_query($connection, $major_query);

											while($major_row = mysqli_fetch_assoc($select_majors)) {
												$post_category_name = $major_row['major_name'];
											}
											
											?>
											
											<div class="card mb-3">
												<div class="row no-gutters">
													<div class="col-md-4">
														<?php
															if($post_image != "") {
																echo "<img src='files/images/$post_image' class='img-thumbnail' style='width: 200px; height: 200px;' alt='サムネイル'>";
															} else {
																echo "<img src='images/noimage.png' class='img-thumbnail' style='width: 200px; height: 200px;' alt='サムネイル'>";
															}
														?>

													</div>

													<div class="col-md-8">
														<div class="card-body">
															<div class="form-inline mb-2">
																<div class="form-group">
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
																<div class="form-group card-title font-weight-bold ml-2">
																	<a href="view.php?board=stage&p_id=<?=$post_id?>&cmt=1"><?php echo $post_title;?></a>
																</div>
															</div>

															<p class="card-text"><?php echo $post_content;?></p>
															
															<div class="form-inline">
																<div class="form-group mr-3">
																	<p class="card-text font-weight-bold"><small class="text-muted">made by</small><?php echo ' '.$post_teamname;?></p>
																</div>
															</div>

															<div class="form-inline">
																<div class="form-group mr-3">
																	<p class="card-text"><small class="text-muted">公開日：<?php echo $post_date;?></small></p>
																</div>
																<div class="form-group mr-3">
																	<p class="card-text"><small class="text-muted">照会数：<?php echo $post_views_count;?></small></p>
																</div>
																<div class="form-group">
																	<p class="card-text"><small class="text-muted">アップ数：<?php getPostUp($post_id);?></small></p>
																</div>
															</div>

														</div>
													</div>
												</div>
											</div>
											

								<?php		
				
										}
										
									}
								}	
							
					
						?>
				
							<div class="row justify-content-center">
							
								<div>
									<a class='btn btn-outline-primary mx-3' href='search.php?board=stage&search_content=<?=$search?>&page=1'>最初へ</a>
								</div>
							
								<div id="page_box">
									<nav>
										<ul class="pagination">
										
											<?php
											if($s_page != 1) {										
											?>
										
											<li class="page-item"><a class="page-link" href="search.php?board=stage&search_content=<?=$search?>&page=<?=$s_page-1?>">前へ</a></li>
										
											<?php
											}
											?>
										
											<?php
											
											for($i=$s_page; $i<=$e_page; $i++) {
												
												if($i == $page) {
													echo "<li class='page-item active'><a class='page-link' href='search.php?board=stage&search_content={$search}&page={$i}'>{$i}</a></li>";
												} else {
													echo "<li class='page-item'><a class='page-link' href='search.php?board=stage&search_content={$search}&page={$i}'>{$i}</a></li>";
												}	
											}
											
											?>
											
											<?php
											if($e_page != $page_num) {
											?>
											
											<li class="page-item"><a class="page-link" href="search.php?board=stage&search_content=<?=$search?>&page=<?=$e_page+1?>">次へ</a></li>

											<?php
											}
											?>
											
										</ul>
									</nav>
								</div>
								
								<div>
									<a class='btn btn-outline-primary mx-3' href='search.php?board=stage&search_content=<?=$search?>&page=<?=$page_num?>'>最後へ</a>
								</div>
								
							</div>						
						</div>
	
			</article>
			
			