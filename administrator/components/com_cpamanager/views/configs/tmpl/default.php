<?php
/**
 * @version     16.5.5
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
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . 'components/com_cpamanager/assets/js/json2.js');
$doc->addScript(JUri::base() . 'components/com_cpamanager/assets/js/jsconfigs.js');
?>
<script type="text/javascript">
    Joomla.submitbutton = function(task){
        if (task == 'configs.cancel') {
            Joomla.submitform(task, document.getElementById('configs-form'));
        }
        else {

            if (task != 'configs.cancel' && document.formvalidator.isValid(document.id('configs-form'))) {
                jvConfigs.setValueItems('bibleCategories');
                jvConfigs.setValueItems('eventCategories');
                jvConfigs.setValueItems('prayerCategories');
                Joomla.submitform(task, document.getElementById('configs-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>
<?php echo jSont::menuSiderbar(); ?>
<div class="signaturedoc">
    <form action="<?php echo JRoute::_('index.php?option=com_cpamanager')?>" method="post" enctype="multipart/form-data" name="adminForm" id="configs-form" class="form-validate dam-dashboad">
        <?php if(!empty($this->sidebar)): ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>
        <div id="j-main-container" class="span10">
        <?php else : ?>
        <div id="j-main-container">
            <?php endif;?>
            <div class="row-fluid form-horizontal" >
                <div id="addCategories" class="span12">
                    <div id="bibleCategory" class="span4">
                        <legend>Create Bible Study Categories</legend>
                            <div id="bibleCategories"></div>
                            <textarea style="display:none" class="bibleCategories" name="categories_bible"><?php echo $this->item->categories_bible; ?></textarea>
                            <input type="button" name="button" data-id="bibleCategories" class="btn btn-small btn-success addItem button-hero" value="Add">
                     </div>  
                    <div id="eventCategory" class="span4">
                        <legend>Create Event Categories</legend>
                            <div id="eventCategories"></div>
                            <textarea style="display:none" class="eventCategories" name="categories_event"><?php echo $this->item->categories_event; ?></textarea>
                            <input type="button" name="button" data-id="eventCategories" class="btn btn-small btn-success addItem button-hero" value="Add">
                     </div>        
                    <div id="prayerCategory" class="span4">
                        <legend>Create Prayer Categories</legend>
                            <div id="prayerCategories"></div>
                            <textarea style="display:none" class="prayerCategories" name="categories_prayer"><?php echo $this->item->categories_prayer; ?></textarea>
                            <input type="button" name="button" data-id="prayerCategories" class="btn btn-small btn-success addItem button-hero" value="Add">
                     </div>        
                </div>
                <div class="clearfix"></div>
                <br/>
                
                <div class="control-group">
                  <ul class="nav nav-tabs" id="myTabTabs">
                        <li class="active"><a  href="#users" data-toggle="tab" >Users</a></li>
                        <li><a  href="#bible" data-toggle="tab" >Bible Study</a></li>
                        <li><a  href="#events" data-toggle="tab" >Events</a></li>
                        <li><a  href="#request" data-toggle="tab" >Prayer Request</a></li>
                        <li><a  href="#for" data-toggle="tab" >Prayer For</a></li>
                </ul>
                    <div id="myTabContent" class="tab-content">
                        <div id="users" class="tab-pane active">
                             <?php echo JFactory::getEditor()->display( 'notify_user', $this->item->notify_user, '100%', '200', '20', '20'); ?>
                        </div>
                        <div id="bible" class="tab-pane">
                             <?php echo JFactory::getEditor()->display( 'notify_bible', $this->item->notify_bible, '100%', '200', '20', '20'); ?>
                        </div>
                        <div id="events" class="tab-pane">
                             <?php echo JFactory::getEditor()->display( 'notify_event', $this->item->notify_event, '100%', '200', '20', '20'); ?>
                        </div>
                        <div id="request" class="tab-pane">
                             <?php echo JFactory::getEditor()->display( 'notify_request', $this->item->notify_request, '100%', '200', '20', '20'); ?>
                        </div>
                        <div id="for" class="tab-pane">
                             <?php echo JFactory::getEditor()->display( 'notify_for', $this->item->notify_for, '100%', '200', '20', '20'); ?>
                        </div>
                    </div>
                </div>
                
                <br/>
                <div class="control-group">
                    <h5><?php echo JText::_('Vip Update');?></h5>
                                <?php echo JFactory::getEditor()->display( 'notify_vip', $this->item->notify_vip, '100%', '200', '20', '20'); ?>
                           
                </div>
				
                 <br/>
                <input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>

            </div>
        </div>
    </form>
</div>

<style>
    #import_email_body_ifr{
        height: 250px !important;
    }
</style>