(function( $ ) {
    jQuery.fn.attachmentUpload = function(options) {
        var options = $.extend({
            'url':"",
            'sortable': false,
            "multiple":false,
            "maxNumberOfFiles": 0,
            "maxFileSize":null, // 5 MB
            "acceptFileTypes": null,
            "files":[]
        }, options);

        var $input = this;
        var $container = $input.parent('div');
        var $files = $('<ul>', {"class":"files"}).insertAfter($input);

        var methods = {
            init: function(){
                if (options.multiple == true) {
                    $input.attr('multiple', true);
                    $input.attr('name', $input.attr('name') + '[]');
                }

                if (options.sortable == true) {
                    $files.sortable({
                        placeholder: "upload-kit-item sortable-placeholder",
                        tolerance: "pointer",
                        forcePlaceholderSize: true,
                        update: function () {
                            methods.updateOrder()
                        }
                    })
                }

                $input.wrapAll($('<div class="upload-kit-input"></div>'))
                    .after($('<span class="glyphicon glyphicon-plus-sign add"></span>'))
                    .after($('<span class="glyphicon glyphicon-circle-arrow-down drag"></span>'))
                    .after($('<span/>', {"data-toggle":"popover", "class":"glyphicon glyphicon-exclamation-sign error-popover"}))
                    .after(
                        '<div class="progress">'+
                        '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'+
                        '</div>'
                    );
                $files.on('click', '.upload-kit-item .remove', methods.removeItem);
                methods.checkInputVisibility();
                methods.fileuploadInit();
                methods.dragInit();
            },
            fileuploadInit: function(){
                var $fileupload = $input.fileupload({
                    url: options.url,
                    dropZone: $input.parents('.upload-kit-input'),
                    dataType: 'json',
                    singleFileUploads: false,
                    multiple: options.multiple,
                    maxNumberOfFiles: options.maxNumberOfFiles,
                    maxFileSize: options.maxFileSize, // 5 MB
                    acceptFileTypes: options.acceptFileTypes
                        ? new RegExp(options.acceptFileTypes)
                        : null,
                    process: true,
                    getNumberOfFiles: methods.getNumberOfFiles,
                    start: function (e, data) {
                        $container.find('.upload-kit-input')
                            .removeClass('error')
                            .addClass('in-progress')
                    },
                    processfail: function(e, data) {
                        if (data.files.error) {
                            methods.showError(data.files[0].error);
                        }
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $container.find('.progress-bar').attr('aria-valuenow', progress).css(
                            'width',
                            progress + '%'
                        ).text(progress + '%');
                    },
                    done: function (e, data) {
                        $.each(data.result.files, function (index, file) {
                            if (!file.error) {
                                var item = methods.createItem(file);
                                item.appendTo($files);
                            } else {
                                methods.showError(file.errors)
                            }

                        });
                        methods.checkInputVisibility();
                        if (options.sortable) {
                            methods.updateOrder();
                        }
                    },
                    fail: function (e, data) {
                        methods.showError(data.errorThrown)
                    },
                    always: function (e, data) {
                        $container.find('.upload-kit-input').removeClass('in-progress')
                    }

                });
                if (options.files) {
                    options.files.sort(function(a, b){
                        return parseInt(a.order) - parseInt(b.order);
                    });
                    $fileupload.fileupload('option', 'done').call($fileupload, $.Event('done'), {result: {files: options.files}});
                    methods.checkInputVisibility();
                }
            },
            dragInit: function(){
                $(document).on('dragover', function ()
                {
                    $('.upload-kit-input').addClass('drag-highlight');
                });
                $(document).on('dragleave drop', function ()
                {
                    $('.upload-kit-input').removeClass('drag-highlight');
                });
            },
            showError: function(error){
                if ($.fn.popover) {
                    $container.find('.error-popover').attr('data-content', error).popover({html:true,trigger:"hover"});
                }
                $container.find('.upload-kit-input').addClass('error');
            },
            removeItem: function(e){ //删除图片项目
                var $this = $(this);
                var url = $this.data('url');
                if (url) {
                    $.ajax({
                        url: url,
                        type: 'DELETE'
                    })
                }
                $this.parents('.upload-kit-item').remove();
                methods.checkInputVisibility();
            },
            createItem: function(file){ //新建图片项目
                var name = options.name;
                var index = methods.getNumberOfFiles();
                if (options.multiple) {
                    name += '[' + index + ']';
                }
                var item = $('<li>', {"class": "upload-kit-item done"})
                    .append($('<input/>', {"name": name + '[path]',"value": file.path, "type":"hidden"}))
                    .append($('<input/>', {"name": name + '[id]', "value": file.id, "type":"hidden"}))
                    .append($('<input/>', {"name": name + '[name]',"value": file.name, "type":"hidden"}))
                    .append($('<input/>', {"name": name + '[hash]',"value": file.hash, "type":"hidden"}))
                    .append($('<input/>', {"name": name + '[type]',"value": file.type, "type":"hidden"}))
                    .append($('<input/>', {"name": name + '[size]',"value": file.size, "type":"hidden"}))
                    .append($('<input/>', {"name": name + '[extension]',"value": file.extension, "type":"hidden"}))
                    .append($('<input/>', {"name": name + '[order]',"data-role":"order", "value": file.order, "type":"hidden"}))
                    .append($('<span/>', {"class": "glyphicon glyphicon-remove-circle remove", "data-url": file.deleteUrl}));
                if (!file.type || file.type.search(/image\/.*/g) !== -1) {
                    item.removeClass('not-image').addClass('image');
                    item.prepend($('<a>', {
                        "class":"fancybox",
                        "href": file.url,
                        "rel": "fancybox-button fancybox-thumb",
                        "title": file.filename,
                        "data-fancybox-group": options.id
                    }).append($('<img/>', {src: file.url, width: 150, height: 150})));
                    item.find('span.type').text('');
                } else {
                    item.removeClass('image').addClass('not-image');
                    item.css('backgroundImage', '');
                    item.append($('<span/>', {"class": "name"}).text(file.filename));
                }
                return item;
            },
            checkInputVisibility: function(){
                var inputContainer = $container.find('.upload-kit-input');
                if (options.maxNumberOfFiles && (methods.getNumberOfFiles() >= options.maxNumberOfFiles)) {
                    inputContainer.hide();
                } else {
                    inputContainer.show();
                }
            },
            getNumberOfFiles: function() {
                return $container.find('.files .upload-kit-item').length;
            },
            updateOrder: function () {
                $files.find('.upload-kit-item').each(function(index, item){
                    $(item).find('input[data-role=order]').val(index);
                })
            }
        };

        methods.init.apply(this);
        return this;
    };

})(jQuery);