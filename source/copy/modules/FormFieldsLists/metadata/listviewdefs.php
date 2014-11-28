<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$listViewDefs['FormFieldsLists'] = array(
  'NAME' => array(
    'width' => '40', 
    'label' => 'LBL_LIST_NAME', 
    'link' => true,
    'default' => true,
  ),
  'LIST_TYPE' => array(
    'width' => '40',
    'label' => 'LBL_LIST_TYPE',
    'link' => false,
    'default' => true,
  ),
  /*'PARENT_TYPE' => array(
    'width' => '40',
    'link' => false,
    'default' => true,
  ),*/
  'PARENT_NAME' => array(
        'width'   => '20',
        'label'   => 'LBL_LIST_RELATED_TO',
        'dynamic_module' => 'PARENT_TYPE',
        'id' => 'PARENT_ID',
        'link' => true,
        'default' => true,
        'sortable' => false,
        'ACLTag' => 'PARENT',
        'related_fields' => array('parent_id', 'parent_type')
  ),
);
?>
