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

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Enot Complete Purchase Response.
 */
class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @var CompletePurchaseRequest|RequestInterface
     */
    protected $request;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data    = $data;

        if ($this->getSign2() !== $this->calculateSignature()) {
            throw new InvalidResponseException('Invalid hash');
        }
    }

    public function isSuccessful()
    {
        return true;
    }

    public function calculateSignature()
    {
        return md5(implode(':', [
            $this->getPurse(),
            $this->getAmount(),
            $this->request->getSign2(),
            $this->getTransactionId()
        ]));
    }

    public function getTransactionId()
    {
        return $this->data['merchant_id'];
    }

    public function getPayer()
    {
        return $this->data['payer_details'] . ' / ' . $this->getPaymentSystem();
    }

    public function getTransactionReference()
    {
        return $this->data['intid'];
    }

    public function getPurse()
    {
        return $this->data['merchant'];
    }

    public function getAmount()
    {
        return (string)$this->data['amount'];
    }  

    public function getCurrency()
    {
        return (string)$this->data['currency'];
    }    
    
    public function getMoney()
    {
        return (string)$this->data['credited'];
    }

    public function getSign2()
    {
        return $this->data['sign_2'];
    }

    /**
     * @see https://enot.io/knowledge/payment-methods-codes
     * @return string
     */
    protected function getPaymentSystem()
    {
        $map = [
            'qw'    => 'QIWI',
            'ap'    => 'Apple Pay',
            'cd'    => 'Банковские карты',
            'ya'    => 'ЮMoney',
            'pm'    => 'Perfect Money',
            'trc20' => 'USDT (TRC-20)',
            'erc20' => 'USDT (ERC-20)',
        ];

        return isset($map[$this->data['method']])
            ? $map[$this->data['method']]
            : '';
    }
}
