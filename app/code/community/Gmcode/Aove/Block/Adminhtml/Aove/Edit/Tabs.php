    <?php

    class Gmcode_Aove_Block_Adminhtml_Aove_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
    {

        public function __construct()
        {
            parent::__construct();
            $this->setId('aove_tabs');
            $this->setDestElementId('edit_form');
            $this->setTitle(Mage::helper('aove')->__('Attribute Information'));
        }

        protected function _beforeToHtml()
        {
            $this->addTab('form_section', array(
                'label'     => Mage::helper('aove')->__('Attribute Information'),
                'title'     => Mage::helper('aove')->__('Attribute Information'),
                'content'   => $this->getLayout()->createBlock('aove/adminhtml_aove_edit_tab_form')->toHtml(),
            ));

            $this->addTab('option_section', array(
                'label'     => Mage::helper('aove')->__('Manage Options'),
                'title'     => Mage::helper('aove')->__('Manage Options'),
                'content'   => $this->getLayout()->createBlock('aove/adminhtml_aove_options_grid')->toHtml(),
            ));

            return parent::_beforeToHtml();
        }
    }
