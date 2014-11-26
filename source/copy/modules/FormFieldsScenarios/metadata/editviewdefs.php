<?php

$viewdefs ['FormFieldsScenarios'] = array ( 'EditView' => 
  array (
    'templateMeta' => array (
      'form' =>  array (
        'buttons' => array (
           'SAVE',
           'CANCEL',
        ),
      ),
      'maxColumns' => '2',
      'widths' => array (
        array (
          'label' => '10',
          'field' => '30',
        ),
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
    ),
    'panels' => array (
      'lbl_information' => array (
        array('name'),
        array('uniq_name'),
        array('sf_module'),
      ),
    ),
  ),
);
?>
