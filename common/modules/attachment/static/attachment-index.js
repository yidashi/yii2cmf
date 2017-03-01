$(document).ready(function() {
	var setAjaxLoader = function() {
		$("#attachment-info").html('<div class="loading"><i class="fa fa-spinner fa-pulse fa-5x"></i></div>');
	}

	$(document).on("click", "#attachment-list a", function(e) {
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
				if (msg.status == 0) {
					alert(msg.message);
				} else {
					$("#attachment-info").html(msg.message);
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
        if (!confirm(confirmMessage)) {
            return false;
        }
		$.ajax({
			type: "POST",
			url: url,
			beforeSend: function() {
				setAjaxLoader();
			},
			success: function(res) {
				if (res.status == 1) {
					$("#attachment-info").html("");
					$('#attachment-list .item[data-item-id="' + id + '"]').fadeOut();
				}
                $.modal.msg(res.message, res.status);
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
			success: function(res) {
                if (res.status == false) {
                    $.modal.error(res.message);
                } else {
                    $("#attachment-info").html(res.message);
                    $.modal.success("更新成功");
                }
			}
		});

        return false;
	});
});