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
JHtml::_('behavior.modal', 'a.modal');
?>
<script type="text/javascript">
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

</script>

<div id="CPAManagerContent">
    <div id="event-view" class="bodyContents">
        <h3><?php echo $item->subject; ?></h3>
        <div class="dateEvent">
            <p><span><b>Date Start : </b></span><span><?php echo jSont::format($item->date_start); ?></span></p>
            <p><span><b>Date End : </b></span><span><?php echo jSont::format($item->date_end); ?></span></p>
        </div>
        <p><b>Category : </b><?php echo $item->category; ?></p>
        <div><?php echo $item->description; ?></div>
        <div class="imageEvent">
            <?php if($item->image1){ $img1 =  JURI::root() . $item->image1?><p><a class="modal" href="<?php echo  $img1; ?>"  rel="{handler: 'iframe', size: {x:600, y:600}}"><img src="<?php echo $img1; ?>" alt="image" /></a></p> <?php } ?>
            <?php if($item->image2){ $img2 =  JURI::root() . $item->image2?><p><a class="modal" href="<?php echo  $img2; ?>"  rel="{handler: 'iframe', size: {x:600, y:600}}"><img src="<?php echo $img2; ?>" alt="image" /></a></p> <?php } ?>
            <?php if($item->image3){ $img3 =  JURI::root() . $item->image3?><p><a class="modal" href="<?php echo  $img3; ?>"  rel="{handler: 'iframe', size: {x:600, y:600}}"><img src="<?php echo $img3; ?>" alt="image" /></a></p> <?php } ?>
			<div class="clr clearfix"></div>
		</div>
        <div class="infoEvent">
            <p><span><b>Location : </b></span><span><?php echo ($item->location); ?></span></p>
			<div class="phone_adress">
				<p><span><b>Phone : </b></span><span><?php echo ($item->phone); ?></span></p>
				<p><span><b>Address : </b></span><span><?php echo ($item->address); ?></span></p>
			</div>
            <p><span><b>Contact : </b></span><span><?php echo ($item->contact); ?></span></p>
        </div>
        
        <div>
            <div class="mapEvent">
             
                    <?php 
                            $cfg = array(
                                    'id' => $item->id,
                                    'address' => $item->address .', '. $item->location,
                                    'lat' => $item->latitude,
                                    'lng' => $item->longitude,
                            );
                            echo jSont::googleMap($cfg); 
                    ?>
             
            </div>
        </div>
        
    </div>
</div>
<?php echo jSont::footer(); ?>



