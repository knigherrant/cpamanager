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
$this->form->setFieldAttribute('audio', 'type', 'file');
?>
<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'bible.cancel') {
                    Joomla.submitform(task, document.getElementById('bible-form'));
                }
                else{
                    
                    if (task != 'bible.cancel' && document.formvalidator.isValid(document.id('bible-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('bible-form'));
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
        <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="bible-form" class="form-validate">
            <div class="form-horizontal row-fluid bodyContents">
                    <div class="clearfix fltlft">
                        <legend><?php echo JText::_('Bible');?></legend>
                        <div class="bntTopRight"><?php echo frontend::toolbar('bible'); ?></div>
                        <?php foreach ($this->form->getFieldset('basic') as $field) : 
                            if($field->fieldname == 'created_by' || $field->fieldname == 'created') continue;
                            ?>
                               <div class="control-group">
                                        <div class="control-label">
                                                <?php echo $field->label; ?>
                                        </div>
                                        <div class="controls">
                                                <?php echo $field->input; ?>
                                        </div>
                                </div>
                        <?php endforeach; ?>
						<div class="clearfix clr"></div>
						
                    </div>
                </div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="option" value="com_cpamanager" />
            <?php echo JHtml::_('form.token'); ?>
            <div class="clr"></div>
        </form>
    </div>
</div>
<?php echo jSont::footer(); ?>