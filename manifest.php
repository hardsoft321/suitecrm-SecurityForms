<?php

$README = <<<RDME
Библиотека запрета на доступ к полям форм.
Модули "Поля форм", "Сценарии форм".
RDME;

$manifest = array (
  'name' => 'SecurityForms',
  'acceptable_sugar_versions' => array (),
  'acceptable_sugar_flavors' => array('CE','PRO','ENT'),
  'readme' => $README,
  'author' => 'Hardsoft321',
  'description' => 'Модули полей',
  'is_uninstallable' => true,
  'published_date' => '2014-11-21',
  'type' => 'module',
  'remove_tables' => 'prompt',
  'version' => '0.0.2.1',
);

$installdefs = array (
  'id' => 'SecurityForms',
  'beans' =>
  array (
    array (
      'module' => 'FormFields',
      'class' => 'FormField',
      'path' => 'modules/FormFields/FormField.php',
      'tab' => true,
    ),
    array (
      'module' => 'FormFieldsLists',
      'class' => 'FormFieldsList',
      'path' => 'modules/FormFieldsLists/FormFieldsList.php',
      'tab' => true,
    ),
  ),
  'copy' => array (
    array(
        'from' => '<basepath>/source/copy',
        'to' => '.'
    ),
  ),
);
