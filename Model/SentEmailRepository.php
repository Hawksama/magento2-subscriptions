<?php

declare(strict_types=1);

namespace Mollie\Subscriptions\Model;

use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mollie\Subscriptions\Api\Data\SentEmailInterface;
use Mollie\Subscriptions\Api\Data\SentEmailInterfaceFactory;
use Mollie\Subscriptions\Api\Data\SentEmailSearchResultsInterface;
use Mollie\Subscriptions\Api\Data\SentEmailSearchResultsInterfaceFactory;
use Mollie\Subscriptions\Api\SentEmailRepositoryInterface;
use Mollie\Subscriptions\Model\ResourceModel\SentEmail as ResourceSentEmail;
use Mollie\Subscriptions\Model\ResourceModel\SentEmail\CollectionFactory as SentEmailCollectionFactory;

class SentEmailRepository implements SentEmailRepositoryInterface
{
    /**
     * @var ResourceSentEmail
     */
    private $resource;
    /**
     * @var SentEmailFactory
     */
    private $sentEmailFactory;
    /**
     * @var SentEmailCollectionFactory
     */
    private $sentEmailCollectionFactory;
    /**
     * @var SentEmailSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var JoinProcessorInterface
     */
    private $extensionAttributesJoinProcessor;
    /**
     * @var ExtensibleDataObjectConverter
     */
    private $extensibleDataObjectConverter;

    public function __construct(
        ResourceSentEmail $resource,
        SentEmailFactory $sentEmailFactory,
        SentEmailCollectionFactory $sentEmailCollectionFactory,
        SentEmailSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->sentEmailFactory = $sentEmailFactory;
        $this->sentEmailCollectionFactory = $sentEmailCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * @throws \Exception
     */
    public function save(SentEmailInterface $entity): SentEmailInterface
    {
        $sentEmailData = $this->extensibleDataObjectConverter->toNestedArray(
            $entity,
            [],
            SentEmailInterface::class
        );

        $sentEmailModel = $this->sentEmailFactory->create()->setData($sentEmailData);

        try {
            $this->resource->save($sentEmailModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the sentEmail: %1',
                $exception->getMessage()
            ));
        }
        return $sentEmailModel->getDataModel();
    }

    /**
     * @throws NoSuchEntityException
     */
    public function get(int $id): SentEmailInterface
    {
        $sentEmail = $this->sentEmailFactory->create();
        $this->resource->load($sentEmail, $id);
        if (!$sentEmail->getId()) {
            throw new NoSuchEntityException(__('SentEmail with id "%1" does not exist.', $id));
        }
        return $sentEmail->getDataModel();
    }

    public function getList(SearchCriteriaInterface $criteria): SentEmailSearchResultsInterface
    {
        $collection = $this->sentEmailCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            SentEmailInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(SentEmailInterface $sentEmail): bool
    {
        try {
            $sentEmailModel = $this->sentEmailFactory->create();
            $this->resource->load($sentEmailModel, $sentEmail->getEntityId());
            $this->resource->delete($sentEmailModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the SentEmail: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById(int $id): bool
    {
        return $this->delete($this->get($id));
    }
}
