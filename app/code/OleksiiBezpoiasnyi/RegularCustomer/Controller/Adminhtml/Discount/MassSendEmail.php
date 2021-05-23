<?php
declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Controller\Adminhtml\Discount;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DB\Transaction;
use OleksiiBezpoiasnyi\RegularCustomer\Model\Authorization;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;

class MassSendEmail extends AbstractMassAction
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST;

    private \OleksiiBezpoiasnyi\RegularCustomer\Model\Email $email;
    private \Magento\Catalog\Model\ProductRepository $productRepository;
    private \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository;
    private \Magento\Store\Model\StoreManager $storeManager;

    /**
     * MassSendEmail constructor.
     *
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transaction
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Backend\App\Action\Context $context
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\Email $email
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository
     * @param \Magento\Store\Model\StoreManager $storeManager
     */
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory,
        \Magento\Framework\DB\TransactionFactory $transaction,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Backend\App\Action\Context $context,
        \OleksiiBezpoiasnyi\RegularCustomer\Model\Email $email,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
        \Magento\Store\Model\StoreManager $storeManager
    ) {
        parent::__construct($filter, $discountRequestCollectionFactory, $transaction, $authSession, $context);
        $this->email = $email;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->storeManager = $storeManager;
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(): ResultInterface
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionFactory->create();
        $collection = $this->filter->getCollection($this->discountRequestCollectionFactory->create());
        $collection->addFieldToFilter(
            'status',
            ['in' => [DiscountRequest::STATUS_APPROVED, DiscountRequest::STATUS_DECLINED]]
        );

        /** @var DiscountRequest $discountRequest */
        $collectionSize = $collection->count();

        foreach ($collection as $discountRequest) {
            $customerEmail = $discountRequest->getCustomerId()
                ? $this->customerRepository->getById($discountRequest->getCustomerId())->getEmail()
                : $discountRequest->getEmail();
            $storeId = (int) $this->storeManager
                ->getWebsite($discountRequest->getWebsiteId())
                ->getDefaultStore()
                ->getId();
            $productName = $this->productRepository
                ->getById($discountRequest->getProductId(), false, $storeId)
                ->getName();

            if ($discountRequest->getStatus() == DiscountRequest::STATUS_APPROVED) {
                $this->email->sendRequestApprovedEmail($customerEmail, $productName, $storeId);
                $discountRequest->setEmailSent(1);
                $transaction->addObject($discountRequest);
            } else {
                $this->email->sendRequestDeclinedEmail($customerEmail, $productName, $storeId);
                $discountRequest->setEmailSent(1);
                $transaction->addObject($discountRequest);
            }
        }

        $transaction->save();
        $this->messageManager->addSuccessMessage(__('For %1 requests(s) was sent email.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
