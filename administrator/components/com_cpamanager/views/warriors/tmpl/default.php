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
JHTML::_('script', 'system/multiselect.js', false, true);
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_cpamanager/assets/css/cpamanager.css');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = $user->authorise('core.edit.state', 'com_cpamanager');
$saveOrder = $listOrder == 'a.ordering';
?>
<?php echo jSont::menuSiderbar(); ?>
<form action="<?php echo JRoute::_('index.php?option=com_cpamanager&view=warriors'); ?>" method="post" name="adminForm" id="adminForm">
    <?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
    <?php else : ?>
        <div id="j-main-container">
    <?php endif;?>
        <div id="filter-bar" class="btn-toolbar">
                <div class="filter-search btn-group pull-left">
                        <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('Search'); ?>" />
                </div>
            <div class="btn-group pull-right hidden-phone">
                        <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
                        <?php echo $this->pagination->getLimitBox(); ?>
                    </div>
                <div class="btn-group pull-left">
                        <button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><span class="icon-search"></span></button>
                        <button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><span class="icon-remove"></span></button>
                </div>
        </div>
        <div class="clr"> </div>
			<div class="listWarriors">
				<?php foreach ($this->items as $i => $item) : ?>
				<?php
					$row = $i%2;
				?>
					
				   <div class="witem item-<?php echo $row; ?>">
					<?php if($row == 0){ ?>
						<div class="prayAvatar">
							<p class="praying-key">Prayring</p>
							<p class="praying-number"><?php echo $item->jCount; ?></p>
							<div class="mini-avatar"><img src="<?php echo jSont::getAvatar($item->avatar); ?>" /></div>
						</div>
						<div class="prayInfo callouts">
							<div class="callouts--left">
								<p class="praying"><?php echo $item->prayingfor; ?></p>
								<div><?php echo $item->praying_desc; ?></div>
							</div>
						</div>
					<?php }else{ ?>
						<div class="prayInfo callouts">
							<div class="callouts--right">
								<p class="praying"><?php echo $item->prayingfor; ?></p>
								<div><?php echo $item->praying_desc; ?></div>
							</div>
						</div>
						<div class="prayAvatar">
							<p class="praying-key">Prayring</p>
							<p class="praying-number"><?php echo $item->jCount; ?></p>
							<div class="mini-avatar"><img src="<?php echo jSont::getAvatar($item->avatar); ?>" /></div>
						</div>
					<?php } ?>
					<div class="clr clear clearfix"> </div>
				   </div>
				<?php endforeach; ?>
			</div>
    
        </div>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>