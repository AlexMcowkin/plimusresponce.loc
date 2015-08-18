<?php
/*
Instant Notifications (IPN) > Notification Types > IPN Code Example
IPN Code Example

The following PHP code example shows how a Merchant captures and logs the IPN data sent from BlueSnap.
*/

/*IPN Sample code
=================
This code gets all the parameters of "IPN", checks if the request came from a BlueSnap server (by IP) and sends the data to the system log.
*/
$BlueSnapIps = array("62.219.121.253", "209.128.93.248", "72.20.107.242", "209.128.93.229", "209.128.93.98", "209.128.93.230", "209.128.93.245", "209.128.93.104", "209.128.93.105", "209.128.93.107", "209.128.93.108", "209.128.93.242", "209.128.93.243", "209.128.93.254", "62.216.234.216", "62.216.234.218", "62.216.234.219", "62.216.234.220", "127.0.0.1","localhost", "209.128.104.18", "209.128.104.19", "209.128.104.20", "209.128.104.21", "209.128.104.22", "209.128.104.23", "209.128.104.24", "209.128.104.25", "209.128.104.26", "209.128.104.27", "209.128.104.28", "209.128.104.29", "209.128.104.30", "209.128.104.31", "209.128.104.32", "209.128.104.33", "209.128.104.34", "209.128.104.35", "209.128.104.36", "209.128.104.37", "99.186.243.9", "99.186.243.10", "99.186.243.11", "99.186.243.12", "99.186.243.13", "99.180.227.233", "99.180.227.234", "99.180.227.235", "99.180.227.236", "99.180.227.237");
 
