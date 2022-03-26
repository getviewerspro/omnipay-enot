<?php
/**
 * Enot driver for Omnipay PHP payment library
 *
 * @link      https://github.com/getviewerspro/omnipay-enot
 * @package   omnipay-enot
 * @license   MIT
 * @copyright Copyright (c) 2020, getViewersPRO (https://getviewers.pro/)
 */

namespace Omnipay\Enot;

use Omnipay\Common\AbstractGateway;

/**
 * Gateway for ePayService.
 */
class Gateway extends AbstractGateway
{
    /**
     *
     */
    public function getName()
    {
        return 'Enot';
    }

    /**
     *
     */
    public function getDefaultParameters()
    {
        return [
            'purse' => '',
            'sign'     => '',
            'sign_2'     => '',
        ];
    }

    /**
     * Get the unified purse.
     * @return string merchant purse
     */
    public function getPurse()
    {
        return $this->getParameter('purse');
    }

    /**
     * Set the unified purse.
     * @param string $purse merchant purse
     * @return self
     */
    public function setPurse($value)
    {
        return $this->setParameter('purse', $value);
    }

    /**
     * Get the unified secret key.
     * @return string secret key
     */
    public function getSign()
    {
        return $this->getParameter('sign');
    }

    /**
     * Set the unified secret key.
     * @param string $value secret key
     * @return self
     */
    public function setSign($value)
    {
        return $this->setParameter('sign', $value);
    }

    /**
     * Get the unified secret key.
     * @return string secret key
     */
    public function getSign2()
    {
        return $this->getParameter('sign2');
    }

    /**
     * Set the unified secret key.
     * @param string $value secret key
     * @return self
     */
    public function setSign2($value)
    {
        return $this->setParameter('sign2', $value);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\ePayService\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Enot\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\ePayService\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Enot\Message\CompletePurchaseRequest', $parameters);
    }
}
