$(document).ready(function() {
	var setAjaxLoader = function() {
		$("#attachment-info").html('<div class="loading"><i class="fa fa-spinner fa-pulse fa-5x"></i></div>');
	}

	$('#attachment-list').on("click", "a", function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();

		$("#attachment-list .item").removeClass("active");
		$(this).parent().addClass("active");

		var id = $(this).parent().data("item-id");
		var url = $("#attachment-list").data("url");

		$.ajax({
			type: "GET",
			url: url,
			data: "id=" + id,
			beforeSend: function() {
				setAjaxLoader();
			},
			success: function(msg) {
				if (msg.status == false) {
					alert(msg.content);
				} else {
					$("#attachment-info").html(msg.content);
				}

			}
		});

		return false;
	});

	$('#attachment-info').on("click", '[role="delete"]', function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();

		var url = $(this).attr("href");
		var confirmMessage = $(this).data("confirm-msg");
        var id = $(this).data("item-id");
		$.ajax({
			type: "POST",
			url: url,
			beforeSend: function() {
				if (!confirm(confirmMessage)) {
					return false;
				}
				setAjaxLoader();
			},
			success: function(msg) {
				if (msg.status == true) {
					$("#attachment-info").html("");
					$('#attachment-list .item[data-item-id="' + id + '"]').fadeOut();
				}
				notify.msg(msg.status, msg.content);
			}
		});

		return false;
	});

	$('#attachment-info').on("submit", "#control-form", function(e) {
		e.preventDefault();
        e.stopImmediatePropagation();
		var url = $(this).attr("action");
		var	data = $(this).serialize();

		$.ajax({
			type: "POST",
			url: url,
			data: data,
			beforeSend: function() {
				setAjaxLoader();
			},
			success: function(msg) {
                if (msg.status == false) {
                    alert(msg.content);
                } else {
                    $("#attachment-info").html(msg.content);
                    notify.msg(msg.status, "更新成功");
                }
			}
		});

        return false;
	});
});