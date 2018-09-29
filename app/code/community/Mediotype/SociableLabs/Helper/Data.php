<?php
/**
 * Class Mediotype_SociableLabs_Helper_Data
 * helper class for Sociable Labs module
 */
class Mediotype_SociableLabs_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Config paths for using throughout the code
     */
    const SOCIABLELABS_ENABLED  = 'sociablelabs_config/general/enabled';
    const SOCIABLELABS_TOKEN  = 'sociablelabs_config/general/token';

    /**
     * Check if extension is enabled
     * @return Boolean
     */
    public function getEnabled()
    {
        return Mage::getStoreConfig($this::SOCIABLELABS_ENABLED);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return Mage::getStoreConfig($this::SOCIABLELABS_TOKEN);
    }

    /**
     * @return string
     */
    public function getTransactionUrl()
    {
        return 'https://api.sociablelabs.net/transaction/api/transactions';
    }

}


