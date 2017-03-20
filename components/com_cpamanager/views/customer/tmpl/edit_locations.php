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
$user = JFactory::getUser();
?>
<link rel="stylesheet" type="text/css" href="<?php echo JUri::root();?>components/com_cpamanager/assets/css/jquery.dataTables.css">
<script type="text/javascript" language="javascript" src="<?php echo JUri::root();?>components/com_cpamanager/assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" class="init">
    jQuery(document).ready(function($) {
            jQuery('#listLocation').DataTable( {
                    "order": [[ 3, "desc" ]]
            } );
            
            $('.selectLocation').click(function(){
                var a = $(this),
                    location = $.parseJSON(a.next().val() || '{}')
                ;
                $('#jLong').val(location.lng);
                $('#jLat').val(location.lat);
                $('#jform_location_id').val(a.data('id'));
                
                jSont.initialize(location);
                
                $('html, body').animate({
                      scrollTop: $(".jsont").offset().top
                 }, 2000);
                 return false;
            });
    } );
</script>

<table id="listLocation" class="table table-striped">
    <thead>
        <tr>
            <th width="80" class='left'> Featured </th>
            <th class="left"> Name </th>
            <th class="left"> Address </th>
            <th class="left"> Phone </th>
            <th class="left"> Email </th>
            <!--<th class="left"> Date </th>-->
            <?php if (isset($this->items[0]->id)) : ?>
                <th width="1%" class="nowrap"> ID </th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->items as $i => $item) :
            $canCreate = $user->authorise('core.create', 'com_cpamanager');
            $canEdit = $user->authorise('core.edit', 'com_cpamanager');
            $canCheckin = $user->authorise('core.manage', 'com_cpamanager');
            $canChange = $user->authorise('core.edit.state', 'com_cpamanager');
            $location = array(
                'lat' => $item->latitude,
                'lng' => $item->longitude,
                'address' => $item->address,
                'infotext' => $item->address
            )
            ?>
            <tr class="row<?php echo $i % 2; ?>">
                <td data-field="Featured">
                <?php if($item->featured){ ?>
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
                    <a data-id="<?php echo $item->id; ?>" class="selectLocation" href="javascript:void(0)">
                        <?php echo $this->escape($item->name); ?>
                    </a>
                    <textarea id="location-<?php echo $item->id; ?>" style="display:none"><?php echo json_encode($location); ?></textarea>
                </td>
                <td data-field="Address"> <?php echo $item->address; ?> </td>
                <td data-field="Phone"> <?php echo $item->phone; ?> </td>
                <td data-field="Email"> <?php echo $item->email; ?> </td>
                <!--<td data-field="Date"> <?php echo $item->created; ?> </td>-->
                <?php if (isset($this->items[0]->id)) { ?>
                    <td class="center" data-field="ID">
                        <?php echo (int) $item->id; ?>
                    </td>
                <?php } ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>