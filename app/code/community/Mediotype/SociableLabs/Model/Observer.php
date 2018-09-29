<?php
class Mediotype_SociableLabs_Model_Observer{
    /**
     * @param Varien_Event_Observer $observer
     * @return bool
     */
    public function postTransactionAfterSaveOrder(Varien_Event_Observer $observer) {
        $helper = Mage::helper('mediotype_sociablelabs'); /** @var Mediotype_SociableLabs_Helper_Data $helper */
        if($helper->getEnabled()) {
            try {
                $order = $observer->getOrder();
                /** @var $order Mage_Sales_Model_Order $order */
                $data = array(
                    "customer_token" => $helper->getToken(),
                    "email" => $order->getCustomerEmail(),
                    "net_purchase_amount" => number_format($order->getData('base_subtotal'),2,'',''),
                    "gross_purchase_amount" => number_format($order->getGrandTotal(),2,'',''),
                    "external_transaction_id" => "{$order->getId()}",
                    "currency" => "USD",
                    "transaction_date" => date("c")
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $helper->getTransactionUrl());
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                Mage::log($result,null,'sl.log');
            }
            catch (Exception $e)
            {
                Mage::logException($e);
                return false;
            }
        }
    }

    public function customerRegistrationSuccess(Varien_Event_Observer $observer) {
        $helper = Mage::helper('mediotype_sociablelabs'); /** @var Mediotype_SociableLabs_Helper_Data $helper */
        if($helper->getEnabled()) {
            $customer = $observer->getData('customer'); /** @var Mage_Customer_AccountController $controller */
            if($customer->getId())
            {
                Mage::getSingleton('customer/session')->setData('registered',true);
            }
        }
    }
}