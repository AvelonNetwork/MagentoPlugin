<?php

namespace AndrewAvelonetwork\AvelonNetworkAffiliateMarketing\Api;
/**
  * @api
  */

interface ProductInterface
{
    /**
     * Retrieve list of products
     *
     * @return mixed[]
     */
    public function getProducts();
}