<?php
/**
 * Enot driver for Omnipay PHP payment library
 *
 * @link      https://github.com/getviewerspro/omnipay-enot
 * @package   omnipay-enot
 * @license   MIT
 * @copyright Copyright (c) 2020, getViewersPRO (https://getviewers.pro/)
 */

namespace Omnipay\Enot\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate(
            'purse',
            'amount', 
            'transactionId'
        );

        return array_filter([
            'm'             => $this->getPurse(),
            'oa'            => $this->getAmount(),
            'o'             => $this->getTransactionId(),
            's'             => $this->calculateSignature(),
            'c'             => $this->getDescription(),
            'p'             => $this->getPaymentMethod(),
            'cr'            => $this->getCurrency(),
            'paymentMethod' =>  $this->getPaymentMethod() // for QIWI oplata.to
        ]);
    }

    public function calculateSignature()
    {
        return md5(implode(':', [
            $this->getPurse(),
            $this->getAmount(),
            $this->getSign(),
            $this->getTransactionId()
        ]));

    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
