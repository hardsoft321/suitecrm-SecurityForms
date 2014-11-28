<?php

$viewdefs ['FormFieldsLists'] = array (  'DetailView' => 
  array (
    'templateMeta' => array (
      'form' => array (
        'buttons' => array (
           'EDIT',
           'DUPLICATE',
           'DELETE',
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
        array('name', 'list_type'),
        array(
            array(
                'name' => 'parent_name',
                'customLabel' => '{sugar_translate label=\'LBL_MODULE_NAME\' module=$fields.parent_type.value}',
              ),
        )
      ),
    ),
  ),
);
?>
