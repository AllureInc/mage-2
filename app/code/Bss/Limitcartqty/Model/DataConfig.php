<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category  BSS
 * @package   Bss_Limitcartqty
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 BSS Commerce Co. ( http://bsscommerce.com )
 * @license   http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Bss\Limitcartqty\Model;

use Bss\Limitcartqty\Api\DataConfigInterface;
use Bss\Limitcartqty\Helper\ConfigValue;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class DataConfig
 *
 * @package Bss\Limitcartqty\Model
 */
class DataConfig implements DataConfigInterface
{
    /**
     * @var
     */
    protected $customerGroupId;
    /**
     * @var
     */
    protected $storeId;
    /**
     * @var Session
     */
    protected $customerSession;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var ConfigValue
     */

    protected $configValue;

    /**
     * DataConfig constructor.
     *
     * @param Session $customerSession
     * @param StoreManagerInterface $storeManager
     * @param ConfigValue $configValue
     */
    public function __construct(
        Session $customerSession,
        StoreManagerInterface $storeManager,
        ConfigValue $configValue
    ) {
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->configValue = $configValue;
    }

    /**
     * GetMinValue
     *
     * @return float|mixed|null
     * @throws LocalizedException
     */
    public function getMinValue()
    {
        return $this->configValue->getMinConfigValue($this->getCustomerId());
    }

    /**
     * GetMaxValue
     *
     * @return float|mixed|null
     * @throws LocalizedException
     */
    public function getMaxValue()
    {
        return $this->configValue->getMaxConfigValue($this->getCustomerId());
    }

    /**
     * IsModuleEnable
     *
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function isModuleEnable()
    {
        return $this->configValue->isModuleEnable();
    }

    /**
     * GetCustomerId
     **
     * @return int|mixed
     */
    public function getCustomerId()
    {
        return $this->customerSession->getCustomerGroupId();
    }

    /**
     * GetStoreId
     *
     * @return int|mixed
     * @throws NoSuchEntityException
     */
    public function getStoreId()
    {
        if ($this->storeId === null) {
            $this->storeId = $this->storeManager->getStore()->getId();
        }
        return $this->storeId;
    }
}
