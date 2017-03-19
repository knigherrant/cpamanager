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
JHtml::_('behavior.modal', 'a.modal');
JHtml::_('formbehavior.chosen', 'select');							
?>
<?php echo jSont::menuSiderbar(); ?>
<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'taxreturn.cancel') {
                    Joomla.submitform(task, document.getElementById('taxreturn-form'));
                }
                else{
                    
                    if (task != 'taxreturn.cancel' && document.formvalidator.isValid(document.id('taxreturn-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('taxreturn-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>

<form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="taxreturn-form" class="form-validate">
    <div class="jsont jCustommer form-horizontal row-fluid span12">
        
            <div class="clearfix fltlft span9">
                <legend><?php echo JText::_('Tax Return');?></legend>
                <!-- TAX RETURN -->
                <div class="span12 jsontfirst">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_firstname'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_midname'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_lastname'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_birthday'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_social_number'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_filing_status'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_license_id'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_issue_date'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_expiration_date'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_occupation'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_dependents'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"></div>
                    </div>
                </div>
                <!-- END TAX -->
                <legend><?php echo JText::_('Spouse');?></legend>
                <div class="span12 jsontfirst">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('spouse_firstname'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('spouse_midname'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('spouse_lastname'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('spouse_birthday'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('spouse_social_number'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('spouse_filing_status'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('spouse_license_id'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('spouse_issue_date'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('spouse_expiration_date'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('spouse_occupation'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"></div>
                    </div>
                </div>
                <!--- END SPOUSE -->
                <!-- ADDRESS -->
                <div class="span12 full">
                    <div class="control-group span8">
                        <div class="controlsx"><?php echo $this->form->getInput('address'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('apartment'); ?></div>
                    </div>
                </div>
               
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('city'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('state'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('zip'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('phone'); ?></div>
                    </div>
                    <div class="control-group span8">
                        <div class="controlsx"><?php echo $this->form->getInput('email'); ?></div>
                    </div>
                </div>
                
                <div class="span12">
                    <ul class="nav nav-tabs" id="myTabTabs">
                        <li class="active"><a href="#dependent1" data-toggle="tab">Dependent 1</a></li>
                        <li class=""><a href="#dependent2" data-toggle="tab">Dependent 2</a></li>
                        <li class=""><a href="#dependent3" data-toggle="tab">Dependent 3</a></li>
                        <li class=""><a href="#dependent4" data-toggle="tab">Dependent 4</a></li>
                        <li class=""><a href="#dependent5" data-toggle="tab">Dependent 5</a></li>
                    </ul>
                   <div id="myTabContent" class="tab-content">
                       <div id="dependent1" class="tab-pane active">
                           <?php $i = 0; foreach ($this->form->getFieldset('d1') as $field){  ?>
                                <div class="control-group span4 custom<?php echo $i; ?>">
                                         <div class="controlsx"> 
                                             <?php if($i == 6 || $i == 7){ ?> <?php echo $field->description; ?> <?php } ?> 
                                                 <?php echo $field->input; ?> 
                                         </div>
                                 </div>
                            <?php $i ++; }; ?>
                       </div>
                       <div id="dependent2" class="tab-pane">
                           <?php $i = 0; foreach ($this->form->getFieldset('d2') as $field){  ?>
                                <div class="control-group span4 custom<?php echo $i; ?>">
                                         <div class="controlsx"> 
                                             <?php if($i == 6 || $i == 7){ ?> <?php echo $field->description; ?> <?php } ?> 
                                                 <?php echo $field->input; ?> 
                                         </div>
                                 </div>
                            <?php $i ++; }; ?>
                       </div>
                       <div id="dependent3" class="tab-pane">
                           <?php $i = 0; foreach ($this->form->getFieldset('d3') as $field){  ?>
                                <div class="control-group span4 custom<?php echo $i; ?>">
                                         <div class="controlsx"> 
                                             <?php if($i == 6 || $i == 7){ ?> <?php echo $field->description; ?> <?php } ?> 
                                                 <?php echo $field->input; ?> 
                                         </div>
                                 </div>
                            <?php $i ++; }; ?>
                       </div>
                       <div id="dependent4" class="tab-pane">
                           <?php $i = 0; foreach ($this->form->getFieldset('d4') as $field){  ?>
                                <div class="control-group span4 custom<?php echo $i; ?>">
                                         <div class="controlsx"> 
                                             <?php if($i == 6 || $i == 7){ ?> <?php echo $field->description; ?> <?php } ?> 
                                                 <?php echo $field->input; ?> 
                                         </div>
                                 </div>
                            <?php $i ++; }; ?>
                       </div>
                       <div id="dependent5" class="tab-pane">
                           <?php $i = 0; foreach ($this->form->getFieldset('d5') as $field){  ?>
                                <div class="control-group span4 custom<?php echo $i; ?>">
                                         <div class="controlsx"> 
                                             <?php if($i == 6 || $i == 7){ ?> <?php echo $field->description; ?> <?php } ?> 
                                                 <?php echo $field->input; ?> 
                                         </div>
                                 </div>
                            <?php $i ++; }; ?>
                       </div>
                   </div>
               </div>
                <div class="span12">
                        <div class="controlsx"><?php echo $this->form->getInput('image'); ?></div>
                </div>
                
            </div>
            
            <div class="span3" >
                <legend><?php echo JText::_('Infomaion');?></legend>
                <?php foreach ($this->form->getFieldset('right') as $field){  ?>
                       <div class="control-group">
                                <div class="controlsx">
                                        <?php echo $field->input; ?>
                                </div>
                        </div>
                <?php }; ?>
            </div>
        
    </div>
    <?php echo $this->form->getInput('id'); ?>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>
</form>