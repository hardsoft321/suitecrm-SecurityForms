<?php
class SecurityForm {

    /**
     * Версия js-файлов.
     * Изменить после обновления js.
     */
    const JS_CUSTOM_VERSION = '0.0.1';

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
        }
    }

    public function getAfterEditView() {
        $bean = $this->loadBeanFromRequest();
        if($bean) {
            $this->setBean($bean);
        }
        if($this->fieldsMode == self::MODE_DEFAULT_ENABLED) {
            //TODO: realize MODE_DEFAULT_ENABLED support
            return '';
        }
        $enabledFields = array();
        if($this->fieldsMode == self::MODE_DEFAULT_DISABLED) {
            $enabledFields = $this->getEnabledFields();
        }
        return $this->getStyle()
            .$this->getVersionedScript()
            .$this->getDisableFormJs($enabledFields);
    }

    /**
     * Хук на событие before_save сохранения бина.
     * Отменяет изменения в полях.
     * Если поле является связью с другим бином, оно может быть изменено через связь.
     * В таком случае поле будет изменено, а в таблицу аудита не будет записано изменение.
     * Поэтому нужно использовать также хук beforeRelationshipSave.
     */
    public function beforeSave($bean, $event) {
        $this->setBean($bean);
        $this->_beforeSave($event);
    }

    protected function _beforeSave($event) {
        if($this->fieldsMode == self::MODE_DEFAULT_DISABLED) {
            $enabledFields = $this->getEnabledFields();
            $diff = $this->bean->db->getDataChanges($this->bean);
            foreach($diff as $changes) {
                $field = $changes['field_name'];
                if(in_array($field, array('date_modified', 'modified_user_id', 'modified_by_name'))) {
                    continue;
                }
                if(in_array($field, $enabledFields)) {
                    continue;
                }
                $this->bean->$field = $changes['before'];
                $GLOBALS['log']->warn("SecurityForms: {$bean->module_name} field $field change canseled");
            }
        }
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

    protected function getVersionedScript() {
        return getVersionedScript('custom/include/SecurityForms/js/securityforms.js', self::JS_CUSTOM_VERSION);
    }

    protected function getStyle() {
        return "
<style>
input.sf-disabled, textarea.sf-disabled, ul.sf-select {
    color: #717171;
    background-color: #f6f6f6;
}
ul.sf-select {
    border: 1px solid;
    border-color: #94C1E8;
    display: inline-block;
    min-height: 15px;
    margin: 0;
    padding-left: 0;
    padding-right:6px;
}
ul.sf-select li {
    margin: 1px 3px;
}
</style>";
    }

    protected function getDisableFormJs($enabledFields) {
        return "
<script type=\"text/javascript\">
    lab321.sform.disableForm('EditView', ".json_encode($enabledFields).");
</script>
"; //TODO: disable emailAddressesTable, radio buttons?
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
        return isset($_REQUEST['module']) && isset($_REQUEST['record']) ? BeanFactory::getBean($_REQUEST['module'], $_REQUEST['record']) : null;
    }
}
