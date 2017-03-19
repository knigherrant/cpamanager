<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Location controller class.
 */
class CPAManagerControllerLocation extends JControllerForm
{

    function __construct() {
        $this->view_list = 'locations';
        parent::__construct();
    }
    
    function save($key = null, $urlVar = null) {
        parent::save($key, $urlVar);
        ?>
        <div style="text-align: center"><h3>Location Added Success</h3></div>
        <script>
            //window.parent.location.reload()
        </script>
        <?php
        die;
    }

}