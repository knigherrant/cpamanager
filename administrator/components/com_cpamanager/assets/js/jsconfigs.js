/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * <div id="TaxformCategory">
    <legend>Create Taxform Study Category</legend>
    <div class="jContent">
        <div id="TaxformCategories"></div>
        <textarea style="display:none" id="bbCategories" name="categories_taxform"><?php echo $this->item->categories_taxform; ?></textarea>
    </div>
    <input type="button" name="button" id="" class="button addCategory button-hero" value="Add">
 </div>          
 * 
 */
jQuery(function($){
        var 
            taxformCategories = 'taxformCategories',
            invoiceCategories = 'invoiceCategories',
            expensesCategories = 'expensesCategories',
            receiptCategories = 'receiptCategories',
            listTaxform = $('.'+taxformCategories).val(),
            taxformJson = {},
            listInvoice = $('.'+invoiceCategories).val(),
            invoiceJson = {},
            listExpenses = $('.'+expensesCategories).val(),
            expensesJson = {},
            listReceipt = $('.'+receiptCategories).val(),
            receiptJson = {}
        ;
        if(listTaxform.length > 3) taxformJson = JSON.parse(listTaxform);
        if(listInvoice.length > 3) invoiceJson = JSON.parse(listInvoice);
        if(listExpenses.length > 3) expensesJson = JSON.parse(listExpenses);
        if(listReceipt.length > 3) receiptJson = JSON.parse(listReceipt);

        if(taxformJson){
            $.each(taxformJson, function(key, item){
                jvConfigs.addItem(key, item, taxformCategories);
            })
        }
        if(invoiceJson){
            $.each(invoiceJson, function(key, item){
                jvConfigs.addItem(key, item, invoiceCategories);
            })
        }
        if(expensesJson){
            $.each(expensesJson, function(key, item){
                jvConfigs.addItem(key, item, expensesCategories);
            })
        }
        if(receiptJson){
            $.each(receiptJson, function(key, item){
                jvConfigs.addItem(key, item, receiptCategories);
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
