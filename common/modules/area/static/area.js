$(document).ready(
		function() {

			$('.sortable').sortable({
				connectWith : 'connected',
				hoverClass : 'is-hovered'
			}).bind(
					'sortupdate',
					function(e, ui) {

						function request(ui, block, action) {
							var blocks = ui.find('li').map(function() {
								return $(this).data("block");
							}).get();

							var url = updateBlocksUrl;
							if (action && action != "swap") {
								url = updateBlocksUrl.replace("update-blocks","update-blocks" + "-" + action);
							}

							$.post(url, {
								id : ui.data("domain"),
								blocks : blocks,
								block : block
							}, function(msg) {
								if (action == "swap") // 交换的时候会返回两条信息
								{
									return;
								}
								$.modal.msg(msg.msg, msg.status);
							});
						}

						// 同一个area下的改变
						if (ui.startparent.data("domain") == ui.endparent.data("domain")
								&& ui.endparent.data("domain") != 0) {
							request(ui.startparent);
							return;
						}
						// 区域间交换..或者删除
						if (ui.startparent.data("domain") != 0) {
							if (ui.endparent.data('domain') != 0) // 区域间交换
							{
								request(ui.startparent, null, "swap");
								request(ui.endparent);
							} else // 删除
							{
								request(ui.startparent, ui.item.data("block"),
										"delete");
							}
						} else // 增加到area
						{
							request(ui.endparent, ui.item.data("block"),
									"create");
						}

					});

			$('.sortable').bind('sortstop', function(e, ui) {
				$(".sortable").css("border", "none")
			});

			$('.sortable').bind('sortstart', function(e, ui) {
				$(".sortable").css("border", "dashed 1px #ddd")
			});

		});