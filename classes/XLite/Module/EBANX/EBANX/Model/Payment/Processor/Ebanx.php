<?php
namespace XLite\Module\EBANX\EBANX\Model\Payment\Processor;
 
/**
 * Copyright (c) 2014, EBANX Tecnologia da Informação Ltda.
 *  All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 *
 * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * Neither the name of EBANX nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

class Ebanx extends \XLite\Model\Payment\Base\WebBased
{

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
        ));

        $response = \Ebanx\Ebanx::doRequest($params);

        if($response->status == 'SUCCESS')
        {
            $checkoutURL = $response->redirect_url;
        }

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
            'integrationKey' => $integrationkey,
            'testMode' =>  $test
        ));
              
        $operation = \XLite\Core\Request::getInstance()->operation;
     
        $this->transaction->setStatus($transaction::STATUS_PENDING);
    }

    public function getReturnOwnerTransaction()
    {
        return \XLite\Core\Request::getInstance()->merchant_payment_code
            ? \XLite\Core\Database::getRepo('XLite\Model\Payment\Transaction')->find(\XLite\Core\Request::getInstance()->merchant_payment_code) 
            : null;
    }


    public function processCallback(\XLite\Model\Payment\Transaction $transaction)
    {
        parent::processCallback($transaction);
        
        require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';
        $method = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findOneBy(array('service_name' => 'Ebanx'));
        $integrationkey = $method->getSetting('integrationkey');
        $test = $method->getSetting('test');

        \Ebanx\Config::set(array(
            'integrationKey' => $integrationkey 
        ));

        $request = \XLite\Core\Request::getInstance();
        $hashes = explode(',', $request->hash_codes);

        foreach ($hashes as $hash) 
        {   
            $query = \Ebanx\Ebanx::doQuery(array('hash' => $hash));
            $status = null;
            if ($query->status == 'SUCCESS')
            {
                $transaction = \XLite\Core\Database::getRepo('XLite\Model\Payment\Transaction')->find($query->payment->merchant_payment_code);
                
                if($query->payment->status == 'PE')
                {
                    $status = $transaction::STATUS_PENDING;
                    echo 'STATUS PENDING';
                }
                if($query->payment->status == 'CO')
                {
                    $status = $transaction::STATUS_SUCCESS;
                    echo 'STATUS SUCCESS';           
                }
                if($query->payment->status == 'CA')
                {
                    $status = $transaction::STATUS_CANCELED;
                    echo 'STATUS CANCELED';
                }
                if($query->payment->status == 'OP')
                {
                    $status = $transaction::STATUS_INPROGRESS;
                    echo 'STATUS OPENED';                      
                }

                $transaction->setStatus($status);
                $transaction->getOrder()->setPaymentStatusByTransaction($transaction);
            }
            else
            {
                echo 'Failure in contacting EBANX';   
            }
        }
    }   

    public function getCallbackOwnerTransaction()
    {
        require_once LC_DIR_MODULES . 'EBANX/EBANX/lib/ebanx-php-master/src/autoload.php';
        $method = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findOneBy(array('service_name' => 'Ebanx'));
        $integrationkey = $method->getSetting('integrationkey');
        $test = $method->getSetting('test');

        \Ebanx\Config::set(array(
            'integrationKey' => $integrationkey,
            'testMode' =>  $test
        ));

        $request = \XLite\Core\Request::getInstance();
        $hashes = explode(',', $request->hash_codes);

        $result = \Ebanx\Ebanx::doQuery(array('hash' => $hashes[0]));

        return $result->payment->merchant_payment_code
            ? \XLite\Core\Database::getRepo('XLite\Model\Payment\Transaction')->find($result->payment->merchant_payment_code)
            : null;
    }

    protected function getFormFields()
    {
        return $params = array(
            'integrationkey'        => $this->getSetting('integrationkey')
           ,'payment_type_code'     => '_all'
           ,'currency_code'               => $this->getCurrencyCode()
           ,'amount'                => $this->getOrder()->getCurrency()->roundValue($this->transaction->getOrder()->getTotal())
           ,'merchant_payment_code' => $this->transaction->getTransactionId()
           ,'order_number'          => $this->getOrder()->getOrderId()
           ,'name'                  => $this->getProfile()->getBillingAddress()->getFirstname() . ' ' . $this->getProfile()->getBillingAddress()->getLastname()
           ,'email'                 => $this->getProfile()->getLogin()
           ,'zipcode'               => $this->getProfile()->getBillingAddress()->getZipcode()
           ,'url'                   => $this->getReturnURL('merchant_payment_code')
           );
    }
                        
	public function getSettingsWidget()
	{
	    return 'modules/EBANX/EBANX/config.tpl';
	}

	protected function getEbanxSettings()
	{
        return array(
            'integrationkey' => $this->getSetting('integrationkey')
           ,'test' => $this->getSetting('test') == 'true' ? true : false
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
                'USD', 'BRL'
        ));
    }

    protected function getCurrencyCode()
    {
        return strtoupper($this->getOrder()->getCurrency()->getCode());
    }
}