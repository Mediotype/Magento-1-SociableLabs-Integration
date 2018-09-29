<?php

/**
 * Class Mediotype_SociableLabs_Block_Registered
 */
class Mediotype_SociableLabs_Block_Registered extends Mage_Core_Block_Template {

    /**
     * @return bool
     */
    public function getRegistrationSuccess()
    {
        $registered = Mage::getSingleton('customer/session')->getData('registered');
        if(isset($registered) && $registered == true)
        {
            //set data to false so we don't output more than once
            Mage::getSingleton('customer/session')->setData('registered',false);
            return true;
        }
        return false;
    }
}