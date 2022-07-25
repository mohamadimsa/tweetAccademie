<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel">New message</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<form>
		<div class="form-group">
			<label for="recipient-name" class="col-form-label">Recipient:</label>
			<input type="hidden" id="toUser" value="<?=$_POST['username']?>">
			<p id="recipient-name"><b><?=$_POST['username']?></b></p>
		</div>
		<div class="form-group">
			<label for="message-text" class="col-form-label">Message:</label>
			<textarea id="msgContent" class="form-control"></textarea>
		</div>
		<p id="msgStatus"></p>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary" id="sndPrvMsg">Send message</button>
</div>

<script src="/Twitter/public/js/message.js"></script>