$(document).ready(function() {
	$(".select-all").on("click",function() {
		var box = $(this).parents(".box").first();
		
		//@hass-todo 这个有问题。。在文档加载完成后，需要用js坚持模块内是否所有都select然后。设置selectall
		var selectall = box.data("selectall");
	
		if(selectall == true)
		{
			box.find("input:checkbox").prop("checked",false);  
			box.data("selectall",false);
		}
		else
		{
			box.find("input:checkbox").prop("checked",true);  
			box.data("selectall",true);
		}
	});
	
	
 
});