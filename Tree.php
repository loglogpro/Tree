<?php
namespace Utils;

/**
 * Organize the a list in herarchical form
 *
 * @author Rafael Nexus
 **/
class Tree extends \RecursiveArrayIterator {

    /**
     * Property to hold the original raw value of the list
     *
     * @var array
     **/
    protected $_rawList;

    /**
     * Pointers to the whole tree, can access specific nodes by $_keyName
     *
     * @var array
     **/
    protected $_pointers;

    /**
     * Name of the key that contains the parent item information
     *
     * @var string
     **/
    protected $_parentName;

    /**
     * Name of the key that contains the key information
     *
     * @var string
     **/
    protected $_keyName;

    /**
     * Constructor
     *
     * @return void
     * @param array $list
     * @param mixed (string|integer) $keyName
     * @param mixed (string|integer) $parentName
     * @author Rafael Nexus <n3xu5.0@gmail.com>
     */
    public function __construct(Array $list, $keyName = 'id', $parentName = 'parent')
    {
        $this->_rawList = $list;
        $this->_keyName = $keyName;
        $this->_parentName = $parentName;

        parent::__construct($this->_organize());
    }

    /**
     * Organize the raw list and construct the hierarchy
     *
     * @return void
     * @author Rafael Nexus
     **/
    protected function _organize()
    {
        $pointers = array();
        $return = array();

        foreach ($this->_rawList as $key => $value) {

            //in case the keys are not found just continue to the next item
            if (!array_key_exists($this->_keyName, $value) || 
                !array_key_exists($this->_parentName, $value))
                continue;

            $id = $value[$this->_keyName];
            $parentId = $value[$this->_parentName];

            //create the key on the list of pointers
            if (!array_key_exists($id,$pointers))
                $pointers[$id] = $value;

            //if there is no parentId, is the only interaction with the actual return 
            //array
            if ($parentId == 0)
                $return[$id] =& $pointers[$id];
            else
                $pointers[$parentId]['children'][$id] =& $pointers[$id];
        }

        $this->_pointers = $pointers;
        return $return;
    }

    /**
     * Get all the pointers or a specific node by the key defined for _keyName
     *
     * @return void
     * @param mixed (string|integer) $keyName
     * @author Rafael Nexus <n3xu5.0@gmail.com>
     */
    public function getPointers($keyName = false)
    {
        return (isset($this->_pointers[$keyName]))?
                $this->_pointers[$keyName] : $this->_pointers;
    }

    /**
     * Return the raw list
     *
     * @return array
     * @author Rafael Nexus <n3xu5.0@gmail.com>
     */
    public function getRawList()
    {
        return $this->_rawList;
    }
}
