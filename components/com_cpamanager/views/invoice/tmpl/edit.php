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

JHtml::_('formbehavior.chosen', 'select');

JHtml::_('behavior.keepalive');
?>
<?php echo JST::header(); ?>
<?php echo JST::toolbar('invoice'); ?>
<script type="text/javascript">
    Joomla.submitbutton = function(task)
    {
        if (task == 'invoice.cancel') {
            Joomla.submitform(task, document.getElementById('invoice-form'));
        }
        else {
            
            if (task != 'invoice.cancel' && document.formvalidator.isValid(document.id('invoice-form'))) {
                if($JVDAM('#jform_storage_type').val() == 'file' && $JVDAM('#jform_storage_path_file').val() == ''){
                    alert('<?php echo $this->escape(JText::_('COM_CPAMANAGER_MSG_FILE_PATH_REQUIRE')); ?>');
                }else if($JVDAM('#jform_storage_type').val() == 'remote' && $JVDAM('#jform_storage_path_remote').val() == ''){
                    alert('<?php echo $this->escape(JText::_('COM_CPAMANAGER_MSG_FILE_PATH_REMOTE_REQUIRE')); ?>');
                }else{
                    Joomla.submitform(task, document.getElementById('invoice-form'));
                }
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>
<div class="cpamanager">
    <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="invoice-form" class="form-validate">
         <div class="jsContents form-horizontal row-fluid jscustom12">
            <div class="jscustom6 field3">
                <legend><?php echo JText::_('Detail');?></legend>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('title'); ?></div>
                </div>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('category'); ?></div>
                </div>
        
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('storage_type'); ?></div>
                </div>
                <div class="control-group" style="<?php if($this->item->storage_type == 'remote') echo 'display:none;'?>">
                    <div class="controlsx"><?php echo $this->form->getInput('storage_path_file'); ?></div>
                </div>
                <div class="control-group" style="<?php if(!$this->item->storage_type || $this->item->storage_type == 'file') echo 'display:none;'?>">
                    <div class="controlsx"><?php echo $this->form->getInput('storage_path_remote'); ?></div>
                </div>
                <legend><?php echo JText::_('Description');?></legend>
                <div style="padding-right:10px;">
                    <?php echo $this->form->getInput('description'); ?>
                </div>
            </div>
            <div class="jscustom6 field3">
                <legend><?php echo JText::_('Metadata');?></legend>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('company'); ?></div>
                </div>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('access'); ?></div>
                </div>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('state'); ?></div>
                </div>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('image'); ?></div>
                </div>
                <div class="control-group">
                    <div class="controlsx">Icon : <?php echo $this->form->getInput('icon'); ?></div>
                </div>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('publish_on'); ?></div>
                </div>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('unpublish_on'); ?></div>
                </div>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('created_by'); ?></div>
                </div>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('created'); ?></div>
                </div>
                <div class="control-group">
                    <div class="controlsx"><?php echo $this->form->getInput('modified'); ?></div>
                </div>
                
              
            </div>

            <?php echo $this->form->getInput('id'); ?>
            <?php echo $this->form->getInput('icon_custom'); ?>
            <?php echo $this->form->getInput('filesize'); ?>
            <?php echo $this->form->getInput('ext'); ?>
            <input type="hidden" name="task" value="" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
</div>
<?php echo JST::footer(); ?>