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
    <div class="jsont form-horizontal row-fluid span12">
        <legend><?php echo JText::_('CPA');?></legend>
            <div class="clearfix fltlft span9">
                <div class="span12 jsontfirst">
                    <div class="control-group span6">
                        <div class="controlsx"><?php echo $this->form->getInput('userid'); ?></div>
                    </div>
                    <div class="control-group span6">
                        <div class="controlsx"><?php echo $this->form->getInput('company'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('firstname'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('midname'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('lastname'); ?></div>
                    </div>
                </div>
                <div class="span12 full">
                    <div class="control-group">
                        <div class="controlsx"><?php echo $this->form->getInput('address1'); ?></div>
                    </div>
                </div>
                <div class="span12 full">
                    <div class="control-group">
                        <div class="controlsx"><?php echo $this->form->getInput('address2'); ?></div>
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
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('cell_phone'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('fax'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('email'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('url'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><span>Logo</span>  <?php echo $this->form->getInput('logo'); ?></div>
                    </div>
                </div>
                <div class="span12 full">
                    <div class="control-group">
                        <p>Notes</p>
                        <div class="controlsx"><?php echo $this->form->getInput('notes'); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="span3" >
                <div class="control-group">
                        <div class="controlsx">
                            <input type="text" placeholder="Longitude" class="inputbox" name="jLong" id="jLong"/>
                        </div>
                </div>
                <div class="control-group">
                        <div class="controlsx">
                                <input type="text" placeholder="Latitude" class="inputbox" name="jLat" id="jLat"/>
                        </div>
                </div>
                <legend><?php echo JText::_('SERVER CONFIGURATION');?></legend>
                <?php foreach ($this->form->getFieldset('server') as $field){  ?>
                       <div class="control-group">
                                <div class="controlsx">
                                        <?php if($field->fieldname == 'banner'){ ?> <span>Banner Ads</span> <?php } ?><?php echo $field->input; ?>
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