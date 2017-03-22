<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of CPAManager records.
 */
class CPAManagerModelInvoices extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'title', 'a.title',
                'company', 'a.company',
                'cpaid', 'a.cpaid', 'cpa',
                'title', 'a.title',
                'date', 'a.date',
 
                'state', 'a.state',
                'publish_on', 'a.publish_on',
                'unpublish_on', 'a.unpublish_on',
                'created', 'a.created',
                'created_by', 'a.created_by', 'created_by_name'
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        $category = $app->getUserStateFromRequest($this->context . '.filter.category', 'filter_category', '', 'string');
        $this->setState('filter.category', $category);

        $owner = $app->getUserStateFromRequest($this->context . '.filter.owner', 'filter_owner', '', 'string');
        $this->setState('filter.owner', $owner);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_cpamanager');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
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
        $query->from('`#__cpamanager_invoices` AS a');

        // Join over the user field 'created_by'
		$query->select('created_by.name AS created_by_name');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
$query->select('CONCAT(c.firstname, " " ,c.midname, " " ,c.lastname) as cpa ' );
        $query->join( 'LEFT', '`#__cpamanager_cpas` AS c ON c.id=a.cpaid');
      
     
        // Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

        // Filter by category
        $category = $this->getState('filter.category');
        if (is_numeric($category)) {
            $query->where('a.catid = ' . (int) $category);
        }

        $query->where('created_by = ' . JFactory::getUser()->id);
        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.title LIKE '.$search.' OR a.alias LIKE '.$search.' )');
            }
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $db = JFactory::getDbo();
        if($items = parent::getItems()) foreach($items as $item){
            /*
            $db->setQuery('SELECT userid, signed FROM #__signaturedoc_user_signatures WHERE docid='.$item->id);
            $signs = $db->loadObjectList();
            $item->signs = '';
            if($signs){
                $signed = 0;
                foreach($signs as $sign) if($sign->signed) $signed ++;
                $item->signs = $signed.'/'.count($signs);
            }
             * 
             */
        }
        return $items;
    }

}
