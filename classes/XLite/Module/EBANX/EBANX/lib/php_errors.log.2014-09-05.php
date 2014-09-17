<?php die(1); ?>
[05-Sep-2014 03:45:00 UTC] PHP Fatal error:  Class 'Ebanx\Ebanx' not found in /srv/www/xc/var/run/classes/XLite/Module/EBANX/EBANX/Model/Payment/Processor/Ebanx.php on line 118
[05-Sep-2014 00:45:00] Error (code: 1): Class 'Ebanx\Ebanx' not found
Server API: apache2handler;
Request method: GET;
URI: /xc/cart.php?target=payment_return&txn_id_name=merchant_payment_code&hash=540928944433e0a4cd713f6901a964239498020c892fe6b0&merchant_payment_code=44&payment_type_code=boleto;
Backtrace: 
#0  Includes\ErrorHandler::logInfo(Class 'Ebanx\Ebanx' not found, 1) called at [/srv/www/xc/Includes/ErrorHandler.php:320]
#1  Includes\ErrorHandler::handleError(Array ([type] => 1,[message] => Class 'Ebanx\Ebanx' not found,[file] => /srv/www/xc/var/run/classes/XLite/Module/EBANX/EBANX/Model/Payment/Processor/Ebanx.php,[line] => 118)) called at [/srv/www/xc/Includes/ErrorHandler.php:305]
#2  Includes\ErrorHandler::shutdown()


[05-Sep-2014 00:52:55] Error (code: 0): The command call received no arguments.
Server API: apache2handler;
Request method: GET;
URI: /xc/cart.php?target=payment_return&txn_id_name=merchant_payment_code&hash=540928944433e0a4cd713f6901a964239498020c892fe6b0&merchant_payment_code=44&payment_type_code=boleto;
Backtrace: 
#0 /srv/www/xc/var/run/classes/XLite/Module/EBANX/EBANX/Model/Payment/Processor/Ebanx.php(119): Ebanx\Ebanx::__callStatic('doQuery', Array)
#1 /srv/www/xc/var/run/classes/XLite/Module/EBANX/EBANX/Model/Payment/Processor/Ebanx.php(119): Ebanx\Ebanx::doQuery(NULL)
#2 /srv/www/xc/var/run/classes/XLite/Controller/Customer/PaymentReturnAbstract.php(67): XLite\Module\EBANX\EBANX\Model\Payment\Processor\Ebanx->processReturn(Object(XLite\Model\Payment\Transaction))
#3 /srv/www/xc/var/run/classes/XLite/Module/CDev/XPaymentsConnector/Controller/Customer/PaymentReturn.php(75): XLite\Controller\Customer\PaymentReturnAbstract->doActionReturn()
#4 /srv/www/xc/var/run/classes/XLite/Controller/AController.php(1215): XLite\Module\CDev\XPaymentsConnector\Controller\Customer\PaymentReturn->doActionReturn()
#5 /srv/www/xc/var/run/classes/XLite/Controller/AController.php(1234): XLite\Controller\AController->callAction()
#6 /srv/www/xc/var/run/classes/XLite/Controller/AController.php(468): XLite\Controller\AController->run()
#7 /srv/www/xc/var/run/classes/XLite/Controller/Customer/ACustomerAbstract.php(287): XLite\Controller\AController->handleRequest()
#8 /srv/www/xc/var/run/classes/XLite.php(449): XLite\Controller\Customer\ACustomerAbstract->handleRequest()
#9 /srv/www/xc/var/run/classes/XLite.php(474): XLite->runController()
#10 /srv/www/xc/cart.php(35): XLite->processRequest()
#11 {main}

[05-Sep-2014 01:02:50] Error (code: 0): The command call received no arguments.
Server API: apache2handler;
Request method: GET;
URI: /xc/cart.php?target=payment_return&txn_id_name=merchant_payment_code&hash=540928944433e0a4cd713f6901a964239498020c892fe6b0&merchant_payment_code=44&payment_type_code=boleto;
Backtrace: 
#0 /srv/www/xc/var/run/classes/XLite/Module/EBANX/EBANX/Model/Payment/Processor/Ebanx.php(119): Ebanx\Ebanx::__callStatic('doQuery', Array)
#1 /srv/www/xc/var/run/classes/XLite/Module/EBANX/EBANX/Model/Payment/Processor/Ebanx.php(119): Ebanx\Ebanx::doQuery(NULL)
#2 /srv/www/xc/var/run/classes/XLite/Controller/Customer/PaymentReturnAbstract.php(67): XLite\Module\EBANX\EBANX\Model\Payment\Processor\Ebanx->processReturn(Object(XLite\Model\Payment\Transaction))
#3 /srv/www/xc/var/run/classes/XLite/Module/CDev/XPaymentsConnector/Controller/Customer/PaymentReturn.php(75): XLite\Controller\Customer\PaymentReturnAbstract->doActionReturn()
#4 /srv/www/xc/var/run/classes/XLite/Controller/AController.php(1215): XLite\Module\CDev\XPaymentsConnector\Controller\Customer\PaymentReturn->doActionReturn()
#5 /srv/www/xc/var/run/classes/XLite/Controller/AController.php(1234): XLite\Controller\AController->callAction()
#6 /srv/www/xc/var/run/classes/XLite/Controller/AController.php(468): XLite\Controller\AController->run()
#7 /srv/www/xc/var/run/classes/XLite/Controller/Customer/ACustomerAbstract.php(287): XLite\Controller\AController->handleRequest()
#8 /srv/www/xc/var/run/classes/XLite.php(449): XLite\Controller\Customer\ACustomerAbstract->handleRequest()
#9 /srv/www/xc/var/run/classes/XLite.php(474): XLite->runController()
#10 /srv/www/xc/cart.php(35): XLite->processRequest()
#11 {main}

