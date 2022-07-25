<?php
$countTweet = Controller::countTweetsAction()[0];
$hashtags = Controller::countTagsAction();
$user = ProfileController::getUserInfo();
$followers = Controller::countFollowersAction()[0];
$followings = Controller::countFollowersAction()[0];

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
			<div class="bg-color rounded">
				<form method="POST" action="/Twitter/account/edit">
					<div>
						<div class="form-group mx-sm-3 mb-2">
							<label class="custom-label mx-sm-3 mb-2">Thème</label>
							<select class="custom-select mx-sm-3 mb-2" name="theme">
								<option value="#1da1f2">Couleur par défaut</option>
								<option value="#DB1702">Rouge</option>
								<option value="#0000FF">Bleu</option>
								<option value="#000000">Noir</option>
								<option value="#FFFF00">Jaune</option>
								<option value="#00FF00">Vert</option>
								<option value="#FFFFFF">Blanc</option>
								<option value="#EE82EE">Violet</option>
								<option value="#ED7F10">Orange</option>
							</select>
						</div>
						<div class="form-group mx-sm-3 mb-2">
							<label class="custom-label mx-sm-3 mb-2">Edit Avatar</label>
							<input class="form-control-file mx-sm-3 mb-2" id="inputFile" type="file" style= "overflow-wrap: break-word;">
							<div class="form-group mx-sm-3 mb-2">
								<label class="custom-label mr-sm-2">Last name</label>
								<input class="form-control" name="lastname" type="text" placeholder="<?=$user['lastname']?>">
							</div>
							<div class="form-group mx-sm-3 mb-2">
								<label class="custom-label mr-sm-2">First name</label>
								<input class="form-control" name="firstname" type="text" placeholder="<?=$user['firstname']?>">
							</div>
							<div class="form-group mx-sm-3 mb-2">
								<label class="custom-label mr-sm-2">Your Mail Adress</label>
								<input class="form-control" type="email" name="email" placeholder="<?=$user['email']?>">
							</div>
							<div class="form-group mx-sm-3 mb-2">
								<label class="custom-label mr-sm-2">Change Mail</label>
								<input class="form-control" type="email" name="email" placeholder="<?=$user['email']?>">
							</div>
							<div class="form-group mx-sm-3 mb-2">
								<label class="custom-label mr-sm-2">Your Password</label>
								<input type="password" name="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" placeholder="*****">
							</div>
							<div class="form-group mx-sm-3 mb-2">
								<label for="inputPassword5">New Password</label>
								<input type="password" name="newpassword" id="inputPassword6" class="form-control" aria-describedby="passwordHelpBlock" placeholder="*****">
								<small id="passwordHelpBlock" class="form-text text-muted">
									Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
								</small>
							</div>
							<input class="btn btn-primary mx-sm-3" type="submit" id="profileEdit" value="Save Profile">
							<input class="btn btn-danger mx-sm-3" type="button" id="DeleteUser" name="deleteAccount" value="Delete Profile">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
		<?php include 'inc/footer.php';?>
	</body>
	</html>