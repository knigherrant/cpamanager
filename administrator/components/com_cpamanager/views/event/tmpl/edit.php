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
                if (task == 'event.cancel') {
                    Joomla.submitform(task, document.getElementById('event-form'));
                }
                else{
                    
                    if (task != 'event.cancel' && document.formvalidator.isValid(document.id('event-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('event-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }
        });
    });
</script>

<form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="event-form" class="form-validate">
    <div class="form-horizontal row-fluid">
            <div class="clearfix fltlft span12">
                <legend><?php echo JText::_('Event Calendar');?></legend>
                <div class="span6">

							<div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('date_start'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('date_start'); ?></div>
                            </div>
							
							<div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('date_end'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('date_end'); ?></div>
                            </div>
							
							
                            <div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('subject'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('subject'); ?></div>
                            </div>
                            

                            <div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('category'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('category'); ?></div>
                            </div>
                        </div>
                        <div class="span6">

                            <div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('location'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('location'); ?></div>
                            </div>
                            <div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('phone'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('phone'); ?></div>
                            </div>
                            <div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('contact'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('contact'); ?></div>
                            </div>
                            <div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('address'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('address'); ?></div>
                            </div>
                            <div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('image1'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('image1'); ?></div>
                            </div>
                            <div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('image2'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('image2'); ?></div>
                            </div>
                            <div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('image3'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('image3'); ?></div>
                            </div>
                        </div>
                        <div class="span12">
                            <div class="control-group">
                                <div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('description'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('longitude'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('latitude'); ?></div>
                            </div>
                        </div>
						
						<div class="clr"></div>
							<div style="clear:both">
								<div class="control-group">
								<div class="control-label">Map</div>
									<div class="controls">
								<?php 
									
									$cfg = array(
										'id' => $this->item->id,
										'address' => $this->item->address .', '. $this->item->location,
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