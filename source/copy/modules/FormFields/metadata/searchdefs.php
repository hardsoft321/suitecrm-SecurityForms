<?php

$searchdefs ['FormFields'] = array ( 
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
      'list_name' => array('name'=>'list_name','query_type'=>'default'),
    ),
  ),
);
?>
