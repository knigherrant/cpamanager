var FilesModel = (function($){
    ko.bindingHandlers.plupload = {
        init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
            var bindings = allBindingsAccessor();
            var max_file_size = bindings.max_file_size;
            var file_types = bindings.file_types;

            $(element).pluploadQueue({
                // General settings
                runtimes : 'html5,flash,silverlight,html4',
                url : viewModel.prefix_url + '&task=files.upload',
                rename : true,
                dragdrop: true,
                filters : {
                    // Maximum file size
                    max_file_size : max_file_size + 'mb',
                    // Specify what files to browse for
                    mime_types: [
                        {title : "All files", extensions : file_types}
                    ]
                },
                // Flash settings
                flash_swf_url : '/plupload/js/Moxie.swf',
                // Silverlight settings
                silverlight_xap_url : '/plupload/js/Moxie.xap',
                init: function(){
                    /*$('.plupload_buttons').append($('<a/>',{href:'javascript:void(0);', class:'plupload_button plupload_clear plupload_disabled', text: Joomla.JText._('COM_METIKACCMGR_CLEAR_QUEUE')}))*/
                }
            });

            var uploader = $(element).pluploadQueue();
            uploader.bind('BeforeUpload', function(uploader, file) {
                // set directory in the request
                if(viewModel.folderSelected().path()){
                    uploader.settings.url = viewModel.prefix_url + '&task=files.upload&path='+viewModel.folderSelected().path();
                }else{
                    uploader.settings.url = viewModel.prefix_url + '&task=files.upload';
                }
            });
            uploader.bind('UploadComplete', function(uploader) {
                $('li.plupload_delete a,div.plupload_buttons').show();
                uploader.refresh();
            });
            var failed = {}
            uploader.bind('FileUploaded', function(uploader, file, response) {
                var data = $.parseJSON(response.response);
                if (!Boolean(data.rs)) {
                    failed[file.id] = data.msg;
                }else{
                    viewModel.folderSelected().files.push(data.file);
                }
            });
            uploader.bind('StateChanged', function(uploader) {
                $.each(failed, function(id, error) {
                    icon = $('#' + id).attr('class', 'plupload_failed').find('a').css('display', 'block').attr('title', error);
                });
            });
            uploader.bind('QueueChanged', function(uploader) {
                /*if(uploader.files.length) $('.plupload_buttons .plupload_clear').removeClass('plupload_disabled');
                else $('.plupload_buttons .plupload_clear').addClass('plupload_disabled');*/
            });
            /*setTimeout(function(){
                $('.plupload_buttons .plupload_clear').click(function(){
                    if(confirm(Joomla.JText._('COM_CLIENTROL_MSG_CONFIRM_CLEAR_QUEUE'))) {
                        var files = uploader.files.splice(0);
                        $.each(files, function(file) {
                            uploader.removeFile(file);
                        });
                        failed = {};
                    }
                });
            }, 100);*/

        }
    };

    var DirNode = function(name, path, level, childs, files, expand, parent) {
        this.name = ko.observable(name);
        this.path = ko.observable(path);
        this.level = ko.observable(level);
        this.childs = ko.observableArray(childs);
        this.files = ko.observableArray(files);
        this.expand = ko.observable(expand);
        this.parent = ko.observable();
        if(parent) this.parent(parent);
    }

    var RemoteFile = function(viewModel, url, name, size){
        this.url = ko.observable(url || '');
        this.name = ko.observable(name || '');
        this.size = ko.observable(size || '');
        this.validateUrl = function(url){
            return url && (/^(https?|ftp|rmtp|mms):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\/?/i).test(url);
        }

        var that = this
        that.url.subscribe(function(value){
            that.name('');
            that.size('');
            if(that.validateUrl(value)){
                $.getJSON(viewModel.prefix_url + '&task=files.getUrl', {url: value}, function(data){
                    if(data.rs){
                        that.name(data.file.name);
                        that.size(data.file.size);
                    }else{
                        alert(data.msg);
                    }
                });
            }
        });
        that.size.subscribe(function(){
            setTimeout(function(){
                $('#files-uploader-web-form .remote-wrap').css('margin-right', $('#files-uploader-web-form .remote-submit').outerWidth());
            }, 200);
        });
    }

    return function(root, prefix_url, ctn, ctn_type, field){
        var self = this;
        self.prefix_url = prefix_url;
        self.ctn = ctn;
        self.ctn_type = ctn_type;
        self.dirs = new DirNode('Root', '', 0, [], root.files, true);
        self.fileSelected = ko.observable();
        self.fileDetail = ko.observable();
        self.folderSelected = ko.observable(self.dirs);
        $.each(root.childs, function(i, it){
            self.folderSelected().childs.push(new DirNode(it.name, it.path, self.folderSelected().level() + 1, [], [], false, self.folderSelected()));
        });

        self.getFolderLoading = ko.observable(false);
        self.getFolder = function(item){
            self.folderSelected(item);
            self.folderSelected().childs([]);
            self.fileSelected('');
            self.fileDetail('');
            self.getFolderLoading(true);
            $.getJSON(self.prefix_url + '&task=files.getFolder', {path: self.folderSelected().path()}, function(data){
                self.getFolderLoading(false);
                self.folderSelected().expand(true);
                self.folderSelected().files(data.files);
                $.each(data.childs, function(i, it){
                    self.folderSelected().childs.push(new DirNode(it.name, it.path, self.folderSelected().level() + 1, [], [], false, self.folderSelected()));
                });
            });
        }

        self.expand = function(item){
            item.expand(!item.expand());
        }
        
        self.getFileLoading = ko.observable(false);
        self.getFile = function(item){
            self.fileSelected(item);
            self.getFileLoading(true);
            $.getJSON(self.prefix_url + '&task=files.getFile', {path: self.fileSelected().path}, function(data){
                if(data.rs){
                    self.getFileLoading(false);
                    self.fileDetail(data.file);
                }else{
                    alert(data.msg);
                }
            });
        }

        self.deleleFile = function(item){
            self.getFileLoading(true);
            $.getJSON(self.prefix_url + '&task=files.deleteFile', {path: self.fileSelected().path}, function(data){
                if(data.rs){
                    self.folderSelected().files.remove(item);
                    self.fileSelected('');
                    self.fileDetail('');
                    self.getFileLoading(false);
                }else{
                    alert(data.msg);
                }
            });
        }

        self.newFolderName = ko.observable('');
        self.createFolder = function(){
            $.getJSON(self.prefix_url + '&task=files.createFolder', {path: self.folderSelected().path, name: self.newFolderName()}, function(data){
                if(data.rs){
                    self.folderSelected().childs.push(new DirNode(data.name, data.path, self.folderSelected().level() + 1, [], [], false, self.folderSelected()));
                    self.newFolderName('');
                }else{
                    alert(data.msg);
                }
            });
        }

        self.deleteFolder = function(){
            $.getJSON(self.prefix_url + '&task=files.deleteFolder', {path: self.folderSelected().path}, function(data){
                if(data.rs){
                    var parent = self.folderSelected().parent();
                    parent.childs.remove(self.folderSelected());
                    self.folderSelected(parent);
                }else{
                    alert(data.msg);
                }
            });
        }

        self.insertFile = function(){
            window.parent.jQuery('#'+field).val(self.fileSelected().path).trigger('change');
            if(self.ctn_type == 'file'){
                if(window.parent.jQuery('#'+field+'-type').length){
                    window.parent.jQuery('#'+field+'-type').val(self.fileDetail().type).trigger('change');
                }
                if(window.parent.jQuery('#'+field+'-extension').length){
                    window.parent.jQuery('#'+field+'-extension').val(self.fileDetail().extension).trigger('change');
                }
            }
            if(self.ctn_type == 'image'){
                if(window.parent.jQuery('#'+field+'-preview').length){
                    window.parent.jQuery('#'+field+'-preview').attr('src', self.fileDetail().url);
                }
                if(self.ctn == 'icons'){
                    if(window.parent.jQuery('#'+field+'_custom').length){
                        window.parent.jQuery('#'+field+'_custom').val(1);
                    }
                }
            }
            window.parent.SqueezeBox.close();
        }

        self.remoteFile = new RemoteFile(self);

        self.uploadFromUrl = function(){
            $.getJSON(self.prefix_url + '&task=files.uploadFromUrl', {path: self.folderSelected().path(), name: self.remoteFile.name(), url: self.remoteFile.url()}, function(data){
                if(data.rs){
                    self.folderSelected().files.push(data.file);
                    self.remoteFile.url('');
                    self.remoteFile.name('');
                    self.remoteFile.size('');
                    $('#remote-url').addClass('success').attr('placeholder', Joomla.JText._('Upload Success'));
                }else{
                    alert(data.msg);
                }
            });
        }

        $('#files-tab a:first').tab('show');
        $('.upload-form-toggle').click(function(e){
            e.preventDefault();
            if(!$(this).hasClass('active')){
                $('.upload-form-toggle').removeClass('active');
                $('#files-uploader .upload-form').hide();
                $('#files-uploader-' + $(this).attr('href').replace('#','')).show();
                $(this).addClass('active');
            }
        });
        $('#remote-url').focus(function(){
           if($(this).hasClass('success')) $(this).removeClass('success').attr('placeholder', Joomla.JText._('Remove Link'));
        });
    }
})(jQuery);