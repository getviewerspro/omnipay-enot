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

/**
 * Enot Abstract Request.
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $zeroAmountAllowed = false;

    /**
     * Get the purse.
     * @return string purse
     */
    public function getPurse()
    {
        return $this->getParameter('purse');
    }

    /**
     * Set the purse.
     * @param string $purse purse
     * @return self
     */
    public function setPurse($value)
    {
        return $this->setParameter('purse', $value);
    }

    /**
     * Get the secret key.
     * @return string secret key
     */
    public function getSign()
    {
        return $this->getParameter('sign');
    }

    /**
     * Set the secret key.
     * @param string $key secret key
     * @return self
     */
    public function setSign($value)
    {
        return $this->setParameter('sign', $value);
    }

    /**
     * Get the secret key.
     * @return string secret key
     */
    public function getSign2()
    {
        return $this->getParameter('sign_2');
    }

    /**
     * Set the secret key.
     * @param string $key secret key
     * @return self
     */
    public function setSign2($value)
    {
        return $this->setParameter('sign_2', $value);
    }
}
