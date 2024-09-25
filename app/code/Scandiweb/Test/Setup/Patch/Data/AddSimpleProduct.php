<?php

namespace Scandiweb\Test\Setup\Patch\Data;

use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory;
use Magento\InventoryApi\Api\SourceItemsSaveInterface;
use Magento\Store\Model\StoreManagerInterface;

class AddSimpleProduct implements DataPatchInterface
{
    // Declaring dependencies for creating and saving a product
    private $productFactory;
    private $productRepo;
    private $appState;
    private $storeManager;
    private $sourceItemFactory;
    private $sourceItemsSave;
    private $eavSetup;
    private $categoryLink;
    private $sourceItems = [];

    /**
     * Constructor to initialize required services
     *
     * @param ProductInterfaceFactory $productFactory - Factory for creating product instances
     * @param ProductRepositoryInterface $productRepo - Repository for saving product instances
     * @param State $appState - Application state for emulating areas
     * @param StoreManagerInterface $storeManager - Store manager to get store-specific data
     * @param EavSetup $eavSetup - EAV setup for getting attribute set ID
     * @param SourceItemInterfaceFactory $sourceItemFactory - Factory for creating source items (inventory)
     * @param SourceItemsSaveInterface $sourceItemsSave - Interface for saving source items (inventory)
     * @param CategoryLinkManagementInterface $categoryLink - Interface for managing category links for products
     */
    public function __construct(
        ProductInterfaceFactory $productFactory,
        ProductRepositoryInterface $productRepo,
        State $appState,
        StoreManagerInterface $storeManager,
        EavSetup $eavSetup,
        SourceItemInterfaceFactory $sourceItemFactory,
        SourceItemsSaveInterface $sourceItemsSave,
        CategoryLinkManagementInterface $categoryLink
    ) {
        $this->productFactory = $productFactory;
        $this->productRepo = $productRepo;
        $this->appState = $appState;
        $this->storeManager = $storeManager;
        $this->eavSetup = $eavSetup;
        $this->sourceItemFactory = $sourceItemFactory;
        $this->sourceItemsSave = $sourceItemsSave;
        $this->categoryLink = $categoryLink;
    }

    /**
     * Apply function executed by Magento's setup:upgrade command
     * Emulates adminhtml area to execute product creation process
     */
    public function apply(): void
    {
        $this->appState->emulateAreaCode('adminhtml', [$this, 'execute']);
    }

    public function execute(): void
    {
        // Create product instance
        $product = $this->productFactory->create();

        // Check if product with this SKU already exists to avoid duplicates
        if ($product->getIdBySku('demo-product')) {
            return; 
        }

        // Get the attribute set ID for the default attribute set
        $attributeSetId = $this->eavSetup->getAttributeSetId(Product::ENTITY, 'Default');

        // Get the website ID for the current store
        $websiteIds = [$this->storeManager->getStore()->getWebsiteId()];

        // Set product details and properties
        $product->setTypeId(Type::TYPE_SIMPLE) 
            ->setWebsiteIds($websiteIds) 
            ->setAttributeSetId($attributeSetId) 
            ->setName('Demo Product') 
            ->setUrlKey('demo-product') 
            ->setSku('demo-product') 
            ->setPrice(19.99)
            ->setVisibility(Visibility::VISIBILITY_BOTH)
            ->setStatus(Status::STATUS_ENABLED)
            ->setStockData(['use_config_manage_stock' => 1, 'is_qty_decimal' => 0, 'is_in_stock' => 1]); 

        // Save the product to the repository
        $this->productRepo->save($product);

        // Create inventory source item for the product
        $sourceItem = $this->sourceItemFactory->create();
        $sourceItem->setSourceCode('default') 
            ->setQuantity(50) 
            ->setSku($product->getSku()) // Associate inventory with product SKU
            ->setStatus(SourceItemInterface::STATUS_IN_STOCK); // Mark as in stock
        $this->sourceItems[] = $sourceItem;

        // Save the source items to the inventory
        $this->sourceItemsSave->execute($this->sourceItems);

        // Assign the product to a category by category ID (e.g., 2)
        $this->categoryLink->assignProductToCategories($product->getSku(), [2]);
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}
