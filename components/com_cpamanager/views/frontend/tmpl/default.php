<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomlavi <info@joomlavi.com> - http://www.joomlavi.com
 */

defined('_JEXEC') or die;
$item = $this->item;
$itemid = JFactory::getApplication()->input->getInt('Itemid');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>

<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'frontend.cancel') {
                    Joomla.submitform(task, document.getElementById('frontend-form'));
                }
                else{
                    
                    if (task != 'frontend.cancel' && document.formvalidator.isValid(document.id('frontend-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('frontend-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>

<div id="loadingmessage" style="display:none">
    <img src="<?php echo JURI::root(); ?>components/com_cpamanager/assets/images/loading-large.gif"> 
</div>

<?php if(!$item) return; ?>
<div id="CPAManagerContent">
    <div id="frontend-content">
        
        
        <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="frontend-form" class="form-validate">
        <?php echo jSont::showProfileHtml(0, true); ?>
        <div class="bio lineButtom">
            <legend><?php echo JText::_('Personal Bio'); ?></legend>
            <div class="content-bio"><?php echo $item->bio; ?></div>

        </div>

        <div class="prayrequest">
            <legend><?php echo JText::_('Prayer Request'); ?></legend>
            <?php echo @$item->prayerRequest->prayer_request; ?>
            <div class="clearfix clear"></div>
			<div class="bntRight">
				<a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=request&layout=edit&Itemid=' . $itemid); ?>" class="btn btn-xs">
						Request Prayer
				</a>
				<a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=requests&Itemid=' . $itemid); ?>" class="btn btn-xs">
						View All My Request
				</a>
			</div>
        </div>
        <?php if($item->testimonials){ ?>
        <div class="testimonials lineButtom">
            <legend><?php echo JText::_('Testimonials'); ?></legend>
            <div class="content-testimonials">
                <div class="jSontTextarea">
                    <textarea name="testimonials"><?php echo $item->testimonials ;?></textarea>
					<div class="bntRight">
						<button type="button" class="btn" onclick="Joomla.submitbutton('frontend.savedata')">
								<span class="icon-ok"></span><?php echo JText::_('JSAVE') ?>
						</button>
					</div>
                </div>
                
            </div>

        </div>
        <?php } ?>
        
        <div class="prayfor lineButtom">
            <legend><?php echo JText::_('Praying For'); ?></legend>
            <?php echo @$item->prayerRequest->prayer_request; ?>
            <div class="clearfix clear"></div>
			<div class="bntRight">
				<a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=warriors&id='.JFactory::getUser()->id.'&Itemid=' . $itemid); ?>" class="btn btn-xs">View Users Praying For</a>
			</div>
		</div>
        
        <?php if($item->account){ ?>
            <div class="bible">
                <legend><?php echo JText::_('Bible Study'); ?></legend>
                <div class="span3"><p class="key">Title</p><p class="val"><?php echo $item->bible->title; ?></p></div>
                <div class="span3"><p class="key">Category</p><p class="val"><?php echo $item->bible->category; ?></p></div>
                <div class="span3"><p class="key">Date</p><p class="val"><?php echo jSont::format($item->bible->created); ?></p></div>
                <div class="clearfix clear"></div>
                <div class="span12">
					<p class="key">Description</p>
					<div class="txtContent"><?php echo $item->bible->description; ?></div>
                    <p class="key">Documents</p>
                    <p><?php echo jSont::playAudio($item->bible->audio); ?></p>
                    <p class="key">Link</p>
                    <p><?php echo $item->bible->link; ?></p>
                </div>
                <div class="clearfix clear"></div>
				<div class="bntRight">
					<a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=bibles&Itemid=' . $itemid); ?>" class="btn btn-xs">View All Bible Studies</a>
				</div>
			</div>

        <?php } ?>
            
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="Itemid" value="<?php echo $itemid; ?>" />
        <input type="hidden" name="id" value="<?php echo $item->id; ?>" />
        <input type="hidden" name="option" value="com_cpamanager" />
        <?php echo JHtml::_('form.token'); ?>
        </form>
    </div>
</div>
<?php echo jSont::footer(); ?>