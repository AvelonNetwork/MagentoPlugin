<?php


namespace AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Block\AddAvelonScript;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Quote\Model\QuoteRepository;

class AvelonOrderProcessedObserver implements ObserverInterface
{
    protected $logger;
    protected $addAvelonScript;
    protected $categoryRepository;
    protected $productRepository;
    protected $quoteRepository;

    public function __construct(
        LoggerInterface $logger,
        AddAvelonScript $addAvelonScript,
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository,
        QuoteRepository $quoteRepository
    ) {
        $this->logger = $logger;
        $this->addAvelonScript = $addAvelonScript;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->quoteRepository = $quoteRepository;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getIncrementId();

        $promoCodes = $order->getCouponCode();

        // Check if the order has Avelon CID and API token
        if ($this->isAvelonConfigured()) {


            if($promoCodes || $order->getAvlnCid()) {
                $webhookEndpoint = 'https://' . $this->addAvelonScript->getAvelonAccountId() . '.avln.me/purchase';
                //$webhookEndpoint = 'https://webhook.site/aedf53a1-075d-4541-a149-ec24524991e1';
                $currency = $order->getOrderCurrencyCode();
                // Retrieve order items
                $products = [];
                foreach ($order->getAllVisibleItems() as $item) {
                    $categories = $this->getProductCategories($item->getProductId());
                    $product = [
                        'item_price' => $item->getRowTotal(),
                        'item_currency' => $currency,
                        'item_id' => $item->getProductId(),
                        'item_name' => $item->getName(),
                        'item_quantity' => $item->getQtyOrdered()
                        //'item_metadata' => $item->getData()
                    ];
                    if(!empty($categories)) {
                        $product['item_category'] = implode(', ', $categories);
                    }
                    $products[] = $product;
                }

                // Construct webhook payload
                $payload = [
                    'transaction_id' => $orderId,
                    'items' => $products,
                    'currency' => $currency,
                ];

                if($order->getAvlnCid()) {
                    $payload["avln_cid"] = $order->getAvlnCid();
                }

                if($promoCodes) {
                    $payload['promo_codes'] = [$promoCodes];
                }

                // Send webhook payload to external system
                try {
                    $this->sendWebhookPayload($webhookEndpoint, $payload);
                } catch (\Exception $e) {
                    // Log the error but allow the script to continue
                    $this->logger->error('Error sending webhook payload: ' . $e->getMessage());
                }
            }
        }
    }

    protected function isAvelonConfigured()
    {
        // Check if Avelon account ID is configured
        return (bool) $this->addAvelonScript->getAvelonAccountId();
    }

    protected function getProductCategories($productId)
    {
        $categories = [];
        try {
            $product = $this->productRepository->getById($productId);
            $categoryIds = $product->getCategoryIds();
            foreach ($categoryIds as $categoryId) {
                $category = $this->categoryRepository->get($categoryId);
                $categories[] = $category->getName();
            }
        } catch (\Exception $e) {
            $this->logger->error('Error getting product categories: ' . $e->getMessage());
        }
        return $categories;
    }

    protected function sendWebhookPayload($webhookEndpoint, $payload)
    {
        $avelonApiToken = $this->addAvelonScript->getAvelonApiToken();
        $httpClient = new \GuzzleHttp\Client();
        $response = $httpClient->post($webhookEndpoint, [
            'json' => $payload,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $avelonApiToken
            ],
        ]);

        $this->logger->info('Webhook payload sent: ' . json_encode($payload));
    }
}