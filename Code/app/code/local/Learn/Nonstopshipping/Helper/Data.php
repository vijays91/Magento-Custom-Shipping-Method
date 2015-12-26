<?php
class Learn_Nonstopshipping_Helper_Data extends Mage_Core_Helper_Abstract 
{
    const XML_EXPRESS_ACTIVE   = 'carriers/nonstopshipping/active';
    const XML_EXPRESS_ONE_DAY  = 'carriers/nonstopshipping/one_day_weight';
    const XML_EXPRESS_ONE_WEEK = 'carriers/nonstopshipping/one_week_weight';
    const XML_EXPRESS_NORMAL   = 'carriers/nonstopshipping/normarl_weight';

	public function conf($code, $store = null) {
        return Mage::getStoreConfig($code, $store);
    }
    
	public function nonstop_active($store) {
        return $this->conf(self::XML_EXPRESS_ACTIVE, $store);
    }
    
	public function normal_charge($store) {
        return $this->conf(self::XML_EXPRESS_NORMAL, $store);
	}
    
	public function oneweek_charge($store) {
        return $this->conf(self::XML_EXPRESS_ONE_WEEK, $store);
	}
    
	public function oneday_charge($store) {
		return $this->conf(self::XML_EXPRESS_ONE_DAY, $store);
	}    
}