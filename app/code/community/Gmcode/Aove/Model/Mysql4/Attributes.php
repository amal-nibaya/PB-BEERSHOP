<?php

class Gmcode_Aove_Model_Mysql4_Attributes extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('aove/attributes', 'id');
    }
}
