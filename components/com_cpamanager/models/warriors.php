<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_CPAManager
 * @author     Joomlavi <info@joomlavi.com>
 * @copyright  2016 Joomlavi
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of CPAManager records.
 *
 * @since  1.6
 *
 */
class CPAManagerModelWarriors extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see        JController
	 * @since      1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				
			);
		}

		parent::__construct($config);
	}


        protected function populateState($ordering = null, $direction = null) {
            // Initialise variables.
            $app = JFactory::getApplication();

            // Load the filter state.
            $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
            $this->setState('filter.search', $search);

            $category = $app->getUserStateFromRequest($this->context . '.filter.category', 'category', '', 'string');
            $this->setState('filter.category', $category);

            // List state information.
            parent::populateState('a.id', 'asc');
        }
        
        
        
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return    JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		$db	= $this->getDbo();
		$query	= $db->getQuery(true);
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
                $userid = JFactory::getApplication()->input->getInt('id');
                if($userid) $query->where('a.userid=' . $userid);
				$query->order('a.id desc');
				$query->group('u.id');
		return $query;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed An array of data items on success. False on failure.
	 */
	public function getItems()
	{
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
