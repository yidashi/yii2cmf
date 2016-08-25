(function( $ ) {
    jQuery.fn.attachmentFileUpload = function(options) {
        var options = $.extend({
            'url': "",
            'sortable': false,
            "multiple": false,
            "maxNumberOfFiles": 0,
            "maxFileSize": null, // 5 MB
            "acceptFileTypes": null,
            "files": []
        }, options);

        var $input = this;
        $('<input type="button" value="选择文件" class="btn bg-navy btn-flat margin" />').insertBefore($input);
        var $container = $input.parent('div');
        var $mediaItems = $('<div id="media-items"></div>').insertAfter($input);;
        var $dragDropArea = $('#drag-drop-area');

        var methods = {
            init: function(){
                methods.dragInit();
                methods.fileuploadInit();
            },
            dragInit: function(){
                $(document).on('dragover', function () {
                    $dragDropArea.addClass('drag-highlight');
                });

                $(document).on('dragleave drop', function () {
                    $dragDropArea.removeClass('drag-highlight');
                });
            },
            fileuploadInit: function(){
                var $fileupload = $input.fileupload({
                    url: options.url,
                    dropZone: $dragDropArea,
                    dataType: 'json',
                    singleFileUploads: false,
                    multiple: options.multiple,
                    maxNumberOfFiles: null,
                    maxFileSize: options.maxFileSize, // 5 MB
                    acceptFileTypes: null,
                    process: true,
                    getNumberOfFiles: function () {
                        return $mediaItems.find('.media-item').length;
                    },
                    start: function (e, data) {
                    },
                    processfail: function (e, data) {
                        if (data.files.error) {
                            alert(data.files[0].error);
                        }
                    },
                    progressall: function (e, data) {

                    },
                    done: function (e, data) {
                        $.each(data.result.files, function (index, file) {
                            if (!file.error) {
                                var item = createItem(file);
                                $mediaItems.html(item);
                            } else {
                                alert(file.errors)
                            }

                        });
                    },
                    fail: function (e, data) {
                        alert(data.errorThrown);
                    },
                    always: function (e, data) {

                    }
                });
                if (options.files) {
                    options.files.sort(function(a, b){
                        return parseInt(a.order) - parseInt(b.order);
                    });
                    $fileupload.fileupload('option', 'done').call($fileupload, $.Event('done'), {result: {files: options.files}});
                    //methods.checkInputVisibility();
                }
            }
        }

        function createItem(file) { //新建图片项目
            var item = $('<div>', {"class": "media-item"});
            item.append($('<input/>', {"name": options.name, "value": file.url, "type":"hidden"}));
            if (!file.type || file.type.search(/image\/.*/g) !== -1) {
                item.removeClass('not-image').addClass('image');
                item.prepend($('<img/>', {src: file.url, "class": "pinkynail"}));
            } else {
                item.removeClass('image').addClass('not-image');
            }
            var title = $('<div>', {"class": "filename new"})
                .html('<span class="title">' + file.filename + '</span>');

            item.append(title);

            return item;
        }


        methods.init.apply(this);
        return this;
    }
})(jQuery);