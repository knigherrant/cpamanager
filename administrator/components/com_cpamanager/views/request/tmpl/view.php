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
$item = $this->item;
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
//k($item);
?>
<?php echo jSont::menuSiderbar(); ?>
<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'profile.cancel') {
                    Joomla.submitform(task, document.getElementById('profile-form'));
                }
                else{
                    
                    if (task != 'profile.cancel' && document.formvalidator.isValid(document.id('profile-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('profile-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>
<form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="profile-form" class="form-validate">
    <div class="userProfile">
        <?php echo jSont::showProfileHtml($item->userid);?>
        <div class="clearfix clear"></div>
      
        <div class="prayrequest">
            <legend><?php echo JText::_('Prayer Request'); ?></legend>
			<div class="prayerHead">
				<p><?php echo $item->prayer_request; ?></p>
				<p><?php echo $item->category; ?></p>
			</div>
			<p><?php echo jSont::format($item->date_post); ?></p>
            <div class="desc"><?php echo $item->prayer_description; ?></div>
            <div class="clearfix clear"></div>
            <a href="index.php?option=com_cpamanager&view=requests" class="btn btn-primary btn-xs">View All My Request</a>
        </div>

        <div class="prayfor">
            <legend><?php echo JText::_('Testimonials'); ?></legend>
            <?php echo $item->profile->testimonials; ?>
            <div class="clearfix clear"></div>
            <a href="index.php?option=com_cpamanager&view=requests" class="btn btn-primary btn-xs">View Users Praying For</a>
        </div>
    </div>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>    
</form>