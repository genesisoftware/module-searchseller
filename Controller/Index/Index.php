<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Genesisoft\SearchSeller\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $jsonResultFactory;
    protected $storeManagerInterface;
    protected $resultFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        ResultFactory $resultFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->resultFactory = $resultFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $searchText = $this->getRequest()->getPost('searchText');
        $searchCity = $this->getRequest()->getPost('searchCity');
        $searchReseller = $this->getRequest()->getPost('searchReseller');
//        if ($searchText && $searchCity){
            $baseUrl = $this->storeManagerInterface->getStore()->getBaseUrl();
            $redirectUrl = $baseUrl."catalogsearch/advanced/result/?name=".$searchText."&cidade_produto=".$searchCity."&revendedor=".$searchReseller;
            $data = Array("url" => $redirectUrl);
            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $resultJson->setData($data);
            return $resultJson;
//        }
    }
}
