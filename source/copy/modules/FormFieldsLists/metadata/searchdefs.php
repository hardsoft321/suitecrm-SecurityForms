<?php

$searchdefs ['FormFieldsLists'] = array ( 
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4', 
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),

  'layout' => array (
    'basic_search' => array (
      'name' => array('name'=>'name','query_type'=>'default', 'width'=>'10%'),
    ),
    'advanced_search' => array (
      'name' => array('name'=>'name','query_type'=>'default'),
      'list_type' => array('name'=>'list_type','query_type'=>'default'),
      'parent_name' => array (
        'type' => 'parent',
        'label' => 'LBL_LIST_RELATED_TO',
        'width' => '10%',
        'default' => true,
        'name' => 'parent_name',
      ),
    ),
  ),
);
?>
