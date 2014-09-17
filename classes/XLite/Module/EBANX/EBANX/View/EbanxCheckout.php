<?php 

namespace XLite\Module\EBANX\EBANX\View; 

class EbanxCheckout extends \XLite\View\ACustomer implements \XLite\Base\IDecorator 
{ 

    //class EbanxCheckout extends \XLite\View\CheckoutSuccess implements \XLite\Base\IDecorator 
    // public static function getAllowedTargets() 
    // { 
    //     $targets = parent::getAllowedTargets(); 
    //     $return = array(); 
         
    //     foreach ($targets as $target) { 
    //         if ($target != 'main') { 
    //             $return[] = $target;  
    //         } 
    //     } 

    //     return $return; 
    // } 

    public static function getAllowedTargets()
    {
        return array_merge(parent::getAllowedTargets(), array('EbanxCheckout'));
    }

    protected function doActionEbanxCheckout(){

        require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';

        $hash = \XLite\Core\Request::getInstance()->hash;
        if(empty($hash)) 
                        {
                          // this should not happen. Only if you called your URL manually. EBANX will always pass the hashishe cigarette
                         die("Empty hash in the response URL");
                        }

        $params = array(
            'integrationkey'  => $this->getSetting('integrationkey')
           ,'hash'            => $hash
        );


        $response = \Ebanx\Ebanx::doQuery($params);



    }
}