<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$listViewDefs['FormFields'] = array(
  'NAME' => array(
    'width' => '40', 
    'label' => 'LBL_LIST_NAME', 
    'link' => true,
    'default' => true,
  ),
  'LIST_NAME' => array(
    'width' => '40',
    'label' => 'LBL_LIST',
    'link' => true,
    'default' => true,
    'id' => 'LIST_ID',
    'module' => 'FormFieldsLists',
    'related_fields' => array('list_id'),
  ),
);
?>
