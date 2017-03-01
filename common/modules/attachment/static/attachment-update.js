$(document).ready(function() {


    var is_init = false;
    var jcrop_api;
    
    function getRandom() {
        var dim = [jcrop_api.ui.stage.width,jcrop_api.ui.stage.height];

        return [
          Math.round(Math.random() * dim[0]),
          Math.round(Math.random() * dim[1]),
          Math.round(Math.random() * dim[0]),
          Math.round(Math.random() * dim[1])
        ];
      };

    $('#setSelectButton').click(function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        $('#cropButton').removeClass("hide");
        $('#releaseButton').removeClass("hide");
        $('#setSelectButton').addClass("hide");

        $('.original-image').Jcrop({
            boxWidth: "800",
            onChange: function (c) {
                $('#crop-x').val(c.x);
                $('#crop-y').val(c.y);
                $('#crop-w').val(c.w);
                $('#crop-h').val(c.h);
            }
        }, function() {
            jcrop_api = this;
            var thumbnail = this.initComponent('Thumbnailer', {
                width: 130,
                height: 130
            });
            this.ui.preview = thumbnail;
            jcrop_api.newSelection();

            var bound = getRandom();
            jcrop_api.setSelect(bound);

            $('#crop-x').val(bound[0]);
            $('#crop-y').val(bound[1]);
            $('#crop-w').val(bound[2]);
            $('#crop-h').val(bound[3]);

            if (is_init == false) {

                is_init = true;
                jcrop_api.container.on('cropmove cropend', function(e, s, c) {
                    $('#crop-x').val(c.x);
                    $('#crop-y').val(c.y);
                    $('#crop-w').val(c.w);
                    $('#crop-h').val(c.h);
                });

                $('#text-inputs').on('change', 'input', function(e) {
                    jcrop_api.animateTo([
                        parseInt($('#crop-x').val()),
                        parseInt($('#crop-y').val()),
                        parseInt($('#crop-w').val()),
                        parseInt($('#crop-h').val())
                    ]);
                });
            }
        });
        return false;

    });

    $('#releaseButton').click(function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        $('#cropButton').addClass("hide");
        $('#releaseButton').addClass("hide");
        $('#setSelectButton').removeClass("hide");

        jcrop_api.destroy();
        $(".original-image").attr("style", "");
        return false;
    });

    $('#cropButton').click(function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        $.ajax({
            type: "POST",
            url: cropUrl,
            data: {
                x: $('#crop-x').val(),
                y: $('#crop-y').val(),
                w: $('#crop-w').val(),
                h: $('#crop-h').val(),
                type: $("input[name='crop-apply-type']:checked").val()
            },
            success: function(msg) {
                if (msg.status == true) {

                    location.reload();

                } else {
                    console.log(msg);
                    //alert(msg.error);
                }
            }
        });
        return false;
    });
});
