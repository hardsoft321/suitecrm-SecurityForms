<?php

$README = <<<RDME
Библиотека запрета на доступ к полям форм.
Модули "FormFieldsLists", "FormFields".
RDME;

$manifest = array (
  'name' => 'SecurityForms',
  'acceptable_sugar_versions' => array (),
  'acceptable_sugar_flavors' => array('CE','PRO','ENT'),
  'readme' => $README,
  'author' => 'Hardsoft321',
  'description' => 'Модули полей',
  'is_uninstallable' => true,
  'published_date' => '2015-04-28',
  'type' => 'module',
  'remove_tables' => 'prompt',
  'version' => '0.0.3',
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
	'language' => array(
		0 => array(
			'from' => '<basepath>/language/application/en_us.lang.php',
			'to_module' => 'application',
			'language' => 'en_us',
		),
		1 => array(
			'from' => '<basepath>/language/application/ru_ru.lang.php',
			'to_module' => 'application',
			'language' => 'ru_ru',
		),
  ),
  'copy' => array (
    array(
        'from' => '<basepath>/source/copy',
        'to' => '.'
    ),
  ),
);
