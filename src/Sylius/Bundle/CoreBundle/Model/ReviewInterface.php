<?php

namespace Sylius\Bundle\CoreBundle\Model;

use Sylius\Bundle\ReviewBundle\Model\ReviewInterface as BaseReviewInterface;

/**
 * Product Review Interface
 */
interface ReviewInterface extends BaseReviewInterface
{
    /**
     * Get Product.
     *
     * @return ProductInterface
     */
    public function getProduct();

    /**
     * Set Product.
     *
     * @param ProductInterface $product
     */
    public function setProduct(ProductInterface $product);
}
