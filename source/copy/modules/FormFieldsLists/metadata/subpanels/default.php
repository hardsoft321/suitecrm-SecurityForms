<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$subpanel_layout = array(

    'top_buttons' => array(
        array (
            'widget_class'=>'SubPanelTopButtonQuickCreate',
        ),
        array (
            'widget_class'=>'SubPanelTopSelectButton', 'popup_module' => 'FormFieldsLists'
        ),
    ),
    'where' => '',
    'list_fields' => array(
        'name'=>array(
            'vname' => 'LBL_LIST_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '70%',
        ),
        'list_type'=>array(
            'vname' => 'LBL_LIST_TYPE',
            'width' => '15%',
        ),
    ),
);
?>
