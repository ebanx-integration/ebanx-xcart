<?php
namespace XLite\Module\EBANX\EBANX\Model\Payment\Processor;
 
class Ebanx extends \XLite\Model\Payment\Base\WebBased
{

 public function setConfig(){


    \Ebanx\Config::set(array(
        'integrationKey' => $this->getSetting('integrationkey'),
        'testMode' =>  $this->getSetting('test'),
     ) );


    }

protected function doInitialPayment(){
    parent::doInitialPayment();
    header("location: " . $this->getFormURL());
}


protected function getFormURL()
{
    require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';


        $params = array();
        $params = $this->getFormFields();

        \Ebanx\Config::set(array(
        'integrationKey' => $this->getSetting('integrationkey'),
        'testMode' =>  $this->getSetting('test'),
        ) );

    
    //var_dump($params);

    $response = \Ebanx\Ebanx::doRequest($params);
    //$url = \XLite\Core\Session::getInstance()->continueURL;
    var_dump($response);
    var_dump($url);
    //$this->debug_to_console($response);
    if($response->status == 'SUCCESS')
    {
         $checkoutURL = $response->redirect_url;
    }
    
   $this->debug_to_console($response);
   //return 'https://www.ebanx.com';
   return $checkoutURL;
}

 
protected function getFormFields()
{
    return     $params = array(
        'integrationkey'        => $this->getSetting('integrationkey')
       ,'payment_type_code'     => '_all'
       ,'currency_code'               => $this->getCurrencyCode() //$order->getCurrency()->getCode()         //$this->getSetting('currency')
       ,'amount'                => $this->getOrder()->getCurrency()->roundValue($this->transaction->getValue()) //$this->transaction->getValue()
       ,'merchant_payment_code' => $this->transaction->getTransactionId() //$this->getOrder()->getOrderNumber()
       ,'name'                  => $this->getProfile()->getBillingAddress()->getName()
       ,'email'                 => $this->getProfile()->getLogin()


    );
    
}
protected function assembleFormBody()
{
    return true;
}
protected function getFormMethod()
{
    return self::FORM_METHOD_GET;
    //return self::FORM_METHOD_POST;
}


	public function processReturn(\XLite\Model\Payment\Transaction $transaction)
	{  /*

        require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';

	    parent::processReturn($transaction);

        $merchant_payment_code = $_GET["merchant_payment_code"];
        $hash                  = $_GET["hash"];

        $query = \Ebanx\Ebanx::doQuery($hash);

        $this->debug_to_console($merchant_payment_code);




	 */
	    
	 /*
	    $status = ('Completed' == $request->status)
	        ? $transaction::STATUS_SUCCESS
	        : $transaction::STATUS_FAILED;
	 
	    if (isset($request->error_description)) {
	        \XLite\Core\OrderHistory::getInstance()->registerTransaction($this->transaction->getOrder()->getOrderId(), 'Error description: ' . $request->error_description);
	        $transaction->setDataCell('status', $request->error_description, null, 'C');
	    }
	 
	    $this->transaction->setStatus($status);*/
            /*$status = ('CO' == $request->status)
                                    ? $transaction::STATUS_SUCCESS
                                    : $transaction::STATUS_FAILED;

            $this->transaction->setStatus($status);

        // $url = 'http://integration.ebanx.com/xc/?target=checkoutSuccess' . $this->getOrder()->getOrderNumber();
        // func_header_location($url);

        if(empty($hash)) 
                        {
                          // this should not happen. Only if you called your URL manually. EBANX will always pass the hashishe cigarette
                         die("Empty hash in the response URL");
                        }*/
                        return true;
	}


	public function getSettingsWidget()
	{
	    return 'modules/EBANX/EBANX/config.tpl';
	}

	protected function getEbanxSettings()
	{
    return array(
        'integrationkey' => $this->getSetting('integrationkey'),
        'test' => $this->getSetting('test') == 'true' ? true : false,
        );
	}

	public function isTestMode(\XLite\Model\Payment\Method $method)
	{
    	return $method->getSetting('test') != 'false';
	}
	


	public function isConfigured(\XLite\Model\Payment\Method $method)
	{
    	return parent::isConfigured($method)
	        && $method->getSetting('integrationkey')
	        && $method->getSetting('test');
	}


    public function getAdminIconURL(\XLite\Model\Payment\Method $method)
    {
        return true;
    }


    protected function getAllowedCurrencies(\XLite\Model\Payment\Method $method)
    {
        return array_merge(
            parent::getAllowedCurrencies($method),
            array(
                'USD', 'BRL',
            )
        );
    }

    protected function getCurrencyCode()
    {
        return strtoupper($this->getOrder()->getCurrency()->getCode());
    }



    function debug_to_console( $data ) {
 
        $output = '';
 
        if ( is_array( $data ) ) {
            $output .= "console.warn( 'Debug Objects with Array.' ); 
                console.log( '" . preg_replace( 
                    "/\n/", "\\n",
                    str_replace( "'", "\'", var_export( $data, TRUE ) )
                ) . "' );";
        } else if ( is_object( $data ) ) {
            $data    = var_export( $data, TRUE );
            $data    = explode( "\n", $data );
            foreach( $data as $line ) {
                if ( trim( $line ) ) {
                    $line    = addslashes( $line );
                    $output .= "console.log( '{$line}' );";
                }
            }
            $output = "console.warn( 'Debug Objects with Object.' ); $output";
        } else {
            $output .= "console.log( 'Debug Objects: {$data}' );";
        }
 
        echo '<script>' . $output . '</script>';
    }



}