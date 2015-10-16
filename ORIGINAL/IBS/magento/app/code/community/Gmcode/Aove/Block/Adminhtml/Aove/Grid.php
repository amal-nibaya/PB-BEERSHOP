    <?php

    class Gmcode_Aove_Block_Adminhtml_Aove_Grid extends Mage_Adminhtml_Block_Widget_Grid
    {
        public function __construct()
        {
            parent::__construct();
            $this->setId('aoveGrid');
            // This is the primary key of the database
            $this->setDefaultSort('id');
            $this->setDefaultDir('DESC');
            $this->setSaveParametersInSession(true);
            $this->setUseAjax(true);
        }

        protected function _prepareCollection()
        {
            $collection = Mage::getModel('aove/attributes')->getCollection();
      			foreach($collection as $link){
      				if($link->getStores() && $link->getStores() != 0 ){
      					$link->setStores(explode(',',$link->getStores()));
      				}
      				else{
      					$link->setStores(array('0'));
      				}
      			}
            $this->setCollection($collection);
            return parent::_prepareCollection();
        }

        protected function _prepareColumns()
        {
            $this->addColumn('id', array(
                'header'    => Mage::helper('aove')->__('ID'),
                'align'     =>'right',
                'width'     => '50px',
                'index'     => 'id',
            ));

            $this->addColumn('attribute', array(
                'header'    => Mage::helper('aove')->__('Attribute'),
                'align'     =>'left',
                'index'     => 'attribute',
            ));

            return parent::_prepareColumns();
        }

        public function getRowUrl($row)
        {
            $session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
            $session->setData("attribute_id", $row->getId());
            return $this->getUrl('*/*/edit', array('id' => $row->getId()));
        }

        public function getGridUrl()
        {
          return $this->getUrl('*/*/grid', array('_current'=>true));
        }

		protected function _filterStoreCondition($collection, $column)
		{

			if (!$value = $column->getFilter()->getValue()) {
				return;
			}
			$this->getCollection()->addStoreFilter($value);
		}

    }
