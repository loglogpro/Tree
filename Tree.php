<?php
namespace Utils;

/**
 * Organiza a lista proveniente do banco de dados representando a hierarquia
 * definida pelo item parent 
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
     * Constructor 
     *
     * @return void
     * @param array $categories
     * @author Rafael Nexus
     **/
    public function __construct(array $treeList) 
    {
        //set the raw categories list
        $this->_rawTree = $treeList;
        //keep the organized tree
        $this->_tree = $this->_organize();
    }

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
     * @parent string|integer $parent
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
     * Output the tree based on a provided template
     *
     * @return void
     * @param string $template
     * @author Rafael Nexus
     **/
    public function printTree($template, $context = false)
    {
        if ($context === false)
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

    public function getTree()
    {
        return $this->_tree;        
    }

    public function getKeyName()
    {
        return $this->_keyName;
    }

    public function getParentName()
    {
        return $this->_parentName;
    }

    public function setParentName($parentName) 
    {
        $this->_parentName = $parentName;
    }

    public function setKeyName($keyName) 
    {
        $this->_keyName = $keyName;
    }
}