//Check if the request came from BlueSnap IP
if (array_search($_SERVER['REMOTE_ADDR'], $BlueSnapIps) == false) {
	$txt = $_SERVER['REMOTE_ADDR'] . " is not a BlueSnap server!!!";
}
//Put IPN Parameters in local varibales
else
{
$transactionType = $_REQUEST['transactionType'];
$testMode = $_REQUEST['testMode'];
$referenceNumber = $_REQUEST['referenceNumber'];
$originalReferenceNumber = $_REQUEST['originalReferenceNumber'];
$paymentMethod = $_REQUEST['paymentMethod'];
$creditCardType = $_REQUEST['creditCardType'];
$transactionDate = $_REQUEST['transactionDate'];
$untilDate = $_REQUEST['untilDate'];
$productId = $_REQUEST['productId'];
$productName = $_REQUEST['productName'];
$contractId = $_REQUEST['contractId'];
$contractName = $_REQUEST['contractName'];
$contractOwner = $_REQUEST['contractOwner'];
$contractPrice = $_REQUEST['contractPrice'];
$quantity = $_REQUEST['quantity'];
$currency = $_REQUEST['currency'];
$addCD = $_REQUEST['addCD'];
$coupon = $_REQUEST['coupon'];
$couponValue = $_REQUEST['couponValue'];
$referrer = $_REQUEST['referrer'];
$accountId = $_REQUEST['accountId'];
$title = $_REQUEST['title'];
$firstName = $_REQUEST['firstName'];
$lastName = $_REQUEST['lastName'];
$company = $_REQUEST['company'];
$address1 = $_REQUEST['address1'];
$address2 = $_REQUEST['address2'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$country = $_REQUEST['country'];
$zipCode = $_REQUEST['zipCode'];
$email = $_REQUEST['email'];
$workPhone = $_REQUEST['workPhone'];
$extension = $_REQUEST['extension'];
$mobilePhone = $_REQUEST['mobilePhone'];
$homePhone = $_REQUEST['homePhone'];
$faxNumber = $_REQUEST['faxNumber'];
$licenseKey = $_REQUEST['licenseKey'];
$shippingFirstName = $_REQUEST['shippingFirstName'];
$shippingLastName = $_REQUEST['shippingLastName'];
$shippingAddress1 = $_REQUEST['shippingAddress1'];
$shippingAddress2 = $_REQUEST['shippingAddress2'];
$shippingCity = $_REQUEST['shippingCity'];
$shippingState = $_REQUEST['shippingState'];
$shippingCountry = $_REQUEST['shippingCountry'];
$shippingZipCode = $_REQUEST['shippingZipCode'];
$remoteAddress = $_REQUEST['remoteAddress'];
$shippingMethod = $_REQUEST['shippingMethod'];
$couponCode = $_REQUEST['couponCode'];
$invoiceAmount = $_REQUEST['invoiceAmount'];
$invoiceInfoURL = $_REQUEST['invoiceInfoURL'];
 
//Put IPN Promotions Parameters in local arrays
$promoteContractsNum = $_REQUEST['promoteContractsNum'];
for ($i=0; $i<$promoteContractsNum; $i++)
{
$promoteContracts[$i]['promoteContractId']= $_REQUEST["promoteContractId$i"];
$promoteContracts[$i]['promoteContractName'] = $_REQUEST["promoteContractName$i"];
$promoteContracts[$i]['promoteContractOwner'] = $_REQUEST["promoteContractOwner$i"];
$promoteContracts[$i]['promoteContractPrice'] = $_REQUEST["promoteContractPrice$i"];
$promoteContracts[$i]['promoteContractQuantity'] = $_REQUEST["promoteContractQuantity$i"];
$promoteContracts[$i]['promoteContractLicenseKey'] = $_REQUEST["promoteContractLicenseKey$i"];
}
 
//Add all parameters to a string
$now = date('m/d/Y H:i:s');
 
$txt = <<<ENDOFTEXT
<<<================= $now - BlueSnap Order #$referenceNumber ==================>>>
transactionType: $transactionType
testMode: $testMode
referenceNumber: $referenceNumber
originalReferenceNumber: $originalReferenceNumber
paymentMethod: $paymentMethod
creditCardType: $creditCardType
transactionDate: $transactionDate
untilDate: $untilDate
productId: $productId
productName: $productName
contractId: $contractId
contractName: $contractName
contractOwner: $contractOwner
contractPrice: $contractPrice
quantity: $quantity
currency: $currency
addCD: $addCD
coupon: $coupon
couponValue: $couponValue
referrer: $referrer
promoteContractsNum: $promoteContractsNum
accountId: $accountId
title: $title
firstName: $firstName
lastName: $lastName
company: $company
address1: $address1
address2: $address2
city: $city
state: $state
country: $country
zipCode: $zipCode
email: $email
workPhone: $workPhone
extension: $extension
mobilePhone: $mobilePhone
homePhone: $homePhone
faxNumber: $faxNumber
licenseKey: $licenseKey
shippingFirstName: $shippingFirstName
shippingLastName: $shippingLastName
shippingAddress1: $shippingAddress1
shippingAddress2: $shippingAddress2
shippingCity: $shippingCity
shippingState: $shippingState
shippingCountry: $shippingCountry
shippingZipCode: $shippingZipCode
remoteAddress: $remoteAddress
shippingMethod: $shippingMethod
couponCode: $couponCode
invoiceAmount: $invoiceAmount
invoiceInfoURL: $invoiceInfoURL
ENDOFTEXT;
 
//Add Promotions Text to string
for ($i=0; $i<$promoteContractsNum; $i++)
{
$promotion = $promoteContracts[$i];
$txt .= "\r\n +promotion $i: ";
$txt .= "\r\n promoteContractId $i:" . $promoteContracts[$i]['promoteContractId'];
$txt .= "\r\n promoteContractName $i:" . $promoteContracts[$i]['promoteContractName'];
$txt .= "\r\n promoteContractOwner $i:" . $promoteContracts[$i]['promoteContractOwner'];
$txt .= "\r\n promoteContractPrice $i:" . $promoteContracts[$i]['promoteContractPrice'];
$txt .= "\r\n promoteContractQuantity $i:" . $promoteContracts[$i]['promoteContractQuantity'];
$txt .= "\r\n promoteContractLicenseKey $i:" . $promoteContracts[$i]['promoteContractLicenseKey'];
}
 
$txt .= "\r\n<<<================= End Of BlueSnap Order #$referenceNumber ==================>>> \r\n";
}
//Print IPN Parameters to File Named "BlueSnap.txt"
$file = 'Plimus_IPN.log';
// Open the file to get existing content
//$current = file_get_contents($file);
// Append a new person to the file
//$current .= $txt;
// Write the contents back to the file
file_put_contents($file, $txt);
 
echo($txt);
?>