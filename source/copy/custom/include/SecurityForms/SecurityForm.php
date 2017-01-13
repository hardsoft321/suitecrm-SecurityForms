<?php
/**
 * @license http://hardsoft321.org/license/ GPLv3
 * @author Evgeny Pervushin <pea@lab321.ru>
 * @package SecurityForms
 */
require_once 'custom/include/SecurityForms/ReadOnlySugarEmailAddress.php';

class SecurityForm {

    /**
     * Версия js-файлов.
     * Изменить после обновления js.
     */
    const JS_CUSTOM_VERSION = '0.0.4';

    /**
     * По умолчанию скрывать всю форму
     */
    const MODE_DEFAULT_DISABLED = 1;

    /**
     * По умолчанию показывать всю форму
     */
    const MODE_DEFAULT_ENABLED = 2;

    private $fieldsMode = self::MODE_DEFAULT_ENABLED;
    private $enabledFields = array();
    private $disabledFields = array();
    private $relationshipsMode = self::MODE_DEFAULT_ENABLED;
    private $enabledRelationships = array();
    private $disabledRelationships = array();
    private $bean;

    public function __construct() {
    }

    protected function getEnabledFields() {
        return $this->enabledFields;
    }

    protected function setEnabledFields($fields) {
        $this->enabledFields = $fields;
    }

    protected function getDisabledFields() {
        return $this->disabledFields;
    }

    protected function setDisabledFields($fields) {
        $this->disabledFields = $fields;
    }

    protected function getDisabledRelationships() {
        return $this->disabledRelationships;
    }

    protected function setDisabledRelationships($relationships) {
        $this->disabledRelationships = $relationships;
    }

    protected function getEnabledRelationships() {
        return $this->enabledRelationships;
    }

    protected function setEnabledRelationships($relationships) {
        $this->enabledRelationships = $relationships;
    }

    public function setDefaultFieldsMode($mode) {
        $this->fieldsMode = $mode;
    }

    public function getFieldsMode() {
        return $this->fieldsMode;
    }

    public function setDefaultRelationshipsMode($mode) {
        $this->relationshipsMode = $mode;
    }

    public function getRelationshipsMode() {
        return $this->relationshipsMode;
    }

    public function setBean($bean) {
        $this->bean = $bean;
    }

    public function getBean() {
        return $this->bean;
    }

    /**
     * Хук на событие after_ui_frame для формы редактирования.
     * Выводит скрипт блокирования полей.
     */
    public function afterUiFrame($event, $arguments) {
        if($this->isEditView()) {
            echo $this->getAfterEditView();
            echo '<script>
if (!lab321) var lab321 = {};
if (!lab321.sform) lab321.sform = {};
lab321.sform.done = true;
</script>';
        }
    }

    public function getAfterEditView() {
        $bean = $this->loadBeanFromRequest();
        if($bean) {
            $this->setBean($bean);
        }
        if($this->fieldsMode == self::MODE_DEFAULT_ENABLED) {
            $disabledFields = $this->getDisabledFields();
            if(empty($disabledFields)) {
                return '';
            }
            return $this->getStyle()
                .$this->getVersionedScript()
                .$this->getDisableFieldsJs($disabledFields);
        }
        if($this->fieldsMode == self::MODE_DEFAULT_DISABLED) {
            $enabledFields = $this->getEnabledFields();
            return $this->getStyle()
                .$this->getVersionedScript()
                .$this->getDisableFormJs($enabledFields);
        }
        return '';
    }

    /**
     * Хук на событие before_save сохранения бина.
     * Отменяет изменения в полях.
     * Если поле является связью с другим бином, оно может быть изменено через связь.
     * В таком случае поле будет изменено, а в таблицу аудита не будет записано изменение.
     * Поэтому нужно использовать также хук beforeRelationshipSave.
     * Удаление вложения (deleteAttachment) не отменяется этой функцией.
     */
    public function beforeSave($bean, $event) {
       if (isset($bean->skipSecurityForms) && $bean->skipSecurityForms === true) return;

        if($bean->fetched_row === false && !empty($bean->id)) {
            /* Для таких модулей как ACLRoles, которые даже не делают retrieve перед сохранение
             * сами заполним fetched_row. Использование BeanFactory здесь не работает. */
            $beanClass = BeanFactory::getBeanName($bean->module_name);
            if(!empty($beanClass) && class_exists($beanClass)) {
                $copy = new $beanClass();
                $copy = $copy->retrieve($bean->id);
                if($copy) {
                    $bean->fetched_row = $copy->fetched_row;
                }
            }
        }

        $this->setBean($bean);
        $this->_beforeSave($event);
    }

    protected function _beforeSave($event) {
        $diff = $this->getDataChangesToUnset($this->bean);
        foreach($diff as $changes) {
            $field = $changes['field_name'];
            $this->bean->$field = $changes['before'];
            $GLOBALS['log']->warn("SecurityForms: {$this->bean->module_name} field $field change canceled");
        }
    }

