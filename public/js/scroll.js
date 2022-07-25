$(document).ready(function () {
	var offset = 15;
	var lasttweet = 1;
	$(window).scroll(function() {
		if($(window).scrollTop() +1 >= $("body").height() - $(window).height()) {
			$.get("?page=tweet&action=getTweet",
				{limit: 15,
					offset: offset})
			.done((data) => {
				var obj = JSON.parse(data);
				$.each(obj.reverse(), (key, value) => {
					lasttweet = value.id_tweet;
					$("#timeline").append(
						'<li class="tweet list-group-item" value="'+value.username+'"'
						+' idTweet="'+lasttweet+'">'
						+ '<img src="'+value.avatar+'" class="icon-tweet">'
						+ '<a href="/Twitter/profile/'
						+ value.username + '">@' + value.username + '</a><br>'
						+ value.content_tweet
						+ '</li>');
				});
				offset += 15;
			})
		}
	});
});