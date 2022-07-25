<?php
$countTweet = Controller::countTweetsAction()[0];
$hashtags = Controller::countTagsAction();
$followers = Controller::countFollowersAction()[0];
$followings = Controller::countFollowingAction()[0];

$followers_list = ProfileModel::FollowersListAction();

include 'inc/header.php';
include 'inc/navbar.php';
include 'inc/modal.php'; ?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-4 col-lg-3">
			
			<?php include 'inc/leftbar.php';
			include 'inc/tagslist.php';
			?>
		</div>
		<div class="col-sm-12 col-md-8 col-lg-7">
			<div class="bg-color rounded">
				<h4>Followers :</h4>
				<ol class="list-group">
				<?php 
				foreach($followers_list as $subs):?>
					<li class="list-group-item"><img alt="avatar" src="<?=$subs["avatar"]?>"><a href="/Twitter/profile/<?=$subs["username"]?>">@<?=$subs["username"]?></a>
					</li>
				<?php endforeach;
				?>
				</ol>
			</div>
		</div>
	</div>
</div>
	<?php include 'inc/footer.php';?>
</body>
</html>