<?php
namespace XLite\Module\EBANX\EBANX\Model\Payment\Processor;
 
class Ebanx extends \XLite\Model\Payment\Base\WebBased
{


// protected function doInitialPayment(){
//     parent::doInitialPayment();
//     header("location: " . $this->getFormURL());
// }

protected function assembleFormBody()
{
    return true;
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

        // var_dump($this->getSetting('integrationkey'));
        // var_dump($this->getCallbackURL(null, true));
        // var_dump($this->getCallbackURL('hash_codes'));
        // die;

    $response = \Ebanx\Ebanx::doRequest($params);
    //$url = \XLite\Core\Session::getInstance()->continueURL;

    //$this->debug_to_console($response);


    if($response->status == 'SUCCESS')
    {
         $checkoutURL = $response->redirect_url;
    }

    // var_dump($params);
    // var_dump($response);

   $this->debug_to_console($response);
   return $checkoutURL;

}

    public function processReturn(\XLite\Model\Payment\Transaction $transaction)
    {  
        parent::processReturn($transaction);
       require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';
                $method = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findOneBy(array('service_name' => 'Ebanx'));
        $integrationkey = $method->getSetting('integrationkey');
        $test = $method->getSetting('test');

           \Ebanx\Config::set(array(
        'integrationKey' => $integrationkey, //'d55ffec9c19a2891716dad68732dade9a312a6aeb7c874ead4a8c56dff4d7c38a49c51d4977827e7d61bb9eee3b2696bcc6a', //$this->getSetting('integrationkey'),
        'testMode' =>  $test
        
            ) );
            


            /*
            * LINK DE RETORNO https://localhost/ebanx-xcart/?target=payment_return&txn_id_name=merchant_payment_code&hash=547f61a258693d74d979eae9ccffb0d00b5b272f9489efa3&merchant_payment_code=36&payment_type_code=boleto
              LINK DE CALLBACK: https://localhost/ebanx-xcart/?target=callback&txn_id_name=merchant_payment_code

                
            */
        //require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';
        
        $operation = \XLite\Core\Request::getInstance()->operation;


        // $hash = \XLite\Core\Request::getInstance()->hash;
        // //$hash = $request->hash;
        // $query = \Ebanx\Ebanx::doQuery(array('integration_key'  => $this->getSetting('integrationkey'), //\Ebanx\Config::getIntegrationKey(),
        //                                      'hash'             => $hash
                                                                                    
        //                                      )
        // );
        //var_dump($request);
        //var_dump($hash);
        
        // var_dump(\Ebanx\Config::getIntegrationKey());
        
        // var_dump($query);
        // var_dump($query->payment->status);
        
        //var_dump($hash);
        //$var_str = var_export($request, true);
       /* $var = "<?php\n\n\$$text = $var_str;\n\n?>";
        file_put_contents('filename.php', $var);*/
        
        
        // if($query->payment->status == 'PE'){
        //     $status = $transaction::STATUS_PENDING;
        // }
        // if($query->payment->status == 'CO'){
        //     $status = $transaction::STATUS_SUCCESS;
        // }
        // if($query->payment->status == 'CA'){
        //     $status = $transaction::STATUS_CANCELED;
        // }
        // if($query->payment->status == 'CA'){
        //     $status = $transaction::STATUS_INPROGRESS;
        // }
      
        // $status = ('PE' == $query->payment->status)
        //     ? $transaction::STATUS_PENDING
        //     : $transaction::STATUS_SUCCESS;
     
        // if (isset($request->error_code)) {
        //     \XLite\Core\OrderHistory::getInstance()->registerTransaction($this->transaction->getOrder()->getOrderId(), 'Error description: ' . $query->status_message);
        //     $transaction->setDataCell('status', $query->status_message, null, 'C');
        // } 
     
        $this->transaction->setStatus($transaction::STATUS_PENDING);
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
    }

    public function getReturnOwnerTransaction()
    {


      //  require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';
        
       // $method = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findOneBy(array('service_name' => 'Ebanx'));
       // $integrationkey = $method->getSetting('integrationkey');
       // $test = $method->getSetting('test');

       //    \Ebanx\Config::set(array(
      // 'integrationKey' => $integrationkey, //'d55ffec9c19a2891716dad68732dade9a312a6aeb7c874ead4a8c56dff4d7c38a49c51d4977827e7d61bb9eee3b2696bcc6a', //$this->getSetting('integrationkey'),
      //  'testMode' =>  $test
        
      //      ) );


        // var_dump(\XLite\Core\Request::getInstance()->merchant_payment_code);
        // echo "uhudfihudf";
        // var_dump(\XLite\Core\Database::getRepo('XLite\Model\Payment\Transaction')->findOneByPublicTxnId(\XLite\Core\Request::getInstance()->merchant_payment_code));
        // die;
     //   $hashes = array();
     //   $hashes = \XLite\Core\Request::getInstance()->hash_codes;
     //   var_dump($hashes);
    //    die;
        //$hash = $request->hash;
     //   $query = \Ebanx\Ebanx::doQuery(array('integration_key'  => $integrationkey, //\Ebanx\Config::getIntegrationKey(),
    //                                         'hash'             => $hash
                                                                                    
     //                                        )
      //  );

       // $merc_pay_code = $query->payment->merchant_payment_code;
        //var_dump($request);
        //var_dump($hash);
        
        // var_dump(\Ebanx\Config::getIntegrationKey());
        
        //var_dump($query);
        //var_dump($query->payment->status);
        


        //var_dump(\XLite\Core\Database::getRepo('XLite\Model\Payment\Transaction')->findOneByPublicTxnId(\XLite\Core\Request::getInstance()->merchant_payment_code));

        return \XLite\Core\Request::getInstance()->merchant_payment_code
            ? \XLite\Core\Database::getRepo('XLite\Model\Payment\Transaction') //->findOneByPublicTxnId('rVHdi-w1wZcJuFn0')
                ->find(
                \XLite\Core\Request::getInstance()->merchant_payment_code
                )
            
            : null;
    }


