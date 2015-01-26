# EBANX X-Cart Payment Gateway Extension

This plugin allows you to integrate your X-Cart store with the EBANX payment gateway.

## Requirements

* PHP >= 5.4
* cURL
* X-Cart >= v5.1

## Installation
### Source
1. Clone the git repo to your X-Cart root folder
```
git clone --recursive https://github.com/ebanx/ebanx-xcart.git
```
2. Visit your X-Cart admin page and click on 'System Settings' > 'Re-deploy the store' > 'OK'.
3. After the X-Cart redeploy, click on 'Extensions' > 'Installed Modules'.
4. Locate 'Ebanx', click on 'Enabled' and then in 'Save changes'.
5. Click on 'Store setup' > 'Payment methods'.
6. Under the 'Online methods' area, click on 'Add payment method', locate 'Ebanx' in the list and click 'Choose'.
7. Set the 'Integration key' field with the key given to you by the Integration Team, and set 'Test mode' accordingly.
8. Click 'Update'.
9. Set the payment method to 'Active'.
10. Go to the EBANX Merchant Area, then to **Integration > Merchant Options**.
  1. Change the _Status Change Notification URL_ to:
```
{YOUR_SITE}/?target=callback&txn_id_name=merchant_payment_code
```
  2. Change the _Response URL_ to:
```
{YOUR_SITE}/?target=payment_return&txn_id_name=merchant_payment_code
```
11. That's all!

## Changelog
* 1.1.0: added peruvian payment methods.
* 1.0.0: first release.
