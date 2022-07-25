$(document).ready(function () {
	$("#submitComment").click(() => {
		$.post("?page=tweet&action=postComment",
		{
			idTweet: $("#twtId").val(),
			content: $("#cmtContent").val()
		})
		.done((data) => {
			var obj = JSON.parse(data);
			$.each(obj, (k, v) => {
				if (k == "ok") {
					$("#commentList").append(
						'<li class="list-group-item bg-color text-secondary">'
						+ '<a href="/Twitter/profile/'
						+ v + '">@' + v + '</a><br>'
						+ $("#cmtContent").val()
						+ '</li><hr>');
					$("#cmtContent").val("");
				}
			});
		});
	});

	$("#commentList").on("click", "a", function(e) {
		e.preventDefault();
		var parent = $(this)[0].offsetParent;
		var comId = e.currentTarget.attributes['value'].value;
		$.post("?page=tweet&action=delComment",
		{
			idComment: comId
		})
		.done((data) => {
			var obj = JSON.parse(data);
			$.each(obj, function(k, v) {
				if (k == "ok") {
					parent.remove();
				}
			});
		});
	});
});