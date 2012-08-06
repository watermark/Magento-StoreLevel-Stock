<?php 
/**
 * Rewrites the stock class to add in store-level config setting checks
 * 
 * @category	Jcarey
 * @package		Jcarey_Stock
 * @author 		Carey Sizer <careysizer@gmail.com>
 *
 */
class Jcarey_Stock_Model_Stock_Item extends Mage_CatalogInventory_Model_Stock_Item
{
	/**
	 * Retrieve Manage Stock by store
	 *
	 * @return int
	 */
	public function getManageStock()
	{
		if ($this->getUseConfigManageStock()) {
			return (int) Mage::getStoreConfigFlag(self::XML_PATH_MANAGE_STOCK, $this->getStoreId());
		}
		return $this->getData('manage_stock');
	}
	
	/**
	 * Retrieve backorders status by store
	 *
	 * @return int
	 */
	public function getBackorders()
	{
		if ($this->getUseConfigBackorders()) {
			return (int) Mage::getStoreConfig(self::XML_PATH_BACKORDERS, $this->getStoreId());
		}
		return $this->getData('backorders');
	}
	
	/**
	 * Retrieve Maximum Qty Allowed in Shopping Cart per store
	 *
	 * @return float
	 */
	public function getMaxSaleQty()
	{
		return (float)($this->getUseConfigMaxSaleQty() ? Mage::getStoreConfig(self::XML_PATH_MAX_SALE_QTY, $this->getStoreId())
				: $this->getData('max_sale_qty'));
	}
	
	/**
	 * Retrieve minimal quantity available for item status in stock by store
	 *
	 * @return float
	 */
	public function getMinQty()
	{
		return (float)($this->getUseConfigMinQty() ? Mage::getStoreConfig(self::XML_PATH_MIN_QTY, $this->getStoreId())
				: $this->getData('min_qty'));
	}
	
	/**
	 * Retrieve whether Quantity Increments is enabled by store
	 *
	 * @return bool
	 */
	public function getEnableQtyIncrements()
	{
		return $this->getUseConfigEnableQtyIncrements()
		? Mage::getStoreConfigFlag(self::XML_PATH_ENABLE_QTY_INCREMENTS, $this->getStoreId())
		: (bool)$this->getData('enable_qty_increments');
	}
	
	/**
	 * Retrieve Quantity Increments per store
	 *
	 * @return float|false
	 */
	public function getQtyIncrements()
	{
		if ($this->_qtyIncrements === null) {
			if ($this->getEnableQtyIncrements()) {
				$this->_qtyIncrements = (float)($this->getUseConfigQtyIncrements()
						? Mage::getStoreConfig(self::XML_PATH_QTY_INCREMENTS, $this->getStoreId())
						: $this->getData('qty_increments'));
				if ($this->_qtyIncrements <= 0) {
					$this->_qtyIncrements = false;
				}
			} else {
				$this->_qtyIncrements = false;
			}
		}
		return $this->_qtyIncrements;
	}	
}