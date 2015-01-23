<?php
 
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

namespace XLite\Module\EBANX\EBANX\Model\Payment\Processor;

class Ebanx extends \XLite\Model\Payment\Base\WebBased
{

    protected function callEbanxLib()
    {
        require_once LC_DIR_MODULES . 'EBANX/EBANX/ebanx-php/src/autoload.php';

        $method = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findOneBy(array('service_name' => 'Ebanx'));
        $test = $method->getSetting('test');

        \Ebanx\Config::set(array(
            'integrationKey' => $method->getSetting('integrationkey'),
            'testMode' => $method->getSetting('test') == 'true' ?  true : false,
        ));
    }

    protected function assembleFormBody()
    {
        return true;
    }

    protected function getFormURL()
    {
        $this->callEbanxLib();

        $params = array();
        $params = $this->getFormFields();

        $response = \Ebanx\Ebanx::doRequest($params);

        if($response->status == 'SUCCESS')
        {
            $checkoutURL = $response->redirect_url;
        }
        else
        {
            \XLite\Core\TopMessage::addError('Erro processando pagamento! EBANX: ' . $response->status_code . ": " . $response->status_message);
            return ;
        }

        return $checkoutURL;
    }

    public function processReturn(\XLite\Model\Payment\Transaction $transaction)
    {  
        parent::processReturn($transaction);
    
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
        
        $this->callEbanxLib();

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
                    echo "STATUS PENDING\n";
                }
                if($query->payment->status == 'CO')
                {
                    if(isset($query->payment->refunds))
                    {
                        $transaction->getPaymentTransaction()->getOrder()->setPaymentStatus(
                            \XLite\Model\Order\Status\Payment::STATUS_REFUNDED
                        );
                        echo "STATUS REFUNDED\n";
                    }

                    else
                    {
                        if (isset($result->payment->chargeback))
                        {
                            return "SKIP: payment was not updated due to chargeback.";
                        }
                        else
                        {
                            $status = $transaction::STATUS_SUCCESS;
                            echo "STATUS SUCCESS\n"; 
                        }
  
                    }
        
                }
                if($query->payment->status == 'CA')
                {
                    $status = $transaction::STATUS_CANCELED;
                    echo "STATUS CANCELED\n";
                }
                if($query->payment->status == 'OP')
                {
                    $status = $transaction::STATUS_INPROGRESS;
                    echo "STATUS OPENED\n";                      
                }

                $transaction->setStatus($status);
                $transaction->getOrder()->setPaymentStatusByTransaction($transaction);
            }
            else
            {
                echo "Failure in contacting EBANX\n";   
            }
        }
    }   

    public function getCallbackOwnerTransaction()
    {
        $this->callEbanxLib();

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
           ,'currency_code'         => $this->getCurrencyCode()
           ,'amount'                => $this->getOrder()->getCurrency()->roundValue($this->transaction->getOrder()->getTotal())
           ,'merchant_payment_code' => $this->transaction->getTransactionId()
           ,'order_number'          => $this->getOrder()->getOrderId()
           ,'name'                  => $this->getProfile()->getBillingAddress()->getFirstname() . ' ' . $this->getProfile()->getBillingAddress()->getLastname()
           ,'email'                 => $this->getProfile()->getLogin()
           ,'zipcode'               => $this->getProfile()->getBillingAddress()->getZipcode()
           ,'url'                   => $this->getReturnURL('merchant_payment_code')
           ,'country'               => $this->getCountryCode() //\XLite::getController()->getCart()->getProfile()
           );
    }
                        
    public function getSettingsWidget()
    {
        return 'modules/EBANX/EBANX/config.tpl';
    }

    public function isTestMode(\XLite\Model\Payment\Method $method)
    {
        return $method->getSetting('test') != 'false';
    }
    
    public function isConfigured(\XLite\Model\Payment\Method $method)
    {
        return parent::isConfigured($method)
            && $method->getSetting('integrationkey');
    }

    public function getAdminIconURL(\XLite\Model\Payment\Method $method)
    {
        return true;
    }

    protected function getCurrencyCode()
    {
        return strtoupper($this->getOrder()->getCurrency()->getCode());
    }

    protected function getCountryCode()
    {   
        $country = strtoupper($this->getProfile()->getBillingAddress()->getCountry()->getCode3());

        if($country == 'PER')
        {
            $country = 'pe';
        }

        if($country == 'BRA')
        {
            $country = 'br';
        }

        return $country;
    }

    public function getCheckoutTemplate(\XLite\Model\Payment\Method $method)
    {
        return 'modules/EBANX/EBANX/checkout.tpl';
    }
}