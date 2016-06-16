if (typeof mihaildev == "undefined" || !mihaildev) {
    var mihaildev = {};
}

mihaildev.elFinder = {
    openManager: function(options){
        var params = "menubar=no,toolbar=no,location=no,directories=no,status=no,fullscreen=no";
        if(options.width == 'auto'){
            options.width = $(window).width()/1.5;
        }

        if(options.height == 'auto'){
            options.height = $(window).height()/1.5;
        }

        params = params + ",width=" + options.width;
        params = params + ",height=" + options.height;

        console.log(params);
        var win = window.open(options.url, 'ElFinderManager' + options.id, params);
        win.focus()
    },
    functions: {},
    register: function(id, func){
        this.functions[id] = func;
    },
    callFunction: function(id, file){
        return this.functions[id](file, id);
    },
    functionReturnToInput: function(file, id){
        jQuery('#' + id).val(file.url);
        return true;
    }
};