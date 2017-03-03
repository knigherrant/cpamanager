<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomlavi <info@joomlavi.com> - http://www.joomlavi.com
 */

defined('_JEXEC') or die;
$items = $this->items;
$itemid = JFactory::getApplication()->input->getInt('Itemid');
?>
<div id="CPAManagerContent">
    <div id="warriors-content">
        <?php echo jSont::showProfileHtml(); ?>
        <div class='warriors bodyContents'>
            <legend><?php echo JText::_('Prayer Warriors'); ?></legend>
            <!--<p class="addnew"><a class="btn btn-xs" href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=warrior&layout=edit&Itemid='.$itemid); ?>"><?php echo JText::_('Prayer Request'); ?></a></p>-->
            <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&view=warriors&Itemid='.$itemid); ?>" method="post" name="adminForm" id="adminForm">
                <div id="j-main-container">
                    <div id="filter-bar" class="btn-toolbar">
                            <div class="filter-search btn-group pull-left">
                                    <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('Search'); ?>" />
                            </div>
                            <div class="btn-group pull-left">
                                    <button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><span class="icon-search"></span></button>
                                    <button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><span class="icon-remove"></span></button>
                            </div>
                    </div>
                    <div class="clr clear clearfix"> </div>

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
                    <?php echo JHtml::_('form.token'); ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo jSont::footer(); ?>