<?php
/**
 * @version     1.0.0
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
JHtml::_('formbehavior.chosen', 'select', null, array('disable_search_threshold' => 0 ));
?>
<?php echo JST::header(); ?>
<?php echo JST::toolbar('mileage'); ?>
<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'mileage.cancel') {
                    Joomla.submitform(task, document.getElementById('mileage-form'));
                }
                else{
                    
                    if (task != 'mileage.cancel' && document.formvalidator.isValid(document.id('mileage-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('mileage-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>
<form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="mileage-form" class="form-validate">
    <div class="jsContents form-horizontal row-fluid jscustom12">
        <legend><?php echo JText::_('Mileage');?></legend>
            <div class="clearfix fltlft jscustom12">
                <div class="clearfix fltlft span">
                    <?php foreach ($this->form->getFieldset('basic') as $field) : if($field->type == 'cpa') continue; ?>
                           <div class="control-group">
                                    <div class="control-label">
                                            <?php echo $field->label; ?>
                                    </div>
                                    <div class="controls">
                                            <?php echo $field->input; ?>
                                    </div>
                            </div>
                    <?php endforeach; ?>
                        
                </div>
                
        </div>
    </div>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>
</form>

<?php echo JST::footer(); ?>