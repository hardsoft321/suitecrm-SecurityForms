<?php

$admin_options_defs = array();
$admin_options_defs['FFL']['FormFieldsLists'] = array (
    'list',
    'LBL_FORM_FIELDS_LISTS_TITLE',
    'LBL_FORM_FIELDS_LISTS_DESC',
    './index.php?module=FormFieldsLists&action=index',
);

/* Находим панель в массиве панелей */
/* Ищем по названию панели */
$groupHeader = null;
$groupHeaderKey = -1;
foreach ($admin_group_header as $key => $value) {
    if ( $value[0] === 'LBL_STUDIO_TITLE' ) {
        $groupHeader = $value;
        $groupHeaderKey = $key;
    }
}

/* Если нашли */
if ( $groupHeaderKey !== -1 ) {
    /* Добавляем нашу панель в массив панелей */
    $groupHeader[3] = array_merge($groupHeader[3], $admin_options_defs);
    $admin_group_header[$groupHeaderKey] = $groupHeader;
} else {
    /* Иначе создаем новый блок */
    $admin_group_header[] = array (
        'LBL_FORM_FIELDS_LISTS_TITLE',
        '',
        false,
        $admin_options_defs,
        '',
    );
}
