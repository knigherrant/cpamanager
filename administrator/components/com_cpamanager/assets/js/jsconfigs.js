/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * <div id="BibleCategory">
    <legend>Create Bible Study Category</legend>
    <div class="jContent">
        <div id="BibleCategories"></div>
        <textarea style="display:none" id="bbCategories" name="categories_bible"><?php echo $this->item->categories_bible; ?></textarea>
    </div>
    <input type="button" name="button" id="" class="button addCategory button-hero" value="Add">
 </div>          
 * 
 */
jQuery(function($){
        var 
            bibleCategories = 'bibleCategories',
            eventCategories = 'eventCategories',
            prayerCategories = 'prayerCategories',
            listBible = $('.'+bibleCategories).val(),
            bibleJson = {},
            listEvent = $('.'+eventCategories).val(),
            eventJson = {},
            listPrayer = $('.'+prayerCategories).val(),
            prayerJson = {}
        ;
        if(listBible.length > 3) bibleJson = JSON.parse(listBible);
        if(listEvent.length > 3) eventJson = JSON.parse(listEvent);
        if(listPrayer.length > 3) prayerJson = JSON.parse(listPrayer);

        if(bibleJson){
            $.each(bibleJson, function(key, item){
                jvConfigs.addItem(key, item, bibleCategories);
            })
        }
        if(eventJson){
            $.each(eventJson, function(key, item){
                jvConfigs.addItem(key, item, eventCategories);
            })
        }
        if(prayerJson){
            $.each(prayerJson, function(key, item){
                jvConfigs.addItem(key, item, prayerCategories);
            })
        }
        $('input.addItem').click(function(){
            jvConfigs.addItem(1,{},$(this).data('id'));
        });
    })

var jvConfigs = (function($){
    var fnc = {
        intNum : function (i){
            this.countItems = i;
        },
        addItem : function (i,data, element){
            var 
                jdefault = {
                    'name' : ''
                },
                data = $.extend({}, jdefault, data),
                html = '',
                self = this
            ;
            self.countItems = self.countItems || 0;
            self.countItems = self.countItems + i;
            html ='<div id="items-'+ self.countItems+ '" class="lists-item">' +
                    '<div class="name-inputs">' +
                            '<input  type="text" class="name" value="'+ data.name +'"/>' + 
                            '<a class="btn btn-small btn-success" href="javascript:void(0)" onclick="jvConfigs.removeItem(this)" title="Remove"><span class="ui-icon ui-icon-close">X</span></a>' +
                    '</div></div>';
            
            $('#'+element).append(html);
        },
        toggle: function(el){
            $(el).parent().next().slideToggle(200);
        },
        setValueItems: function(element){
            var data = new Array();
            $.each($('#'+element+' .lists-item'), function(i, item){
                data[i] = {};
                data[i].name = $(item).find('input.name').val();
            });
            $('.' + element).val(JSON.stringify(data));
        },
        removeItem: function(el){
            $(el).parents('.lists-item').stop(true,true).fadeOut('200', function(){$(this).remove()});
        }
    }
    return fnc;
})(jQuery)
