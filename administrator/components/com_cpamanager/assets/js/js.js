
    jQuery(function($){
        $('#jform_storage_type').change(function(){
            if($(this).val() == 'file'){
                $('#jform_storage_path_remote').parent().parent().hide();
                $('#jform_storage_path_file').parent().parent().parent().show();
                if($('#jform_storage_path_file-type').val() == 'image'){
                    $('.automatic-unsupported-location, .automatic-unsupported-format').hide();
                    $('.automatic-enabled').show();
                }else{
                    $('.automatic-enabled, .automatic-unsupported-location').hide();
                    $('.automatic-unsupported-format').show();
                }
            }else{
                $('#jform_storage_path_remote').parent().parent().show();
                $('#jform_storage_path_file').parent().parent().parent().hide();
                $('.automatic-enabled, .automatic-unsupported-format').hide();
                $('.automatic-unsupported-location').show();
            }
        });
        $('#jform_storage_path_file-type').change(function(){
            if($(this).val() == 'image'){
                $('.automatic-unsupported-location, .automatic-unsupported-format').hide();
                $('.automatic-enabled').show();
            }else{
                $('.automatic-enabled, .automatic-unsupported-location').hide();
                $('.automatic-unsupported-format').show();
            }
        });

        $('#jform_storage_path_file-extension').change(function(){
            var ext = $(this).val();
            var $icon = $('li.icon a[title="'+ext+'"]');
            if(ext){
                if(!$icon.length) $icon = $('li.icon a').eq(0);
                $('#jform_icon-preview').attr('src', $icon.data('src'));
                $('#jform_icon').val($icon.data('value'));
                $('#jform_icon_custom').val(0);
            }
        });

        $('#jform_image').change(function(){
            if($(this).val()){
                $('.automatic-enabled, .automatic-unsupported-location, .automatic-unsupported-format').hide();
            }else{
                $('#jform_image-preview').attr('src', nothumnail);
            }
        });
        $('#image-selector-clear').click(function(){
            $('#jform_image').val('').trigger('change');
        });
        $('.signaturedoc .dropdown-grid li.icon a').click(function(){
            var $icon = $(this);
            $('#jform_icon-preview').attr('src', $icon.data('src'));
            $('#jform_icon').val($icon.data('value'));
            $('#jform_icon_custom').val(0);
        });
    })
