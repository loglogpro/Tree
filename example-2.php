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
    );

//instantiate the class, passing the list as parameter
$Tree = new \Utils\Tree;
$Tree->setTree($list);
//get the organized tree
echo '<pre>' . nl2br(print_r($Tree->getTree(),true)) . '</pre>';
