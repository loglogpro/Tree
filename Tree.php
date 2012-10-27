<?php
namespace Utils;

/**
 * Organize the a list in herarchical form
 *
 * @author Rafael Nexus
 **/
class Tree {

    /**
     * Property to hold the original raw value of the list
     *
     * @var array
     **/
    protected $_rawTree;

    /**
     * Organized categories in tree
     *
     * @var array
     **/
    protected $_tree;

    /**
     * Name of the key that contains the parent item information
     *
     * @var string
     **/
    protected $_parentName = 'parent';

    /**
     * Name of the key that contains the key information
     *
     * @var string
     **/
    protected $_keyName = 'id';

    /**
     * Organize the raw tree and construct the hierarchy
     *
     * @return associative array
     * @param integer $parent 
     * @author Rafael Nexus
     **/
    protected function _organize($parent = 0)
    {
        //gets all the children from the raw tree
        $selectedChildren = $this->_getChildren($parent);

        $children = array();

        foreach ($selectedChildren as $key => $cat)
            $children[$cat[$this->_keyName]] = 
                array('index'    => $key,
                      'content'  => $cat,
                      'children' => $this->_organize($cat[$this->_keyName]));

        return $children; 
    }

    /**
     * Select the children from the raw tree
     *
     * @return associative array
     * @parent string | integer $parent
     * @author Rafael Nexus
     **/
    protected function _getChildren($parent)
    {
        $selectedChildren = array();
        foreach ($this->_rawTree as $k=>$v) 
            if ($v[$this->_parentName] == $parent)
                $selectedChildren[$k] = $v;

        return $selectedChildren;
    }

    /**
     * Simple helper to output the tree based on a provided template
     *
     * @return string
     * @param string $template
     * @param array $context
     * @author Rafael Nexus
     **/
    public function printTree($template, $context = array())
    {
        if ($context === array())
            $context = $this->_tree;

        $pattern = '/\%([a-z0-9]+)/i';
        preg_match_all($pattern, $template, $matches);
        $search = $matches[0];              
        $matches = array_fill_keys($matches[1],'');
        $children = '';

        foreach ($context as $key => $value) {

            $replace = array_merge(
                $matches,
                array_intersect_key($value['content'], $matches)
            ); 

            $search[] = '%_callback'; 
            $replace[] = (!empty($value['children']))?
                $this->printTree($template,$value['children']) : false;

            $children .= str_replace($search,$replace,$template);
        }

        return $children; 
    }

    /**
     * Set the raw list
     *
     * @return void
     * @param array $list
     * @author Rafael Dias
     **/
    public function setTree($treeList)
    {
        if (empty($treeList) || !is_array($treeList)) {
            throw new \Exception(__FUNCTION__ . " is expecting array, and " . gettype($treeList) . " given" );
        }

        //set the raw categories list
        $this->_rawTree = $treeList;
        //keep the organized tree
        $this->_tree = $this->_organize();    
    }

    /**
     * Get the organized tree
     *
     * @return array
     * @author Rafael Nexus
     **/
    public function getTree()
    {
        return $this->_tree;        
    }

    /**
     * Get the keyName value
     *
     * @return string
     * @author Rafael Nexus
     **/
    public function getKeyName()
    {
        return $this->_keyName;
    }

    /**
     * Get the parentName value
     *
     * @return string
     * @author Rafael Nexus
     **/
    public function getParentName()
    {
        return $this->_parentName;
    }

    /**
     * set the parentName value
     *
     * @return void
     * @param string $parentName
     * @author Rafael Nexus
     **/
    public function setParentName($parentName) 
    {
        $this->_parentName = $parentName;
    }

    /**
     * Set the keyName value
     *
     * @return void
     * @param string $keyName
     * @author Rafael Nexus
     **/
    public function setKeyName($keyName) 
    {
        $this->_keyName = $keyName;
    }
}
