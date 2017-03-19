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
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_cpamanager/assets/css/cpamanager.css');

?>
<script type="text/javascript">
    function getScript(url,success) {
        var script = document.createElement('script');
        script.src = url;
        var head = document.getElementsByTagName('head')[0],
        done = false;
        // Attach handlers for all browsers
        script.onload = script.onreadystatechange = function() {
            if (!done && (!this.readyState
                || this.readyState == 'loaded'
                || this.readyState == 'complete')) {
                done = true;
                success();
                script.onload = script.onreadystatechange = null;
                head.removeChild(script);
            }
        };
        head.appendChild(script);
    }
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',function() {
        js = jQuery.noConflict();
        js(document).ready(function(){
            

            Joomla.submitbutton = function(task)
            {
                if (task == 'location.cancel') {
                    Joomla.submitform(task, document.getElementById('location-form'));
                }
                else{
                    
                    if (task != 'location.cancel' && document.formvalidator.isValid(document.id('location-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('location-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }
        });
    });
</script>
<div class="btn-toolbar">
    <div class="btn-group">
            <button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('location.save')">
                    <span class="icon-ok"></span><?php echo JText::_('JSAVE') ?>
            </button>
    </div>
</div>
<form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="location-form" class="form-validate">
    <div class="form-horizontal row-fluid">
            <div class="clearfix fltlft span12">
                <legend><?php echo JText::_('Location Calendar');?></legend>
               

                        <div class="control-group">
                            <div class="controlsx"><?php echo $this->form->getInput('name'); ?></div>
                        </div>
                        <div class="control-group">
                            <div class="controlsx"><?php echo $this->form->getInput('address'); ?></div>
                        </div>
                        <div class="control-group">
                            <div class="controlsx"><?php echo $this->form->getInput('phone'); ?></div>
                        </div>
                        <div class="control-group">
                            <div class="controlsx"><?php echo $this->form->getInput('email'); ?></div>
                        </div>
                        
                        <div class="control-group">
                            <div class="controlsx"><?php echo $this->form->getInput('created'); ?></div>
                        </div>
                        <div class="control-group">
                            <div class="controlsx"><?php echo $this->form->getInput('created_by'); ?></div>
                        </div>
                
                        <div class="span12">
                            <div class="control-group">
                                <div class="controlsx"><?php echo $this->form->getInput('longitude'); ?></div>
                                <div class="controlsx"><?php echo $this->form->getInput('latitude'); ?></div>
                            </div>
                        </div>
						
						<div class="clr"></div>
							<div style="clear:both">
								<div class="control-group">
								
									<div class="controlsx">
								<?php 
									
									$cfg = array(
										'id' => $this->item->id,
										'address' => $this->item->address,
										'lat' => $this->item->latitude,
										'lng' => $this->item->longitude,
									);
									echo jSont::googleMap($cfg); 
								?>
									</div>
								</div>
							</div>
               
            </div>
          
            
        </div>
    
    
    

    <?php echo $this->form->getInput('id'); ?>

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>
</form>