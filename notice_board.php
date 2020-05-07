<?php 

$cat_query = "SELECT * FROM categories WHERE cat_id = {$board} ";

$select_categories_by_name = mysqli_query($connection, $cat_query);


while($row = mysqli_fetch_assoc($select_categories_by_name)) {
	$cat_id = $row['cat_id'];
	$cat_title = $row['cat_title'];
	$cat_info = $row['cat_info'];
}
	
?>

<?php 

if(isset($_GET['delete'])) {
	$posted_id = $_GET['delete'];
	$sel_query = "SELECT post_author FROM posts_notice WHERE post_id = {$posted_id} ";
	$sel_query_res = mysqli_query($connection, $sel_query);
	$res = mysqli_fetch_assoc($sel_query_res);
	
	if($res['post_author'] == $_SESSION['user_id']) {
		$del_query = "DELETE FROM posts_notice WHERE post_id = {$posted_id} ";
		$delete_query = mysqli_query($connection, $del_query);
	}
}

?>

			<article>
				<div id="jumbotron_notice" class="jumbotron text-white text-shadow">
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
						
						  <!-- 検索フォーム -->
							<div id="search_box">
								<form class="form-inline" method="get" action="search.php">
									<input type="hidden" class="form-control-plaintext" name="board" value="notice">
									<input name="search_content" class="form-control mr-sm-2" placeholder="キーワード" aria-label="検索" autocomplete="off">
									<input type="hidden" class="form-control-plaintext" name="page" value="1">
									<button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索</button>
								</form>
							</div>
					　　　
					　　　
					　　 <?php
							
								if($_SESSION['user_auth'] == 'admin') {
									echo "<div id='post_btn'><input type='button' class='btn btn-outline-secondary' value='投稿する' onclick=\"location.href='post.php?board=notice'\"></div>";
								}
							
							?>
							
						</div>
					</nav>
				</div>
				
							
													
				<div id="container" class="container">
						<table id="notice" class="table table-sm table-bordered table-hover text-center">
							<thead>
								<tr>
									<th style="width: 50px;">項番</th>
									<th>タイトル</th>
									<th style="width: 100px;">コメント数</th>
									<th style="width: 160px;">作成者</th>
									<th style="width: 140px;">作成日</th>
									<th style="width: 100px;">照会数</th>
								</tr>
							</thead>
							<tbody>

								<?php

								$p_cat = $_GET['p_cat'];

								$list = 10;
								$block = 3;

								$page = ($_GET['page'])?$_GET['page']:1;


								$post_query_count = "SELECT * FROM posts_notice";
								$find_count = mysqli_query($connection, $post_query_count);
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

								$query = "SELECT * FROM posts_notice ORDER BY post_id DESC LIMIT $s_point, $list";

								$select_posts = mysqli_query($connection, $query);

								while($row = mysqli_fetch_assoc($select_posts)) {

									$post_id = $row['post_id'];
									$post_title = mb_strimwidth($row['post_title'],0,70,'…');
									$post_author = $row['post_author'];
									$post_date = $row['post_date'];
									$post_content = $row['post_content'];
									$post_comment_count = $row['post_comment_count'];
									$post_views_count = $row['post_views_count'];


									echo "<tr>";
									echo "<td>$post_id</td>";
									echo "<td class='text-left'><a href='view.php?board=notice&p_id=$post_id&cmt=1'>$post_title</a></td>";
									echo "<td>$post_comment_count</td>";
									echo "<td>$post_author</td>";
									echo "<td>$post_date</td>";
									echo "<td>$post_views_count</td>";
									echo "</tr>";

								}	
								echo "<div class='text-muted text-right'><i class='fas fa-pen-nib'></i> 計" . $num . "件</div>";
								?>

							</tbody>
						</table>
				
							<div class="row justify-content-center">
							
								<div>
									<a class='btn btn-outline-primary mx-3' href='page.php?board=notice&p_cat=<?=$p_cat?>&page=1'>最初へ</a>
								</div>
							
								<div id="page_box">
									<nav>
										<ul class="pagination">
										
										<?php
										if($s_page != 1) {											
										?>
											<li class="page-item"><a class="page-link" href="page.php?board=notice&p_cat=<?=$p_cat?>&page=<?=$s_page-1?>">前へ</a></li>
										
										<?php
											}
										?>
										
											<?php
											
											for($i=$s_page; $i<=$e_page; $i++) {
												
												if($i == $page) {
													echo "<li class='page-item active'><a class='page-link' href='page.php?board=notice&p_cat={$p_cat}&page={$i}'>{$i}</a></li>";
												} else {
													echo "<li class='page-item'><a class='page-link' href='page.php?board=notice&p_cat={$p_cat}&page={$i}'>{$i}</a></li>";
												}	
											}
											
											?>
											
											<?php
											if($e_page != $page_num) {
											?>	
											
											<li class="page-item"><a class="page-link" href="page.php?board=notice&p_cat=<?=$p_cat?>&page=<?=$e_page+1?>">次へ</a></li>
											
											<?php
											}
											?>
											
										</ul>
									</nav>
								</div>
								
								<div>
									<a class='btn btn-outline-primary mx-3' href='page.php?board=notice&p_cat=<?=$p_cat?>&page=<?=$page_num?>'>最後へ</a>
								</div>
								
							</div>
						</div>

			</article>
