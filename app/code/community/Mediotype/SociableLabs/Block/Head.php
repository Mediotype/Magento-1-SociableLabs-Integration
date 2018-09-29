<?php

/**
 * Class Mediotype_SociableLabs_Block_Head
 */
class Mediotype_SociableLabs_Block_Head extends Mage_Core_Block_Template {

    /**
     * @return Mage_Customer_Model_Customer
     */
    public function getCustomer() {
        return Mage::getSingleton('customer/session')->getCustomer();
    }

    /**
     * @return Mage_Sales_Model_Order
     */
    public function getOrder() {
        return Mage::getModel('sales/order')->load(Mage::getSingleton('checkout/session')->getLastOrderId());
    }
}