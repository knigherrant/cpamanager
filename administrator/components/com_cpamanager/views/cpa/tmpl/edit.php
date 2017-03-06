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
?>
<?php echo jSont::menuSiderbar(); ?>
<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'cpa.cancel') {
                    Joomla.submitform(task, document.getElementById('cpa-form'));
                }
                else{
                    
                    if (task != 'cpa.cancel' && document.formvalidator.isValid(document.id('cpa-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('cpa-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>

<form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="cpa-form" class="form-validate">
    <div class="form-horizontal row-fluid">
            <div class="clearfix fltlft">
                <legend><?php echo JText::_('CPA');?></legend>
                <?php foreach ($this->form->getFieldset('basic') as $field) : ?>
                       <div class="control-group">
                                <div class="field-input">
                                        <?php echo jSont::customfield ($field); ?>
                                </div>
                        </div>
                <?php endforeach; ?>
            </div>
        </div>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>
</form>