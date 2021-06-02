<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Observer;

use Magento\Customer\Model\Customer;
use Magento\Framework\Event\Observer;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;
use OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection;

class GuestToCustomerDiscountRequests implements \Magento\Framework\Event\ObserverInterface
{
    private \Magento\Customer\Model\Session $customerSession;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory;

    private \Magento\Framework\DB\TransactionFactory $transactionFactory;

    /**
     * GuestToCustomerDiscountRequests constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->collectionFactory = $collectionFactory;
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws \Exception
     */
    public function execute(Observer $observer): void
    {
        /** @var Customer $customer */
        $customer = $observer->getData('customer');
        $customerId = $customer->getId();
        $guestEmail = $this->customerSession->getData('guest_email');
        $guestProductList = $this->customerSession->getData('product_list');

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('product_id', ['in' => $guestProductList])
            ->addFieldToFilter('customer_id', ['null' => true])
            ->addFieldToFilter('email', $guestEmail);

        $transaction = $this->transactionFactory->create();

        /** @var DiscountRequest $discountRequest */
        foreach ($collection as $discountRequest) {
            $this->validateEmail($discountRequest->getEmail());
            $discountRequest->setCustomerId($customerId);
            $transaction->addObject($discountRequest);
        }

        $transaction->save();
    }

    /**
     * @param $email
     */
    private function validateEmail ($email): void
    {
        if (filter_var($email, \FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException('Request(s) cannot be merged because email is not valid');
        }
    }
}
