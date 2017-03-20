<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_CPAManager
 * @author     Joomlavi <info@joomlavi.com>
 * @copyright  2016 Joomlavi
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Class frontend
 *
 * @since  1.6
 */

require_once JPATH_ADMINISTRATOR.'/components/com_cpamanager/helpers/cpamanager.php';
class JST extends jSont{
    
   
    public static function toolbar($task = '',$bnt = ''){
        if(!$task) return;
            ?>
            <div id="btn-toolbar" class="btn-toolbar">
                <?php if($bnt){ ?>
                    <button onclick="Joomla.submitbutton('<?php echo $task; ?>.add')" class="btn btn-small btn-success">
                        <span class="icon-new icon-white"></span> New
                    </button>
                <?php } else{ ?>
                    <div class="btn-group">
                            <button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('<?php echo $task;?>.save')">
                                    <span class="icon-ok"></span><?php echo JText::_('JSAVE') ?>
                            </button>
                    </div>
                    <?php if($task !=='cpa'){ ?>
                    <div class="btn-group">
                            <button type="button" class="btn" onclick="Joomla.submitbutton('<?php echo $task;?>.cancel')">
                                    <span class="icon-cancel"></span><?php echo JText::_('JCANCEL') ?>
                            </button>
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php
        }
    public static function cpaLeft(){
        echo self::Menu();
        echo self::logo();
        echo self::userInfo();
        echo self::logout();
    }    
    public static function isCom(){
        return true;
    }
    
     public static function logout(){
        ?>
        <form id="jkLogout" action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post">
                <input type="hidden" name="return" value="<?php echo base64_encode('index.php?option=com_users&view=login'); ?>" />
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="user.logout" />
                <?php echo JHtml::_('form.token'); ?>
        </form>
        <a class="jk-logout" href="javascript:void(0)">[Log Out]</a>
        <script>
                jQuery(function($){
                        $('a.jk-logout').click(function(){
                            $('#jkLogout').submit();
                        });
						return false;
                })
        </script>
        <?php
    }
    
    public static function Menu($view = ''){
        
        $input = JFactory::getApplication()->input;
        $Itemid = $input->getInt('Itemid', 0);
        if(!$view) $view = $input->getString('view', 'frontend');
        $customers = array('customers','customer','invoices','invoice','expenses','expense','receipts','receipt','mileages','mileage');
        ob_start();
        ?>
        <div id="menu">
            <ul>
                <li class="homepage <?php if($view=='homepage') echo 'active';?>"><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=homepage&Itemid='.$Itemid); ?>"><?php echo JText::_('Home'); ?></a></li>
                <li class="profiles <?php if($view=='cpa') echo 'active';?>"><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=cpa&Itemid='.$Itemid); ?>"><?php echo JText::_('Profile'); ?></a></li>
                <li class="customers <?php if(in_array($view, $customers)) echo 'active';?>"><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=customers&Itemid='.$Itemid); ?>"><?php echo JText::_('Customers'); ?></a></li>
                <li class="taxreturns <?php if($view=='taxreturns') echo 'active';?>"><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=taxreturns&Itemid='.$Itemid); ?>"><?php echo JText::_('Tax Returns'); ?></a></li>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }
    
    
     public static function logo(){
         $input = JFactory::getApplication()->input;
        $Itemid = $input->getInt('Itemid', 0);
        return '<a id="logo" alt="Dynamic Media" href="'. JRoute::_('index.php?option=com_cpamanager&view=homepage&Itemid='.$Itemid) .'">Dynamic Media</a>';
    }
    
    public static function userInfo($userid = 0){
        ob_start();
        echo '<div id="userInfo">';
        if($cpa = self::isCPA($userid)){
            ?>
            <div id="uinfo">
                <h4 class="key"><?php echo $cpa->company; ?></h4>
                <p class="key">Contact</p> <p class="value"><?php echo $cpa->cpa; ?></p>
                <p class="key">Address 1</p> <p class="value"><?php echo $cpa->address1; ?></p>
                <p class="key">Address 2</p> <p class="value"><?php echo $cpa->address2; ?></p>
            </div>

            <div id="ucontact">
                <table width="100%">
                    <tr>
                        <td class="key">City</td> <td class="key">State</td> <td class="key">Zip Code</td>
                    </tr>
                    <tr>
                        <td class="value"><?php echo $cpa->city; ?></td> <td class="value"><?php echo $cpa->state; ?></td> <td class="value"><?php echo $cpa->zip; ?></td>
                    </tr>
                </table>
                <?php
                $cpainfo = array(
                    'phone' => 'Phone',
                    'cell_phone' => 'Cell Phone',
                    'fax' => 'Fax',
                    'email' => 'Email',
                    'url' => 'Url',
                    );
                foreach ($cpainfo as $k=>$t){ ?>
                    <p class="key"><?php echo $t; ?></p> <p class="value"><?php echo $cpa->$k; ?></p>
                <?php } ?>
            </div>
                
            <?php
        }else if($customer = self::isCustomer($userid)){
            ?>

            <?php
        }
        echo '</div>';
        return ob_get_clean();
    }
    
    public static function isCustomer($userid = 0){
        if(!$userid) $userid = JFactory::getUser ()->id;
        if(!$userid) return false;
        static $customer;
        if(!isset($cpa[$userid])){
            $db = JFactory::getDbo();
            $customer[$userid] = $db->setQuery('SELECT *, CONCAT(firstname, " " ,midname, " " ,lastname) as customer FROM #__cpamanager_customers WHERE userid=' . $userid)->loadObject();
        }
        return $customer[$userid];
    }
    
    public static function isCPA($userid = 0){
        if(!$userid) $userid = JFactory::getUser ()->id;
        if(!$userid) return false;
        static $cpa;
        if(!isset($cpa[$userid])){
            $db = JFactory::getDbo();
            $cpa[$userid] = $db->setQuery('SELECT *, CONCAT(firstname, " " ,midname, " " ,lastname) as cpa FROM #__cpamanager_cpas WHERE userid=' . $userid)->loadObject();
        }
        return $cpa[$userid];
    }
    
    public static function header(){
        if(self::isCom()){
            echo '<div id="cpaMain" class="">';
            echo '<div class="jMain span12">';
            echo '<div id="cpaLeft" class="span3">';
            echo self::cpaLeft();
            echo '</div>';
            echo '<div id="mainContent" class="span9">';
        }
    }
    
    public static function footer(){
        if(self::isCom()){
            echo '</div></div></div>';
        }
    }
    
    public static function tabsMenu($v =''){
        $input = JFactory::getApplication()->input;
        $Itemid = $input->getInt('Itemid', 0);
        if(!$v) $v = $input->getString('view');
        ?>
        <ul class="nav nav-tabs" id="myTabTabs">
            <li class="<?php if($v == 'customers' || $v =='customer') echo 'active'; ?>"><a  href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=customers&Itemid='.$Itemid); ?>" >Customers</a></li>
            <li class="<?php if($v == 'invoices' || $v =='invoice') echo 'active'; ?>"><a  href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=invoices&Itemid='.$Itemid); ?>"  >Invoices</a></li>
            <li class="<?php if($v == 'expenses' || $v =='expense') echo 'active'; ?>"><a  href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=expenses&Itemid='.$Itemid); ?>" >Expenses</a></li>
            <li class="<?php if($v == 'receipts' || $v =='receipt') echo 'active'; ?>"><a  href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=receipts&Itemid='.$Itemid); ?>" >Receipts</a></li>
            <li class="<?php if($v == 'mileages' || $v =='mileage') echo 'active'; ?>"><a  href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=mileages&Itemid='.$Itemid); ?>"  >Mileages</a></li>
                        
        </ul>
        <?php
    }
    
        
}