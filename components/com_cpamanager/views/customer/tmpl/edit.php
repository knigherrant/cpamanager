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
<?php echo JST::toolbar(); ?>

<form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="customer-form" class="form-validate">
    <div class="jsont jCustommer form-horizontal row-fluid span12">
        <legend><?php echo JText::_('Customer');?></legend>
            <div class="clearfix fltlft span9">
                <div class="span12 jsontfirst">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('userid'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('cpaid'); ?></div>
                    </div>
                    <div class="control-group span4">
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
                        <div class="controlsx"><?php echo $this->form->getInput('logo'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('federal_id'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('first_tax'); ?></div>
                    </div>
                    <div class="control-group span4">
                        <div class="controlsx"><?php echo $this->form->getInput('first_fiscal'); ?></div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group span6">
                        <div class="controlsx"><?php echo $this->form->getInput('income_tax_form'); ?></div>
                    </div>
                    <div class="control-group span6">
                        <div class="controlsx"><?php echo $this->form->getInput('tax_exempt_form'); ?></div>
                    </div>
                </div>
                <div class="span12 full">
                    <div class="control-group">
                        <p>Notes</p>
                        <div class="controlsx"><?php echo $this->form->getInput('notes'); ?></div>
                    </div>
                </div>
              
                <div class="span12">
                    <div class="control-group span6">
                        <div class="controlsx"><a href="index.php?option=com_cpamanager&view=location&layout=edit&tmpl=component" rel="{handler: 'iframe', size: {x:600, y:600}}" class="btn btn-small btn-success modal">Add Location</a></div>
                    </div>
                    <div class="control-group span6" style="text-align: right">
                        <div class="control-label"><?php echo $this->form->getLabel('featured'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('featured'); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="span3" >
                <div class="control-group">
                        <div class="controlsx">
                            <input type="text" value="<?php echo @$this->item->location->longitude ;?>" placeholder="Longitude" class="inputbox" name="jLong" id="jLong"/>
                        </div>
                </div>
                <div class="control-group">
                    <div class="controlsx">
                            <input type="text" value="<?php echo @$this->item->location->latitude ;?>" placeholder="Latitude" class="inputbox" name="jLat" id="jLat"/>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controlsx">
                            <?php echo $this->form->getInput('location_id'); ?>
                            <?php 					
                                $cfg = array(
                                        'id' => $this->item->id,
                                        'address' => @$this->item->location->address,
                                        'lat' => @$this->item->location->latitude,
                                        'lng' => @$this->item->location->longitude,
                                        'width' => '320px',
                                        'height' => '200px',
                                );
                                echo jSont::googleMap($cfg); 
                            ?>
                    </div>
                </div>
                
                
                <legend><?php echo JText::_('SERVER CONFIGURATION');?></legend>
                <?php foreach ($this->form->getFieldset('server') as $field){  ?>
                       <div class="control-group">
                                <div class="controlsx">
                                        <?php echo $field->input; ?>
                                </div>
                        </div>
                <?php }; ?>

            </div>
        <div class="span12" style="padding: 10px">
            <?php echo $this->loadTemplate('locations');?>
        </div>
        
    </div>
    <?php echo $this->form->getInput('id'); ?>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>
</form>