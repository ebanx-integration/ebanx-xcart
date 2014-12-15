<?php

class EbanxCheckoutReturn extends \XLite\Controller\Customer\Checkout implements \XLite\Base\IDecorator
	public function handleRequest()
    {
    	require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';

        if (
            isset(\XLite\Core\Request::getInstance()->action)
            && $this->isExpressCheckoutAction()
            && $this->getCart()->checkCart()
        ) {
            \XLite\Core\Request::getInstance()->setRequestMethod('GET');
        }

        parent::handleRequest();
    }

    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();

        $list[] = 'test';

        return $list;
    }

    $this->getReturnURL();

}