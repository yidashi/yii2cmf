$(function() {


	$('.list-group-item.active').prevAll().addClass("done");

	var prevUrl = $('.list-group-item.active').prev().data("url");
	var nextUrl = $('.list-group-item.active').next().data("url");
	var activeUrl = $('.list-group-item.active').data("url");

	if (prevUrl == undefined) {
		$("#prevButton").addClass("hidden");
	} else {
		$("#prevButton").click(function() {
			location.href = prevUrl;
		});
	}

	if (nextUrl == undefined) {
		$("#nextButton").text("完成");
		nextUrl="./admin"
	}
	$("#nextButton").click(function() {

		$('#target').loadingOverlay();
		if ($(".install-form").length == 0) {
			location.href = nextUrl;
			return;
		}
		$.ajax({
			type : "POST",
			url : activeUrl,
			data : $("form.install-form").serializeArray(),
			success : function(res) {
				$('#target').loadingOverlay('remove');
				if (res.status == true) {
					if (nextUrl) {
						location.href = nextUrl;
					}
				} else {
					alert(res.message.split("=_=")[0]);
				}
			}
		});
	});

});