    public function processCallback(\XLite\Model\Payment\Transaction $transaction)
    {
        //parent::processCallback($transaction);
        

        require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';
        $method = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findOneBy(array('service_name' => 'Ebanx'));
        $integrationkey = $method->getSetting('integrationkey');
        $test = $method->getSetting('test');

        \Ebanx\Config::set(array(
        'integrationKey' => $integrationkey, //'d55ffec9c19a2891716dad68732dade9a312a6aeb7c874ead4a8c56dff4d7c38a49c51d4977827e7d61bb9eee3b2696bcc6a', //$this->getSetting('integrationkey'),
        'testMode' =>  $test
        ));

        $request = \XLite\Core\Request::getInstance();
        $hashes = explode(',', $request->hash_codes);

        

        foreach ($hashes as $hash) 
        {   
                
                $query = \Ebanx\Ebanx::doQuery(array('hash' => $hash));
                $status = null;
                $transaction = \XLite\Core\Database::getRepo('XLite\Model\Payment\Transaction') //->findOneByPublicTxnId('rVHdi-w1wZcJuFn0')
                ->find(
                    $query->payment->merchant_payment_code
                );
                
                if($query->payment->status == 'PE'){
                    $status = $transaction::STATUS_PENDING;
                    echo 'STATUS PENDING';
            
            
                }
                 if($query->payment->status == 'CO'){
                    $status = $transaction::STATUS_SUCCESS;
                 echo 'STATUS SUCCESS';
            
            
                }
                if($query->payment->status == 'CA'){
                    $status = $transaction::STATUS_CANCELED;
                    echo 'STATUS CANCELED';
        
            
                }
                if($query->payment->status == 'OP'){
                    $status = $transaction::STATUS_INPROGRESS;
                    echo 'STATUS OPENED';
            
            
                }

                $transaction->setStatus($status);
                $transaction->getOrder()->setPaymentStatusByTransaction($transaction);

        }
    }   

    public function getCallbackOwnerTransaction()
    {
        require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';
        $method = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findOneBy(array('service_name' => 'Ebanx'));
        $integrationkey = $method->getSetting('integrationkey');
        $test = $method->getSetting('test');

        \Ebanx\Config::set(array(
        'integrationKey' => $integrationkey, //'d55ffec9c19a2891716dad68732dade9a312a6aeb7c874ead4a8c56dff4d7c38a49c51d4977827eef7d61bb9eee3b2696bcc6a', //$this->getSetting('integrationkey'),
        'testMode' =>  $test
        ));

        $request = \XLite\Core\Request::getInstance();
        $hashes = explode(',', $request->hash_codes);

        $result = \Ebanx\Ebanx::doQuery(array('hash' => $hashes[0]));
        // var_dump($hashes);
        // die;

        




        return $result->payment->merchant_payment_code

            ? \XLite\Core\Database::getRepo('XLite\Model\Payment\Transaction') //->findOneByPublicTxnId('rVHdi-w1wZcJuFn0')
                ->find(
                $result->payment->merchant_payment_code
                )
            
            : null;
    }


protected function getFormFields()
{
    return     $params = array(
        'integrationkey'        => $this->getSetting('integrationkey')
       ,'payment_type_code'     => '_all'
       ,'currency_code'               => $this->getCurrencyCode() //$order->getCurrency()->getCode()         //$this->getSetting('currency')
       ,'amount'                => $this->getOrder()->getCurrency()->roundValue($this->transaction->getOrder()->getTotal()) //$this->transaction->getValue()
       ,'merchant_payment_code' => $this->transaction->getTransactionId()
       ,'name'                  => $this->getProfile()->getBillingAddress()->getFirstname() . ' ' . $this->getProfile()->getBillingAddress()->getLastname()
       ,'email'                 => $this->getProfile()->getLogin()
       ,'zipcode'               => $this->getProfile()->getBillingAddress()->getZipcode()
       ,'url'                   => $this->getReturnURL('merchant_payment_code')


    );
    
}
// protected function assembleFormBody()
// $this->getReturnURL('merchant_payment_code',false,true) https://localhost/ebanx-xcart/?target=payment_return&txn_id_name=merchant_payment_code&cancel=1"
// {
//     return true;
// }



/*
	public function processReturn(\XLite\Model\Payment\Transaction $transaction)
	{  
        parent::processReturn($transaction);

        echo 'estamos acá';
        die;

        require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';

        $status = $transaction::STATUS_SUCCESS;

        $this->transaction->setStatus($status);

    /*

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