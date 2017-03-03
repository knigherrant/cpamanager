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
<?php echo jSont::menuSiderbar(); ?>
<div id="CPAManagerContent">
    <div id="event-view">
        <h3><?php echo $item->subject; ?></h3>
        <div class="dateEvent">
            <p><span>Date Start: </span><span><?php echo jSont::format($item->date_start); ?></span></p>
            <p><span>Date End: </span><span><?php echo jSont::format($item->date_end); ?></span></p>
        </div>
        <p>Category : <?php echo $item->category; ?></p>
        <div><?php echo $item->description; ?></div>
        <div class="imageEvent">
            <?php if($item->image1){ ?><p><img src="<?php echo JURI::root() . $item->image1; ?>" alt="image" /></p> <?php } ?>
            <?php if($item->image2){ ?><p><img src="<?php echo JURI::root() . $item->image2; ?>" alt="image" /></p> <?php } ?>
            <?php if($item->image3){ ?><p><img src="<?php echo JURI::root() . $item->image3; ?>" alt="image" /></p> <?php } ?>
        </div>
        <div class="infoEvent">
            <p><span>Location: </span><span><?php echo ($item->location); ?></span></p>
            <p><span>Phone: </span><span><?php echo ($item->phone); ?></span></p>
            <p><span>Address: </span><span><?php echo ($item->address); ?></span></p>
            <p><span>Contact: </span><span><?php echo ($item->contact); ?></span></p>
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




