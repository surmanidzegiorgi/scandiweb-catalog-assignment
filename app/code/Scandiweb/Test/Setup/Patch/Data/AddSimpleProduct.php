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

    /**
     * @var ProductInterfaceFactory Factory for creating product instances.
     */
    protected ProductInterfaceFactory $productFactory;

    /**
     * @var ProductRepositoryInterface Repository for saving product instances.
     */
    protected ProductRepositoryInterface $productRepo;

    /**
     * @var State Application state for emulating areas.
     */
    protected State $appState;

    /**
     * @var StoreManagerInterface Store manager to get store-specific data.
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var EavSetup EAV setup for getting attribute set ID.
     */
    protected EavSetup $eavSetup;

    /**
     * @var SourceItemInterfaceFactory Factory for creating source items (inventory).
     */
    protected SourceItemInterfaceFactory $sourceItemFactory;

    /**
     * @var SourceItemsSaveInterface Interface for saving source items (inventory).
     */
    protected SourceItemsSaveInterface $sourceItemsSave;

    /**
     * @var CategoryLinkManagementInterface Interface for managing category links for products.
     */
    protected CategoryLinkManagementInterface $categoryLink;

    /**
     * @var array Array to hold source items data.
     */
    protected array $sourceItems = [];

   /**
    * AddSimpleProduct constructor.
    * @param ProductInterfaceFactory $productFactory
    * @param ProductRepositoryInterface $productRepo
    * @param State $appState
    * @param StoreManagerInterface $storeManager
    * @param EavSetup $eavSetup
    * @param SourceItemInterfaceFactory $sourceItemFactory
    * @param SourceItemsSaveInterface $sourceItemsSave
    * @param CategoryLinkManagementInterface $categoryLink
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
     * Emulates adminhtml area to execute product creation process.
     *
     * @return void
     */
    public function apply(): void
    {
        $this->appState->emulateAreaCode('adminhtml', [$this, 'execute']);
    }

    /**
     * Executes the product creation process with inventory and category assignment.
     *
     * @return void
     */
    public function execute(): void
    {
        $product = $this->productFactory->create();

        if ($product->getIdBySku('demo-product')) {
            return; 
        }

        $attributeSetId = $this->eavSetup->getAttributeSetId(Product::ENTITY, 'Default');
        $websiteIds = [$this->storeManager->getStore()->getWebsiteId()];

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

        $this->productRepo->save($product);

        $sourceItem = $this->sourceItemFactory->create();
        $sourceItem->setSourceCode('default')
            ->setQuantity(50)
            ->setSku($product->getSku())
            ->setStatus(SourceItemInterface::STATUS_IN_STOCK);

        $this->sourceItems[] = $sourceItem;

        $this->sourceItemsSave->execute($this->sourceItems);
        $this->categoryLink->assignProductToCategories($product->getSku(), [2]);
    }

    /**
     * Returns an array of dependencies for this class.
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Returns an array of aliases for this class.
     *
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }
}
