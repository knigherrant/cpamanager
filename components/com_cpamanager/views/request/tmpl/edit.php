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
<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'request.cancel') {
                    Joomla.submitform(task, document.getElementById('request-form'));
                }
                else{
                    
                    if (task != 'request.cancel' && document.formvalidator.isValid(document.id('request-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('request-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>
<div id="CPAManagerContent">
    <div id="frontend-content">
        <?php echo jSont::showProfileHtml(); ?>
        <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="request-form" class="form-validate">
            <div class="form-horizontal row-fluid bodyContents">
                    <div class="clearfix fltlft span12">
                        <legend><?php echo JText::_('Request');?></legend>
                        <div class="bntTopRight"><?php echo frontend::toolbar('request'); ?></div>
                        
                        <?php foreach ($this->form->getFieldset('basic') as $field){ if($field->fieldname == 'userid') continue; ?>
                                <div class="control-group">
                                         <div class="control-label">
                                                 <?php echo $field->label; ?>
                                         </div>
                                         <div class="controls <?php if($field->fieldname == 'prayer_description'){echo 'jSontTextarea';}; ?>">
                                                 <?php echo $field->input; ?>
                                         </div>
                                 </div>
                        <?php }; ?>
                        
                    </div>
                </div>
                

            <input type="hidden" name="task" value="" />
            <input type="hidden" name="option" value="com_cpamanager" />
            <?php echo $this->form->getInput('id'); ?>
            <?php echo JHtml::_('form.token'); ?>
            <div class="clr"></div>
        </form>
    </div>
</div>
<?php echo jSont::footer(); ?>