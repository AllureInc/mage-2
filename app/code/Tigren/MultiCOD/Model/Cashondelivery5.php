<?php
/**
 * Copyright (c) 2017 www.tigren.com
 */

namespace Tigren\MultiCOD\Model;

/**
 * Pay In Store payment method model
 */
class Cashondelivery5 extends \Magento\Payment\Model\Method\AbstractMethod
{

    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'cashondelivery5';

    /**
     * @return string
     */
    public function getInstructions()
    {
        return trim($this->getConfigData('instructions'));
    }
}