Tree
====

Helper to build tree like structure.
Need PHP 5.3>.

Example of use 1

```php
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
//set a template that will be used to print the three
$template = "<li><label><input type='checkbox' name='cat[]' value='%id'/>%name </label> <ul>%_callback</ul></li>";
//print the tree
echo '<ul>' . $Tree->printTree($template) . '</ul>'; 
```
It will output this:

<ul><li><label><input type='checkbox' name='cat[]' value='1'/>News </label> <ul><li><label><input type='checkbox' name='cat[]' value='2'/>Mobile </label> <ul><li><label><input type='checkbox' name='cat[]' value='3'/>Android </label> <ul></ul></li><li><label><input type='checkbox' name='cat[]' value='4'/>IOS </label> <ul><li><label><input type='checkbox' name='cat[]' value='6'/>Games </label> <ul></ul></li></ul></li></ul></li></ul></li><li><label><input type='checkbox' name='cat[]' value='5'/>Interviews </label> <ul></ul></li></ul>

Example of use 2
```php
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
```

You can use objects too, just implement this interface http://www.php.net/manual/en/class.arrayaccess.php
and set the way that your object will handle the properties.
