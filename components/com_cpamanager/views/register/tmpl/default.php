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
$this->form->setFieldAttribute('avatar', 'type', 'file');
?>
<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'register.cancel') {
                    Joomla.submitform(task, document.getElementById('register-form'));
                }
                else{
                    
                    if (task != 'register.cancel' && document.formvalidator.isValid(document.id('register-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('register-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>
<div id="CPAManagerContent">
    <div id="frontend-content">
        <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit'); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="register-form" class="form-validate">
            <div class="form-horizontal row-fluid">
                    <div class="clearfix fltlft">
                        <legend><?php echo JText::_('Register');?></legend>
                        <?php echo frontend::toolbar('register'); ?>
                        
                        <div class="control-group">
                            <div class="control-label">
                                <label id="jform_name-lbl" for="jform_username">Name</label>
                            </div>
                            <div class="controls">
                                <input name="jform[name]" id="jform_name" value="" class="inputbox" size="40" type="text">                                        
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">
                                <label id="jform_email-lbl" for="jform_email">Email</label>
                            </div>
                            <div class="controls">
                                <input name="jform[email]" id="jform_email" value="" class="inputbox" size="40" type="text">                                        
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">
                                <label id="jform_username-lbl" for="jform_username">Username</label>
                            </div>
                            <div class="controls">
                                <input name="jform[username]" id="jform_username" value="" class="inputbox" size="40" type="text">                                        
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">
                                <label id="jform_password-lbl" for="jform_password">Password</label>
                            </div>
                            <div class="controls">
                                <input name="jform[password]" id="jform_password" value="" class="inputbox" size="40" type="password">                                        
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">
                                <label id="jform_cpassword-lbl" for="jform_password">Confirm Password</label>
                            </div>
                            <div class="controls">
                                <input name="jform[password2]" id="jform_password2" value="" class="inputbox" size="40" type="password">                                        
                            </div>
                        </div>
                        
                        <?php foreach ($this->form->getFieldset('basic') as $field) : 
                            if($field->fieldname == 'userid' || $field->fieldname == 'testimonials' || $field->fieldname == 'account') continue;
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
                    </div>
                </div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="option" value="com_cpamanager" />
            <?php echo JHtml::_('form.token'); ?>
            <div class="clr"></div>
        </form>
    </div>
</div>