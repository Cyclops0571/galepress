<?php

/**
 * Created by PhpStorm.
 * User: Serdar Saygili
 * Date: 07.01.2016
 * Time: 12:33
 * @property int QrcodeID
 * @property string QrSiteClientID
 * @property string Name
 * @property string Email
 * @property string Address
 * @property string City
 * @property string Phone
 * @property string TcNo
 * @property string Price
 * @property string Parameter
 * @property string CallbackUrl
 */
class Qrcode extends Eloquent
{
    public static $table = 'Qrcode';
    public static $key = 'QrcodeID';

    public function makeIyzicoIframeRequrest() {
        $name = explode(" ", $this->Name);
        $firstName = '';
        $lastName = '';
        for($i = 0; $i < count($name) - 1; $i++) {
            $firstName = $firstName . $name[$i] . " ";
        }

        $firstName = trim($firstName);
        $lastName = $name[count($name) -1];

        //<editor-fold desc="Request">
        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($this->QrcodeID);
        $request->setPrice($this->Price);
        $request->setPaidPrice($this->Price);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setBasketId($this->QrcodeID);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl(URL::to('checkout_result_form', null, false, false) . "?qrCodeId=" . $this->QrcodeID);
        $request->setEnabledInstallments(array(1, 2, 3, 6, 9));
        //</editor-fold>

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($this->QrSiteClientID);
        $buyer->setEmail($this->Email);
        $buyer->setName($firstName);
        $buyer->setSurname($lastName);
        $buyer->setIdentityNumber($this->TcNo);
        $buyer->setRegistrationAddress($this->Address);
        $buyer->setCity($this->City);
        $buyer->setCountry("Turkey");
        $request->setBuyer($buyer);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($this->Name);
        $billingAddress->setCity($this->City);
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress($this->Address);
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId($this->QrcodeID);
        $firstBasketItem->setName("Qrcode Kredisi");
        $firstBasketItem->setCategory1("Qr-Code Kredisi");
//        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        $firstBasketItem->setPrice($this->Price);
        $basketItems[] = $firstBasketItem;
        $request->setBasketItems($basketItems);

        # make request
        $options = new \Iyzipay\Options();
        $options->setApiKey(MyPayment::iyzicoApiKey);
        $options->setSecretKey(MyPayment::iyzicoSecretKey);
        $options->setBaseUrl(MyPayment::iyzicoBaseUrl);
        return \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);
    }
}