<?php

declare(strict_types=1);

namespace OleksiiBezpoiasnyi\RegularCustomer\Block;

use Magento\Framework\Phrase;
use OleksiiBezpoiasnyi\RegularCustomer\Model\DiscountRequest;
use OleksiiBezpoiasnyi\RegularCustomer\Api\Data\DiscountRequestInterface;

class PersonalDiscountInfo extends \Magento\Framework\View\Element\Template
{
    private \OleksiiBezpoiasnyi\RegularCustomer\Model\Api\DiscountRequestRepository $discountRequestRepository;
    private \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder;
    private \Magento\Store\Model\StoreManagerInterface $storeManager;
    private \Magento\Customer\Model\Session $customerSession;

    /**
     * PersonalDiscountInfo constructor.
     * @param \OleksiiBezpoiasnyi\RegularCustomer\Model\Api\DiscountRequestRepository $discountRequestRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \OleksiiBezpoiasnyi\RegularCustomer\Model\Api\DiscountRequestRepository $discountRequestRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->discountRequestRepository = $discountRequestRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
    }

    /**
     * @return DiscountRequestInterface[]
     */
    public function getPersonalDiscount(): array
    {
        $this->searchCriteriaBuilder->addFilter('customer_id', $this->customerSession->getCustomer()->getId());
        $this->searchCriteriaBuilder->addFilter('website_id', $this->storeManager->getStore()->getWebsiteId());
        $searchResult = $this->discountRequestRepository->getList($this->searchCriteriaBuilder->create());

        return $searchResult->getItems();
    }

    /**
     * @param DiscountRequestInterface $discountRequest
     * @return Phrase
     */
    public function getStatusMessage(DiscountRequestInterface $discountRequest): Phrase
    {
        switch ($discountRequest->getStatus()) {
            case DiscountRequest::STATUS_PENDING:
                return __('pending');
            case DiscountRequest::STATUS_APPROVED:
                return __('approved');
            case DiscountRequest::STATUS_DECLINED:
            default:
                return __('declined');
        }
    }
}
