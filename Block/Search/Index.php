<?php

namespace Genesisoft\SearchSeller\Block\Search;
//use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory as AttributeCollectionFactory;
use Magento\Eav\Model\Config;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Response\Http;
use Magento\Catalog\Model\Product as ProductEntityType;
use Magento\Eav\Api\Data\AttributeInterface;

class Index extends \Magento\Framework\View\Element\Template
{
//    protected $_attribute;
    private $attributeFactory;
    private $eavConfig;
    protected $response;
    protected $storeManagerInterface;

    public function __construct(
//        Collection $attribute,
        AttributeCollectionFactory $attributeFactory,
        Config $eavConfig,
        Template\Context $context,
        array $data = [],
        Http $response,
        StoreManagerInterface $storeManagerInterface
    )
    {
//        $this->_attribute = $attribute;
        $this->eavConfig = $eavConfig;
        $this->attributeFactory = $attributeFactory;
        $this->response = $response;
        $this->storeManagerInterface = $storeManagerInterface;
        parent::__construct($context, $data);
    }

    public function carregarCidades()
    {
        $collection = $this->attributeFactory->create();
        $collection->addFieldToFilter('entity_type_id', $this->eavConfig->getEntityType(ProductEntityType::ENTITY)->getEntityTypeId());
        $attributeCodes = [];
        $html = "";

        foreach ($collection as $attributes) {
            $valorAttributo = $attributes->getData(AttributeInterface::ATTRIBUTE_CODE);
            if ($valorAttributo == 'cidade_produto') {
                $allOptionsAttribute = $attributes->getOptions();
                $html = "<select id='selectCityForSeller' class='form-control' >";
                $html .= "<option value=''>Selecione uma cidade</option>";
                foreach ($allOptionsAttribute as $item) {
                    $option = $item->getData();
                    if (!empty($option['value']) && !empty($option['label'])) {
                    $html .= "<option value='" . $option['value'] . "'>" . $option['label'] . "</option>";
                    }
                }
                $html .= "</select>";
            }
        }
        return $html;
    }

    public function carregarLojas(){
        $collection = $this->attributeFactory->create();
        $collection->addFieldToFilter('entity_type_id', $this->eavConfig->getEntityType(ProductEntityType::ENTITY)->getEntityTypeId());
        $attributeCodes = [];
        $html = "";

        foreach ($collection as $attributes) {
            $valorAttributo = $attributes->getData(AttributeInterface::ATTRIBUTE_CODE);
            if ($valorAttributo == 'revendedor') {
                $allOptionsAttribute = $attributes->getOptions();
                $html = "<select id='selectReseller' class='form-control' >";
                $html .= "<option value=''>Selecione uma loja</option>";
                foreach ($allOptionsAttribute as $item) {
                    $option = $item->getData();
                    if (!empty($option['value']) && !empty($option['label'])) {
                        $html .= "<option value='" . $option['value'] . "'>" . $option['label'] . "</option>";
                    }
                }
                $html .= "</select>";
            }
        }
        return $html;
    }

    public function getBaseUrl(){
        return $this->storeManagerInterface->getStore()->getBaseUrl();
    }

    public function redirectAdvancedSearch(){
        $baseUrl = $this->storeManagerInterface->getStore()->getBaseUrl();
        /*$redirectUrl = $baseUrl."catalogsearch/advanced/result/?name=".$searchText."&cidade_produto=".$searchCity."";
        return $redirectUrl;*/
        //$this->response->setRedirect($redirectUrl);
    }
}
