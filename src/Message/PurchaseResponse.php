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

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Enot Purchase Response.
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $_redirect = 'https://enot.io/pay';
    protected $_redirect_qiwi = 'https://oplata.to/pay';

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
         $redirect = $this->_redirect;

        if (!empty($this->data['paymentMethod']) AND $this->data['paymentMethod'] == 'qw') {
            $redirect = $this->_redirect_qiwi;
            
            unset($this->data['paymentMethod']);
        }

        return $this->_redirect . '?' . http_build_query($this->getRedirectData());
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return $this->data;
    }
}
