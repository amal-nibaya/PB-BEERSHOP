    <?php

    class Gmcode_Aove_Block_Adminhtml_Aove_Options_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
    {

        public function __construct()
        {
            parent::__construct();
            $this->setId('aove_options_tabs');
            $this->setDestElementId('edit_form');
            $this->setTitle(Mage::helper('aove')->__('Option Information'));
        }

        protected function _beforeToHtml()
        {
            $this->addTab('options_form_section', array(
                'label'     => Mage::helper('aove')->__('Options Information'),
                'title'     => Mage::helper('aove')->__('Options Information'),
                'content'   => $this->getLayout()->createBlock('aove/adminhtml_aove_options_edit_tab_form')->toHtml(),
            ));

            return parent::_beforeToHtml();
        }
    }
