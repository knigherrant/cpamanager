<?php
/**
 * @version     16.5.5
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . 'components/com_cpamanager/assets/js/json2.js');
$doc->addScript(JUri::base() . 'components/com_cpamanager/assets/js/jsconfigs.js');
?>
<script type="text/javascript">
    Joomla.submitbutton = function(task){
        if (task == 'configs.cancel') {
            Joomla.submitform(task, document.getElementById('configs-form'));
        }
        else {

            if (task != 'configs.cancel' && document.formvalidator.isValid(document.id('configs-form'))) {
                jvConfigs.setValueItems('taxformCategories');
                jvConfigs.setValueItems('invoiceCategories');
                jvConfigs.setValueItems('expensesCategories');
                jvConfigs.setValueItems('receiptCategories');
                Joomla.submitform(task, document.getElementById('configs-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>
<?php echo jSont::menuSiderbar(); ?>
<div class="signaturedoc">
    <form action="<?php echo JRoute::_('index.php?option=com_cpamanager')?>" method="post" enctype="multipart/form-data" name="adminForm" id="configs-form" class="form-validate dam-dashboad">
        <?php if(!empty($this->sidebar)): ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>
        <div id="j-main-container" class="span10">
        <?php else : ?>
        <div id="j-main-container">
            <?php endif;?>
            <div class="row-fluid form-horizontal" >
                <div id="addCategories" class="span12">
                    <div id="taxformCategory" class="span3">
                        <legend>Tax Forms</legend>
                            <div id="taxformCategories"></div>
                            <textarea style="display:none" class="taxformCategories" name="categories_taxform"><?php echo $this->item->categories_taxform; ?></textarea>
                            <input type="button" name="button" data-id="taxformCategories" class="btn btn-small btn-success addItem button-hero" value="Add">
                     </div>  
                    <div id="invoiceCategory" class="span3">
                        <legend>Invoice Categories</legend>
                            <div id="invoiceCategories"></div>
                            <textarea style="display:none" class="invoiceCategories" name="categories_invoice"><?php echo $this->item->categories_invoice; ?></textarea>
                            <input type="button" name="button" data-id="invoiceCategories" class="btn btn-small btn-success addItem button-hero" value="Add">
                     </div>        
                    <div id="expensesCategory" class="span3">
                        <legend>Expenses Categories</legend>
                            <div id="expensesCategories"></div>
                            <textarea style="display:none" class="expensesCategories" name="categories_expenses"><?php echo $this->item->categories_expenses; ?></textarea>
                            <input type="button" name="button" data-id="expensesCategories" class="btn btn-small btn-success addItem button-hero" value="Add">
                     </div> 
                    
                    <div id="receiptCategory" class="span3">
                        <legend>Receipt Categories</legend>
                            <div id="receiptCategories"></div>
                            <textarea style="display:none" class="receiptCategories" name="categories_receipt"><?php echo $this->item->categories_receipt; ?></textarea>
                            <input type="button" name="button" data-id="receiptCategories" class="btn btn-small btn-success addItem button-hero" value="Add">
                     </div>        
                    
                </div>
                <div class="clearfix"></div>
                <br/>
                <div>
                    <b>Notifications When Tax Return is Submited From App </b>
                </div>
                <div class="control-group">
                  <ul class="nav nav-tabs" id="myTabTabs">
                        <li class="active"><a  href="#msgen" data-toggle="tab" >English Version</a></li>
                        <li><a  href="#msgsn" data-toggle="tab" >Spanish Version</a></li>
                        
                </ul>
                    <div id="myTabContent" class="tab-content">
                        <div id="msgen" class="tab-pane active">
                             <?php echo JFactory::getEditor()->display( 'notify_tax_en', $this->item->notify_tax_en, '100%', '200', '20', '20'); ?>
                        </div>
                        <div id="msgsn" class="tab-pane">
                             <?php echo JFactory::getEditor()->display( 'notify_tax_sn', $this->item->notify_tax_sn, '100%', '200', '20', '20'); ?>
                        </div>
                    </div>
                </div>
                
                <br/>
               
                 <br/>
                <input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>

            </div>
        </div>
    </form>
</div>

<style>
    #import_email_body_ifr{
        height: 250px !important;
    }
</style>