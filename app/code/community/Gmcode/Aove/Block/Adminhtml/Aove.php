<?php
class Gmcode_Aove_Block_Adminhtml_Aove extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
    {
        $this->_controller = 'adminhtml_aove';
        $this->_blockGroup = 'aove';
        $this->_headerText = Mage::helper('aove')->__('Attribute Manager');
        $this->_addButtonLabel = Mage::helper('aove')->__('Add Item');
        parent::__construct();
    }
}
