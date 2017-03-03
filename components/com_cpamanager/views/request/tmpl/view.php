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
$itemid = JFactory::getApplication()->input->getInt('Itemid');
?>
<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'request.cancel') {
                    Joomla.submitform(task, document.getElementById('request-form'));
                }
                else{
                    
                    if (task != 'request.cancel' && document.formvalidator.isValid(document.id('request-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('request-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>

<div id="CPAManagerContent">
    <?php echo jSont::showProfileHtml(); ?>
    <div id="request-view" class="bodyContents">
        <label>Pray for User</label>
		
		<div class="itemRequest">
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
		
        <div class="commentRequest">
            <p>Prayer Comments</p>
            <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="request-form" class="form-validate">
                <div class="form-horizontal row-fluid">
                     <div class="jSontTextarea">
						<textarea placeholder="<?php echo JText::_('Comment');?>" name="comment"></textarea>
						<div class="bntRight">
							<button type="button" class="btn" onclick="Joomla.submitbutton('request.saveComment')">
									<span class="icon-ok"></span><?php echo JText::_('JSAVE') ?>
							</button>
						</div>
					 </div>
                </div>

             
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="Itemid" value="<?php echo $itemid; ?>" />
                <input type="hidden" name="item_id" value="<?php echo $item->id; ?>" />
                <input type="hidden" name="option" value="com_cpamanager" />
                <?php echo JHtml::_('form.token'); ?>
                <div class="clr"></div>
            </form>

            <div class="listComments">
                <?php $lists = jSont::getComments($item->id, 'request'); ?>
                <?php if($lists){ ?>
                    <h5 class="titleComment"><?php echo JText::_('Prayer Comments'); ?></h5>
                    <ul>
                    <?php foreach ($lists as $l){ ?>
                        <li class="lineButtom">
                            <!--<p class="cTitle"><?php echo $l->title; ?></p>-->
                            <p class="author"><span class="uName"><?php echo $l->name; ?></span><span class="dateS"><?php echo jSont::format($l->created); ?></span></p>
                            <div class="cContent"><?php echo $l->comment; ?></div>
                        </li>
                    <?php } ?>
                    </ul>
                <?php } ?>
            </div>
            
        </div>
    </div>
</div>
<?php echo jSont::footer(); ?>



