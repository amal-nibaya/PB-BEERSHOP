<?php

class Gmcode_Aove_Block_Adminhtml_Aove_Options_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('options_form', array('legend'=>Mage::helper('aove')->__('Option information')));

        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('aove')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        $fieldset->addField('image_name', 'image', array(
          'label'     => Mage::helper('aove')->__('Image File'),
          'required'  => true,
          'name'      => 'image_name',
        ));

        $fieldset->addField('perent_id', 'text', array(
          'label'     => Mage::helper('aove')->__('Perent Id'),
          'required'  => false,
          'name'      => 'perent_id',
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('aove')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('aove')->__('Active'),
                ),

                array(
                    'value'     => 0,
                    'label'     => Mage::helper('aove')->__('Inactive'),
                ),
            ),
        ));

        $fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'label'     => Mage::helper('aove')->__('Content'),
            'title'     => Mage::helper('aove')->__('Content'),
            'style'     => 'width:100%; height:300px;',
            'wysiwyg'   => false,
            'required'  => false,
        ));

        if ( Mage::getSingleton('adminhtml/session')->getSlideshowData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSlideshowData());
            Mage::getSingleton('adminhtml/session')->setSlideshowData(null);
        } elseif ( Mage::registry('aove_options_data') ) {
            $form->setValues(Mage::registry('aove_options_data')->getData());
        }
        return parent::_prepareForm();
    }
}
