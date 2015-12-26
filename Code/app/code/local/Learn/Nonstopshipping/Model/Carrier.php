<?php
class Learn_Nonstopshipping_Model_Carrier
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{

    /* 
        Must Be Tab-name(system xml - Group name)
    */
    protected $_code = 'nonstopshipping';
    
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!Mage::helper('nonstopshipping')->nonstop_active()) {
            return false;
        }
        
        $result = Mage::getModel('shipping/rate_result');
        $weight = 0;
        foreach ($request->getAllItems() as $item) {
            if ($item->getWeight() > 0) {
                $weight = $weight + ($item->getWeight() * $item->getQty());
            }
        }
        
        $weight = number_format((float)$weight, 2, '.', '');
        
        if($weight > 0) {
            $result->append($this->_getOneWeekRate($weight));
            $result->append($this->_getOnedayRate($weight));
        }
        $weight = ($weight == 0) ? 1 : $weight;
        $result->append($this->_getNormalRate($weight));

        return $result;
    }

    public function getAllowedMethods()
    {
        return array(
            'normalcharge'    => Mage::helper('shipping')->__('Normal delivery charge'),
            'oneweekcharge'   => Mage::helper('shipping')->__('One week delivery charge'),
            'onedaycharge'    => Mage::helper('shipping')->__('One day delivery charge'),
        );
    }
    
    
    protected function _getOnedayRate($weight)
    {
        $oneday_amount  = Mage::helper('nonstopshipping')->oneday_charge();        
        $shipping_amount = $weight * $oneday_amount;
        
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');
        
        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('onedaycharge');
        $rate->setMethodTitle(Mage::helper('shipping')->__('One day delivery charge'));
        $rate->setPrice($shipping_amount);
        $rate->setCost(0);

        return $rate;
    }
    
    protected function _getOneWeekRate($weight)
    {
        $oneweek_amount  = Mage::helper('nonstopshipping')->oneweek_charge();        
        $shipping_amount = $weight * $oneweek_amount;
        
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');
        
        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('oneweekcharge');
        $rate->setMethodTitle(Mage::helper('shipping')->__('One week delivery charge'));
        $rate->setPrice($shipping_amount);
        $rate->setCost(0);

        return $rate;
    }
    
    protected function _getNormalRate($weight)
    {
        $normal_amount  = Mage::helper('nonstopshipping')->normal_charge();        
        $shipping_amount = $weight * $normal_amount;
        
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');
        
        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('normalcharge');
        $rate->setMethodTitle(Mage::helper('shipping')->__('Normal delivery charge'));
        $rate->setPrice($shipping_amount);
        $rate->setCost(0);

        return $rate;
    }
    
}