<div class="bg-color rounded col-sm-12 mb-3 pb-1">
	<div class="row">
		<div class="col-md-2 d-none d-md-block align-self-center">
			<img src="<?=$_SESSION["avatar"]?>" alt="icon" class="icon w-100">
		</div>
		<div class="form-group col-md-8 col-sm-10 col-12">
			<label for="myTweet">Tweet</label>
			<textarea class="form-control" id="myTweet" rows="3"></textarea>
			<div id="autocomp"></div>
		</div>
		<div class="col-md-2 col-sm-2 text-center align-self-center">
			<button class="btn btn-primary align-middle" id="submitTweet">Tweet !</button>
		</div>
	</div>
	<div class="row">
		<div class="offset-md-2 col-md-8 col-12">
			<form id="imgForm">
				<img src="/Twitter/public/img/glyphicons/glyphicons-12-camera.png" id="upImg" alt="upload">
				<input hidden type="file" class="custom-file-input" name="SelectedFile" id="customFile">
				<span class="float-right" id="charLeft">140 caracteres restants.</span>
			</form>
		</div>
	</div>
</div>