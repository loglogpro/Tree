<?php
require ('Tree.php');

/**
 * List containing the information about the tree structure
 **/
$list = array(
        'First - 0' => array('id'     => 1,
                            'name'   => 'News',
                            'parent' => 0),

        'Second - 1' => array('id'     => 2,
                            'name'   => 'Mobile',
                            'parent' => 1),

        'Second - 2' => array('id'     => 7,
                            'name'   => 'Sports',
                            'parent' => 1),

        'Third - 2' => array('id'     => 3,
                            'name'   => 'Android',
                            'parent' => 2),

        'Third - 3' => array('id' => 4,
                            'name'   => 'IOS',
                            'parent' => 2),

        'First - 4' => array('id'     => 5,
                            'name'   => 'Interviews',
                            'parent' => 0),

        'Fourth - 5' => array('id'     => 6,
                              'name'   => 'Games',
                              'parent' => 4),

        'Fourth - 6' => array('id'     => 8,
                              'name'   => 'adventure',
                              'parent' => 6),
    );

//instantiate the class, passing the list as parameter
$tree = new \Utils\Tree($list);

//function building a html structure based on the data generated
function printTree($node) {

    if (!$node)
        return false;

    $return = "<ul>";
    foreach ($node as $k=>$v) {
        $return .= "<li>" . 
            $v['name'] . 
            (isset($v['children'])? printTree($v['children']) : false ).
            "</li>";
    }
    $return .= "</ul>";

    return $return;
}

echo printTree($tree);
