<?php
/**
 * @version     16.5.5
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.modeladmin');
/**
 * Methods supporting a list of CPAManager records.
 */
class CPAManagerModelConfigs extends JModelAdmin {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    public function getTable($type = 'Config', $prefix = 'CPAManagerTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_cpamanager.config', 'config', array('control' => 'jform', 'load_data' => $loadData));
                
        
		if (empty($form)) {
			return false;
		}
              
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_cpamanager.edit.config.data', array());

		if (empty($data)) {
			$data = $this->getItem();
            
		}
		return $data;
	}
    
    
    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'a.*'
                )
        );
        $query->from('`#__cpamanager_config` AS a');

        return $query;
    }

    public function getItem($pk = 1) {
        $item = parent::getItem($pk);
        return $item;
    }

    public function save($data){
        //$post  = JFactory::getApplication()->input->get('post');
        
        $post = JRequest::get('post');
        $post['params'] = JFactory::getApplication()->input->get('params', '', 'raw');
        $post['params'] = json_encode($post['params']);
        $post['notify_user'] = $_POST['notify_user'];
        $post['notify_bible'] = $_POST['notify_bible'];
        $post['notify_event'] = $_POST['notify_event'];
        $post['notify_request'] = $_POST['notify_request'];
        $post['notify_for'] = $_POST['notify_for'];
        $post['notify_vip'] = $_POST['notify_vip'];

        $table = JTable::getInstance('config','CPAManagerTable');
        $table->load(1);
        $table->bind($post);
        $table->store();
    }

}
