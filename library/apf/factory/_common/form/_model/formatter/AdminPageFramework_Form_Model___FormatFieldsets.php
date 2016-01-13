<?php 
/**
	Admin Page Framework v3.7.11b01 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/admin-page-framework>
	Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_Form_Model___FormatFieldsets extends AdminPageFramework_Form_Base {
    public $aSectionsets = array();
    public $aFieldsets = array();
    public $sStructureType = '';
    public $sCapability = '';
    public $aCallbacks = array('fieldset_before_output' => null);
    public $aSavedData = array();
    public $oCallerForm;
    public function __construct() {
        $_aParameters = func_get_args() + array($this->aFieldsets, $this->aSectionsets, $this->sStructureType, $this->aSavedData, $this->sCapability, $this->aCallbacks, $this->oCallerForm,);
        $this->aFieldsets = $_aParameters[0];
        $this->aSectionsets = $_aParameters[1];
        $this->sStructureType = $_aParameters[2];
        $this->aSavedData = $_aParameters[3];
        $this->sCapability = $_aParameters[4];
        $this->aCallbacks = $_aParameters[5];
        $this->oCallerForm = $_aParameters[6];
    }
    public function get() {
        $this->aFieldsets = $this->_getFieldsetsFormatted($this->aFieldsets, $this->aSectionsets, $this->sCapability);
        return $this->_getDynamicElementsAddedToFieldsets();
    }
    private function _getDynamicElementsAddedToFieldsets() {
        $_oDynamicElements = new AdminPageFramework_Form_Model___FormatDynamicElements($this->aSectionsets, $this->aFieldsets, $this->aSavedData);
        return $_oDynamicElements->get();
    }
    private function _getFieldsetsFormatted(array $aFieldsets, array $aSectionsets, $sCapability) {
        $_aNewFieldsets = array();
        foreach ($aFieldsets as $_sSectionPath => $_aItems) {
            if (!isset($aSectionsets[$_sSectionPath])) {
                continue;
            }
            $_aNewFieldsets[$_sSectionPath] = $this->_getItemsFormatteed($_sSectionPath, $_aItems, $this->getElement($aSectionsets, array($_sSectionPath, 'capability',), $sCapability), $aSectionsets);
        }
        $this->_sortFieldsBySectionsOrder($_aNewFieldsets, $aSectionsets);
        return $this->callBack($this->aCallbacks['fieldsets_after_formatting'], array($_aNewFieldsets, $aSectionsets));
    }
    private function _getItemsFormatteed($sSectionPath, $aItems, $sCapability, $aSectionsets) {
        $_abSectionRepeatable = $this->getElement($aSectionsets, array($sSectionPath, 'repeatable'), false);
        if ($this->_isSubSections($aItems, $_abSectionRepeatable)) {
            return $this->_getSubSectionsFormatted($aItems, $sCapability, $aSectionsets, $_abSectionRepeatable);
        }
        return $this->_getNormalFieldsetsFormatted($aItems, $sCapability, $aSectionsets, $_abSectionRepeatable);
    }
    private function _getNormalFieldsetsFormatted($aItems, $sCapability, $aSectionsets, $_abSectionRepeatable) {
        $_aNewItems = array();
        foreach ($aItems as $_sFieldID => $_aFieldset) {
            $_aFieldset = $this->_getFieldsetFormatted($_aFieldset, $aSectionsets, $sCapability, count($_aNewItems), null, $_abSectionRepeatable, $this->oCallerForm);
            if (empty($_aFieldset)) {
                continue;
            }
            $_aNewItems[$_aFieldset['field_id']] = $_aFieldset;
        }
        uasort($_aNewItems, array($this, 'sortArrayByKey'));
        return $_aNewItems;
    }
    private function _isSubSections($aItems, $_abSectionRepeatable) {
        if (!empty($_abSectionRepeatable)) {
            return true;
        }
        return ( boolean )count($this->getIntegerKeyElements($aItems));
    }
    private function _getSubSectionsFormatted($aItems, $sCapability, $aSectionsets, $_abSectionRepeatable) {
        $_aNewFieldset = array();
        foreach ($this->numerizeElements($aItems) as $_iSubSectionIndex => $_aFieldsets) {
            foreach ($_aFieldsets as $_aFieldset) {
                $_iCountElement = count($this->getElementAsArray($_aNewFieldset, $_iSubSectionIndex));
                $_aFieldset = $this->_getFieldsetFormatted($_aFieldset, $aSectionsets, $sCapability, $_iCountElement, $_iSubSectionIndex, $_abSectionRepeatable, $this->oCallerForm);
                if (empty($_aFieldset)) {
                    continue;
                }
                $_aNewFieldset[$_iSubSectionIndex][$_aFieldset['field_id']] = $_aFieldset;
            }
            uasort($_aNewFieldset[$_iSubSectionIndex], array($this, 'sortArrayByKey'));
        }
        return $_aNewFieldset;
    }
    private function _sortFieldsBySectionsOrder(array & $aFieldsets, array $aSectionsets) {
        if (empty($aSectionsets) || empty($aFieldsets)) {
            return;
        }
        $_aSortedFields = array();
        foreach ($aSectionsets as $_sSectionPath => $_aSecitonset) {
            if (isset($aFieldsets[$_sSectionPath])) {
                $_aSortedFields[$_sSectionPath] = $aFieldsets[$_sSectionPath];
            }
        }
        $aFieldsets = $_aSortedFields;
    }
    private function _getFieldsetFormatted($aFieldset, $aSectionsets, $sCapability, $iCountOfElements, $iSubSectionIndex, $bIsSectionRepeatable, $oCallerObject) {
        if (!isset($aFieldset['field_id'], $aFieldset['type'])) {
            return;
        }
        $_oFieldsetFormatter = new AdminPageFramework_Form_Model___Format_Fieldset($aFieldset, $this->sStructureType, $sCapability, $iCountOfElements, $iSubSectionIndex, $bIsSectionRepeatable, $oCallerObject);
        $_aFieldset = $this->callBack($this->aCallbacks['fieldset_before_output'], array($_oFieldsetFormatter->get(), $aSectionsets));
        $_aFieldset = $this->callBack($this->aCallbacks['fieldset_after_formatting'], array($_aFieldset, $aSectionsets));
        return $_aFieldset;
    }
}
