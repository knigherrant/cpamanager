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
$item = $this->item;
?>
<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'warrior.cancel') {
                    Joomla.submitform(task, document.getElementById('warrior-form'));
                }
                else{
                    
                    if (task != 'warrior.cancel' && document.formvalidator.isValid(document.id('warrior-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('warrior-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>
<div id="CPAManagerContent">
    <div id="warrior-content">
        <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit'); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="warrior-form" class="form-validate">
            <div class="form-horizontal row-fluid bodyContents">
                    <div class="clearfix fltlft">
                        <legend><?php echo JText::_('Warrior');?></legend>
                        <div class="bntTopRight"><?php echo frontend::toolbar('warrior'); ?></div>
						
						<div class="itemWarrior">
							<div class="prayAvatar">
								<div class="mini-avatar"><img src="<?php echo jSont::getAvatar($item->profile->avatar); ?>" alt="avatar"/></div>
								<p class="user"><?php echo $item->profile->user->name; ?></p>
								<p class="category"><?php echo $item->category; ?></p>
							</div>
							<div class="prayInfo callouts">
								<div class="callouts--left">
									<p class="subject"><?php echo $item->prayer_request; ?></p>
									<?php echo $item->prayer_description; ?>
								</div>
							</div>
							<div class="clr clear clearfix"> </div>
						</div>
						<br/>
                        <div class="control-group">
                                <div class="control-label">
                                        <?php echo $this->form->getLabel('praying_desc'); ?>
                                </div>
                                <div class="controls jSontTextarea">
                                        <?php echo $this->form->getInput('praying_desc'); ?>
                                </div>
                        </div>
                        
                    </div>
            </div>
            <input type="hidden" name="jform[prayfor]" value="<?php echo $item->userid; ?>" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="option" value="com_cpamanager" />
            <?php echo JHtml::_('form.token'); ?>
            <div class="clr"></div>
        </form>
    </div>
</div>
<?php echo jSont::footer(); ?>