    protected function getDataChangesToUnset($bean) {
        $diff = array();
        if(is_admin($GLOBALS['current_user']) && !empty($_POST['allowAllFieldsSave'])) {
            return $diff;
        }
        $enabledFields = $this->fieldsMode == self::MODE_DEFAULT_DISABLED ? $this->getEnabledFields() : null;
        $disabledFields = $this->fieldsMode == self::MODE_DEFAULT_ENABLED ? $this->getDisabledFields() : null;
        $dbDiff = $bean->db->getDataChanges($bean);
        foreach($dbDiff as $field => $changes) {
            if(!in_array($field, array('date_modified', 'modified_user_id', 'modified_by_name'))
                && (   ($this->fieldsMode == self::MODE_DEFAULT_DISABLED && !in_array($field, $enabledFields))
                    || ($this->fieldsMode == self::MODE_DEFAULT_ENABLED  && in_array($field, $disabledFields))   ))
            {
                $diff[$field] = $dbDiff[$field];
            }
        }
        if(!empty($bean->emailAddress)
            && (   ($this->fieldsMode == self::MODE_DEFAULT_DISABLED && !in_array('emailAddress', $enabledFields))
                    || ($this->fieldsMode == self::MODE_DEFAULT_ENABLED  && in_array('emailAddress', $disabledFields))   ))
        {
            $diff['emailAddress'] = array(
                'field_name' => 'emailAddress',
                'before' => new ReadOnlySugarEmailAddress(),
            );
        }
        return $diff;
    }

    /**
     * Хук на событие before_relationship_add или before_relationship_delete.
     * Останавливает выполнение, если совершается недопустимое изменение связи.
     */
    public function beforeRelationshipSave($bean, $event, $arguments) {
        $this->setBean($bean);
        $this->_beforeRelationshipSave($event, $arguments);
    }

    protected function _beforeRelationshipSave($event, $arguments) {
        $fieldDefs = $this->bean->getFieldDefinitions();
        if($this->relationshipsMode == self::MODE_DEFAULT_ENABLED) {
            $disabledRelationships = $this->getDisabledRelationships();
            if(in_array($arguments['link'], $disabledRelationships)) {
                $changed = true;
                if (isset($this->bean->relationship_fields) && is_array($this->bean->relationship_fields)) {
                    foreach ($this->bean->relationship_fields as $id => $rel_name) {
                        if($rel_name != $arguments['link']) {
                            continue;
                        }
                        if(!empty($this->bean->$id)) {
                            if($this->bean->rel_fields_before_value[$id] == $this->bean->$id) {
                                $changed = false;
                                break;
                            }
                        }
                    }
                }
                if($changed) {
                    sugar_die('Связь не может быть изменена: '.$arguments['link']);
                }
            }
        }
    }

    /**
     * Хук на событие before_delete бина.
     * Если поля по умолчанию запрещено редактировать, то и удалить запись нельзя.
     * Если поле deleted указано среди disabled fields, то удалять нельзя
     */
    public function beforeDelete($bean, $event, $arguments) {
        if(empty($bean->id) && !empty($arguments['id'])) {
            $bean->id = $arguments['id'];
        }
        $this->setBean($bean);
        $this->_beforeDelete($event);
    }

    protected function _beforeDelete() {
        global $current_user;
        if($current_user->isAdmin()) {
            return;
        }
        $hasAccess = true;
        if($this->fieldsMode == self::MODE_DEFAULT_DISABLED) {
            $hasAccess = false;
        }
        else {
            $disabledFields = $this->getDisabledFields();
            if(in_array('deleted', $disabledFields)) {
                $hasAccess = false;
            }
        }
        if(!$hasAccess) {
            if(!empty($this->bean->name)) {
                echo $this->bean->name;
            }
            ACLController::displayNoAccess(true);
            sugar_cleanup(true);
        }
    }

    protected function getVersionedScript() {
        return getVersionedScript('custom/include/SecurityForms/js/securityforms.js', self::JS_CUSTOM_VERSION);
    }

    protected function getStyle() {
        return '<link rel="stylesheet" type="text/css" href="'.getVersionedPath('custom/include/SecurityForms/css/style.css').'">';
    }

    protected function getDisableFormJs($enabledFields) {
        $is_admin = is_admin($GLOBALS['current_user']);
        return "
<script type=\"text/javascript\">
    lab321.sform.isAdmin = '$is_admin';
    lab321.sform.disableForm('form[name=\"EditView\"]', ".json_encode(array_values($enabledFields)).");
</script>
";
    }

    protected function getDisableFieldsJs($disabledFields) {
        $is_admin = is_admin($GLOBALS['current_user']);
        return "
<script type=\"text/javascript\">
    lab321.sform.isAdmin = '$is_admin';
    lab321.sform.disableFields('form[name=\"EditView\"]', ".json_encode(array_values($disabledFields)).");
</script>
";
    }

    protected function isEditView() {
        $action = $_REQUEST['action'];
        $module = $_REQUEST['module'];
        $action = strtolower($action);
        if($module && ($action == "editview") && (!isset($_REQUEST['search_form_only']) || !$_REQUEST['search_form_only'])) {
            return true;
        }
        return false;
    }

    protected function loadBeanFromRequest() {
        return isset($_REQUEST['module']) && (empty($_REQUEST['isDuplicate']) || $_REQUEST['isDuplicate'] == 'false')
            ? BeanFactory::getBean($_REQUEST['module'], isset($_REQUEST['record']) ? $_REQUEST['record'] : null) : null;
    }
}
