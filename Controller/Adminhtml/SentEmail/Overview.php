<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Subscriptions\Controller\Adminhtml\SentEmail;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Overview extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        $page = $this->pageFactory->create();
        $page->setActiveMenu('Mollie_Subscriptions::reminder_overview');
        $page->getConfig()->getTitle()->prepend(__('Sent Subscription Emails'));

        return $page;
    }
}
