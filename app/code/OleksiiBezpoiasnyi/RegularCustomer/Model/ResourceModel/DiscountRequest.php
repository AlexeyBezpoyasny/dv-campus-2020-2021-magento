<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;

class DiscountRequest extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $_idFieldName = 'request_id';

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('oleksiib_regular_customer', 'request_id');
    }

    /**
     * @throws LocalizedException
     * @throws \Zend_Validate_Exception
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object): DiscountRequest
    {
        $email = $object->getData('email');

        if (!\Zend_Validate::is($email, \Magento\Framework\Validator\EmailAddress::class)) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }

        return parent::_beforeSave($object);
    }
}
