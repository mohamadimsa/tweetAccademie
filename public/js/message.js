$(document).ready(function () {
	$("#v-pills-tab").on('click', 'a' , function(obj){;
		$("#v-pills-" + obj.target.innerText).html("");
		$("#recipientName").html("<b>"+obj.target.innerText+"</b>");
		$("#MsgUser").val(obj.target.innerText);
		$.post("?page=message&action=getMessage",
			{username: obj.target.innerText})
		.done((data) => {
			var res = JSON.parse(data);
			$.each(res[0], (k, v) => {
				$("#v-pills-" + obj.target.innerText).append("<b>"+v.sender
					+ " : </b>"+ v.content_message + "<br>");
			});
		});
	});

	$("#sndPrvMsg").click(function() {
		$.post("?page=message&action=send",
		{username: $("#toUser").val(),
		 content: $("#msgContent").val()})
		.done((data) => {
			var obj = JSON.parse(data);
			$.each(obj, (k, v) => {
				if (k == "error") {
					$("#msgStatus").html('<span style="color: red;">'+v+'</span>');
				}
				if (k == "ok") {
					$("#msgStatus").html('<span style="color: green;">'+v+'</span>');
					$("#msgContent").val("");
				}
			});
		});
	});

	$("#sndMsg").click(function() {
		$.post("?page=message&action=send",
		{username: $("#MsgUser").val(),
		 content: $("#msgText").val()})
		.done((data) => {
			var obj = JSON.parse(data);
			$.each(obj, (k, v) => {
				if (k == "error") {
					$("#msgInfo").html('<span style="color: red;">'+v+'</span>');
				}
				if (k == "ok") {
					$("#msgInfo").html('<span style="color: green;">'+v+'</span>');
					$("#msgText").val("");
					$("#v-pills-"+$("#MsgUser").val()+"-tab").click();
				}
			});
		});
	});
});