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
  'published_date' => '2016-09-19',
  'type' => 'module',
  'remove_tables' => 'prompt',
  'version' => '0.2.1',
);
$installdefs = array (
  'id' => 'SecurityForms',
  'administration' => array(
    array(
      'from'=>'<basepath>/source/administration/SecurityForms.php',
    ),
  ),
  'beans' =>
  array (
    array (
      'module' => 'FormFields',
      'class' => 'FormField',
      'path' => 'modules/FormFields/FormField.php',
      'tab' => false,
    ),
    array (
      'module' => 'FormFieldsLists',
      'class' => 'FormFieldsList',
      'path' => 'modules/FormFieldsLists/FormFieldsList.php',
      'tab' => false,
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
    array(
      'from'=> '<basepath>/language/modules/Administration/mod_strings_ru_ru.php',
      'to_module'=> 'Administration',
      'language'=>'ru_ru'
    ),
    array(
      'from'=> '<basepath>/language/modules/Administration/mod_strings_en_us.php',
      'to_module'=> 'Administration',
      'language'=>'en_us'
    ),
  ),
  'copy' => array (
    array(
        'from' => '<basepath>/source/copy',
        'to' => '.'
    ),
  ),
);
