<?php
$countTweet = Controller::countTweetsAction()[0];
$hashtags = Controller::countTagsAction();
$followers = Controller::countFollowersAction()[0];
$followings = Controller::countFollowingAction()[0];


include 'inc/header.php';
include 'inc/navbar.php';
include 'inc/modal.php'; ?>

<div class="container"> <!-- class "main" -->
	<div class="row">
		<div class="col-sm-12 col-md-4 col-lg-3">
			
			<?php include 'inc/leftbar.php';
			include 'inc/tagslist.php';
			?>

		</div>
		<div class="col-sm-12 col-md-8 col-lg-7">
			<?php 
			include 'inc/postTweet.php';
			?>
			<div class="dropdown">
				<ol id="timeline" class="list-group">
				</ol>
			</div>
		</div>
	</div>
</div>
	<?php include 'inc/footer.php';?>
	<script src="/Twitter/public/js/scroll.js"></script>
</body>
</html>