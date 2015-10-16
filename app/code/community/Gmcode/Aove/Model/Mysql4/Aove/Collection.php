<?php

class Gmcode_Aove_Model_Mysql4_Aove_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('aove/attributes');
    }
}
