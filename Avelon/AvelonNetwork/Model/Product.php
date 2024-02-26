<?php

namespace Avelon\AvelonNetwork\Model;

use Avelon\AvelonNetwork\Api\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Store\Model\StoreManagerInterface;

class Product implements ProductInterface
{
    protected $productRepository;
    protected $searchCriteriaBuilder;
    protected $imageHelper;
    protected $storeManager;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ImageHelper $imageHelper,
        StoreManagerInterface $storeManager
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->imageHelper = $imageHelper;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritdoc
     */
    public function getProducts()
    {

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $products = $this->productRepository->getList($searchCriteria)->getItems();
        $storeCurrency = $this->storeManager->getStore()->getCurrentCurrency()->getCode();

        $productsData = [];

        // Loop through each product and retrieve relevant data
        foreach ($products as $product) {
            $productData = $product->getData();
            // Adjust data as needed
            $imageUrl = ''; // Initialize image URL
            $image = $this->imageHelper->init($product, 'product_page_image_small')
                ->setImageFile($product->getImage())->getUrl();
            if ($image) {
                // If image exists, get its URL
                $imageUrl = $image;
            }
            // Add image URL to product data
            $productData['image_url'] = $imageUrl;
            // Add product data to products array
            $productsData[] = $productData;
        }

        $productfeed = array(
            "currency" => $storeCurrency,
            "products" => $productsData,
        );

        header("Content-Type: application/json; charset=utf-8");
        $this->response = json_encode($productfeed,JSON_UNESCAPED_SLASHES);
        print_r($this->response,false);
        die();
    }
}

