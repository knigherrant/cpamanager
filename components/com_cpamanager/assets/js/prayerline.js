var jSont = (function($){
    var fn = {
        log : function(knigherrant){
            console.log(knigherrant);
        },
        uploadImage : function(){
            var 
                formData = new FormData(),
                imggif = $('#loadingmessage').find('img').attr('src'),
                avatar = $('#userProfile .userAvatar img')
            ; 
            if($('#cAvatar').val()){
                    formData.append('avatar', $('#cAvatar')[0].files[0]);
            }
            avatar.attr('src', imggif);
	    $.ajax({
                url: "index.php?option=com_cpamanager&task=frontend.uploadAvatar",
                type: "POST",
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false   // tell jQuery not to set contentType
              }).done(function( data ) {
                      $('#loadingmessage').hide();
                      avatar.attr('src', data);
                      
              });		   
        }
    };
    return fn;
})(jQuery)