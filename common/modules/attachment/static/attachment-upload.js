$(document).ready(function() {
	
        var $input =$("#uploadFileInput") ;
        var $mediaItems = $("#media-items");
        var $dragDropArea = $('#drag-drop-area');

        
        $(document).on('dragover', function ()
        {
        	$dragDropArea.addClass('drag-highlight');
        });
        
        $(document).on('dragleave drop', function ()
        {
        	$dragDropArea.removeClass('drag-highlight');
        });
        
        function createItem(file){ //新建图片项目
        
            var item = $('<div>', {"class": "media-item"});
            if (!file.type || file.type.search(/image\/.*/g) !== -1) {
                item.removeClass('not-image').addClass('image');
                item.prepend($('<img/>', {src: file.url,"class":"pinkynail"}));
            } else {
                item.removeClass('image').addClass('not-image');
            }
            
            item.append($('<a  class="edit-attachment" target="_blank" href="'+file.updateUrl+'">编辑</a>'));
            
            var title =  $('<div>', {"class": "filename new"}) 
            .html('<span class="title">'+file.filename+'</span>');
            
            item.append(title);
            
            return item;
        }
        
        
        $input.fileupload({
            url: uploadUrl,
            dropZone: $dragDropArea,
            dataType: 'json',
            singleFileUploads: false,
            multiple: true,
            maxNumberOfFiles: null,
            maxFileSize: null, // 5 MB
            acceptFileTypes:null,
            process: true,
            getNumberOfFiles: function() {
                return $mediaItems.find('.media-item').length;
            },
            start: function (e, data) {
            },
            processfail: function(e, data) {
                if (data.files.error) {
                	$.modal.error(data.files[0].error);
                }
            },
            progressall: function (e, data) {

            },
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    if (!file.error) {
                        var item = createItem(file);
                        item.appendTo($mediaItems);
                    } else {
                    	$.modal.error(file.errors)
                    }

                });
            },
            fail: function (e, data) {
            	$.modal.error(data.errorThrown);
            },
            always: function (e, data) {
              
            }
        });
});
        
        
        
        
   