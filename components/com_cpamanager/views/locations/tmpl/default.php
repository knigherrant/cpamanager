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
<?php echo JST::toolbar(); ?>
<form action="<?php echo JRoute::_('index.php?option=com_cpamanager&view=locations'); ?>" method="post" name="adminForm" id="adminForm">
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

    <table class="table table-striped">
        <thead>
            <tr>
                <th width="1%">
                    <?php echo JHtml::_('grid.checkall'); ?>
                </th>
                <th width="80" class='left'>
				<?php echo JHtml::_('grid.sort',  'Featured', 'a.featured', $listDirn, $listOrder); ?>
				</th>
                
                             
				<th class="left">
					<?php echo JHtml::_('grid.sort',  'Name', 'a.name', $listDirn, $listOrder); ?>
				</th>

                                <th class="left">
					<?php echo JHtml::_('grid.sort',  'Address', 'a.address', $listDirn, $listOrder); ?>
				</th>
                                
				<th class="left">
					<?php echo JHtml::_('grid.sort',  'Phone', 'a.phone', $listDirn, $listOrder); ?>
				</th>

				<th class="left">
					<?php echo JHtml::_('grid.sort',  'Email', 'a.email', $listDirn, $listOrder); ?>
				</th>
                                <th class="left">
					<?php echo JHtml::_('grid.sort',  'Date', 'a.created', $listDirn, $listOrder); ?>
				</th>
				

                <?php if (isset($this->items[0]->state)) : ?>
                    <th width="5%">
                        <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
                    </th>
                <?php endif; ?>

                <?php if (isset($this->items[0]->id)) : ?>
                    <th width="1%" class="nowrap">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                    </th>
                <?php endif; ?>
            </tr>
        </thead>
        <tfoot>
            <?php
            if (isset($this->items[0])) {
                $colspan = count(get_object_vars($this->items[0]));
            } else {
                $colspan = 10;
            }
            ?>
            <tr>
                <td colspan="<?php echo $colspan ?>">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <?php
            foreach ($this->items as $i => $item) :
                $ordering = ($listOrder == 'a.ordering');
                $canCreate = $user->authorise('core.create', 'com_cpamanager');
                $canEdit = $user->authorise('core.edit', 'com_cpamanager');
                $canCheckin = $user->authorise('core.manage', 'com_cpamanager');
                $canChange = $user->authorise('core.edit.state', 'com_cpamanager');
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td data-field="" class="center">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td data-field="Featured">
                    <?php if($item->featured){ ?>
                                        <a href="#" onclick="return listItemTask('cb1','locations.unfeatured')" title="Toggle to change article state to 'Unfeatured'"></a>
                                        <a href="#" onclick="return listItemTask('cb<?php echo $i; ?>','locations.unfeatured')" class="btn btn-micro hasTooltip active" title="" data-original-title="Toggle featured status.">
                                            <span class="icon-featured"></span>
                                        </a>
                                    <?php }else{ ?>
                                        <a href="#" onclick="return listItemTask('cb<?php echo $i; ?>','locations.featured')" class="btn btn-micro hasTooltip" title="" data-original-title="Toggle featured status.">
                                            <span class="icon-unfeatured"></span>
                                        </a>
                                    <?php } ?>
                                </td>
                    
					<td data-field="Location Title">
					<?php if (isset($item->checked_out) && $item->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'locations.', $canCheckin); ?>
					<?php endif; ?>
					<?php if ($canEdit): ?>
						<a href="<?php echo JRoute::_('index.php?option=com_cpamanager&task=location.edit&id=' . (int) $item->id); ?>">

							<?php echo $this->escape($item->name); ?>
						</a>
					<?php else: ?>
						<?php echo $this->escape($item->name); ?>
					<?php endif; ?>
					</td>

                                        <td data-field="Address">
						<?php echo $item->address; ?>
					</td>
                                        <td data-field="Phone">
						<?php echo $item->phone; ?>
					</td>
                                        
					<td data-field="Email">
						<?php echo $item->email; ?>
					</td>

					<td data-field="Date">
						<?php echo $item->created; ?>
					</td>

					
                                    <?php if (isset($this->items[0]->state)) { ?>
                        <td class="center" data-field="Published">
                            <?php echo JHtml::_('jgrid.published', $item->state, $i, 'staffs.', $canChange, 'cb'); ?>
                        </td>
                    <?php } ?>
                   
                    <?php if (isset($this->items[0]->id)) { ?>
                        <td class="center" data-field="ID">
                            <?php echo (int) $item->id; ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        </div>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>