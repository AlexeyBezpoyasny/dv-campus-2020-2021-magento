<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Cron;

use OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;

class ApproveRequest
{
    private \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory;

    private \Magento\Framework\DB\TransactionFactory $transactionFactory;

    /**
     * ApproveRequest constructor.
     *
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     */

    public function __construct(
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->transactionFactory = $transactionFactory;
    }

    /** Approve requests when they older 3 days
     *
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        /** @var DiscountRequestCollection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('status', DiscountRequest::STATUS_PENDING)
            ->addFieldToFilter(
                'created_at',
                ['lt' => date('Y-m-d H:i:s', strtotime('-3 days'))]
            );

        $transaction = $this->transactionFactory->create();

        /** @var DiscountRequest $discountRequest */
        foreach ($collection as $discountRequest) {
            $discountRequest->setStatus(DiscountRequest::STATUS_APPROVED)
                ->setStatusChangedAt(time());
            $transaction->addObject($discountRequest);
        }

        $transaction->save();
    }
}
