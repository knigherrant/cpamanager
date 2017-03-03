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
class CPAManagerModelWarriors extends JModelList {

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
                'ordering', 'a.ordering',
                'subject', 'a.subject',
                'location', 'a.location',
                'date', 'a.date',
                'latitude', 'a.latitude',
                'longitude', 'a.longitude',
                'featured', 'a.featured',
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

        

        // Load the parameters.
        $params = JComponentHelper::getParams('com_cpamanager');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'desc');
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
		/*
        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );
        $query->from('`#__cpamanager_warriors` AS a');
        $query->select('u.name as user');
        $query->join( 'LEFT', '`#__users` AS u ON u.id=a.userid');
        $query->select('uu.name as prayforname');
        $query->join( 'LEFT', '`#__users` AS uu ON uu.id=a.prayfor');
        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('LOWER(a.praying_desc) LIKE ' . $search . ' OR LOWER(u.name) LIKE ' . $search);
            }
        }
        $userid = JFactory::getApplication()->input->getInt('userid');
		if($userid) $query->where('a.userid=' . $userid);

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
		*/
		$query->select('a.*,u.name as praywarrior, COUNT(a.userid) as jCount, p.avatar')->from('#__cpamanager_warriors as a '
                        . ' left join #__users as u ON u.id=userid '
						. ' left join #__cpamanager_profiles as p ON p.userid=a.userid'
						);
                
                $search = $this->getState('filter.search');
                if (!empty($search)) {
                    if (stripos($search, 'id:') === 0) {
                        $query->where('a.id = ' . (int) substr($search, 3));
                    } else {
                        $search = $db->Quote('%' . $db->escape($search, true) . '%');
                        $query->where('LOWER(a.praying_desc) LIKE ' . $search . ' OR LOWER(u.name) LIKE ' . $search);
                    }
                }
                $userid = JFactory::getApplication()->input->getInt('userid');
                if($userid) $query->where('a.userid=' . $userid);
				$query->order('a.id desc');
				$query->group('u.id');
		return $query;
    }

    public function getItems() {
        $db = JFactory::getDbo();
		$items = parent::getItems();
		$lists = array();
		foreach($items as &$item){
			$new = $db->setQuery('SELECT a.*, u.name as prayingfor FROM #__cpamanager_warriors as a 
							LEFT JOIN #__users as u ON u.id=a.prayfor 
							WHERE a.userid=' . $item->userid .' ORDER BY a.id desc ')->loadObject();
			$item->praying_desc = $new->praying_desc;
			$item->id = $new->id;
			$item->prayingfor = $new->prayingfor;
			$lists[$item->id] = $item;
		}
		krsort($lists);
		return $items;
    }

}
