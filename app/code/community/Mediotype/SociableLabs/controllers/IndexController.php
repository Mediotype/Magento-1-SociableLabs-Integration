<?php

/**
 * Class Mediotype_Trustev_IndexController
 */

class Mediotype_SociableLabs_IndexController extends Mage_Core_Controller_Front_Action {
    /**
     * Redirect users who somehow get here
     */
	public function indexAction() {
		$this->_redirect('no-route');
	}

    /**
     * Request params {"contacts": ["someemail1@gmail.com", "someemail2@gmail.com", "someemail3@gmail.com"]}
     */
    public function membercheckAction() {
        $helper = Mage::helper('mediotype_sociablelabs'); /** @var $helper Mediotype_SociableLabs_Helper_Data */
        if($helper->getEnabled()) {
            $contacts = $this->getRequest()->getParams('contacts');
            $responseArray = array();
            if ($contacts == null || count($contacts) > 1) {
                $responseArray['code'] = 400;
                $responseArray['msg'] = 'There was an issue with the request.';
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody(json_encode($responseArray));
                return;
            }
            $responseArray['code'] = 200;
            $responseArray['matches'] = array();
            if ($contacts >= 1) {
                foreach ($contacts as $email) {
                    $customer = Mage::getModel('customer/customer')->loadByEmail($email);
                    if ($customer->getId()) {
                        $responseArray['matches'][] = $email;
                    }
                }
            }
            if (count($responseArray['matches']) >= 1) {
                $responseArray['msg'] = 'There were matches found.';
            } else {
                $responseArray['msg'] = 'There were no matches found.';
            }
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(json_encode($responseArray));
        }
        else {
            $this->_redirect('no-route');
        }
    }

    /**
     * Request params {"email": "sl.vntest2@gmail.com"}
     */
    public function newsletterAction() {
        $helper = Mage::helper('mediotype_sociablelabs'); /** @var $helper Mediotype_SociableLabs_Helper_Data */
        if($helper->getEnabled()) {
            $email = $this->getRequest()->getParams('email');
            $responseArray = array();
            if($email == null || Zend_Validate::is($email, 'EmailAddress') == false)
            {
                $responseArray['code'] = 400;
                $responseArray['msg'] = 'Please enter a valid email.';
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody(json_encode($responseArray));
                return;
            }
            /** @var Mage_Newsletter_Model_Subscriber $subscribe */
            $subscribe = Mage::getModel('newsletter/subscriber')->loadByEmail($email);//->subscribe($email);
            if($subscribe->isSubscribed())
            {
                $responseArray['code'] = 409;
                $responseArray['msg'] = 'The email is already registered to the newsletter.';
            }
            else
            {
                $subscribe->subscribe($email);
                $responseArray['code'] = 200;
                $responseArray['msg'] = 'The user was registered to the newsletter successfully.';
            }

            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(json_encode($responseArray));
        }
        else {
            $this->_redirect('no-route');
        }
    }
	
}