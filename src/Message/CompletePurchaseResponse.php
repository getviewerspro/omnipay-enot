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

    public function isSuccessful()
    {
        return true;
    }

    public function getPayer()
    {
        return $this->data['P_EMAIL'] . ' / ' . $this->getPaymentSystem();
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

    public function getSign2()
    {
        return $this->data['sign_2'];
    }

    /**
     * @see http://www.free-kassa.ru/docs/api.php#ex_currencies
     * @return string
     */
    protected function getPaymentSystem()
    {
        $map = [
            'qw' => 'QIWI',
            'ap' => 'Apple Pay',
            'cd' => 'Банковские карты',
            'ya' => 'Яндекс.Деньги',
            'pa' => 'Payeer',
            'ad' => 'Advcash',
            'pm' => 'Perfect Money',
            'bt' => 'Bitcoin',
            'et' => 'Ethereum',
            'sp' => 'Samsung Pay',
            'bc' => 'Bitcoin Cash',
            'ds' => 'Dash',
            'lc' => 'Litecoin',
            'zc' => 'Zcash',
        ];

        return isset($map[$this->data['method']])
            ? $map[$this->data['method']]
            : '';
    }
}
