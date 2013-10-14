<?php

namespace Sylius\Bundle\CoreBundle\Model;

use Sylius\Bundle\ReviewBundle\Model\Review as BaseReview;

/**
 * Review
 */
class Review extends BaseReview implements ReviewInterface
{
    /**
     * @var integer
     */
    private $product;

    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * {@inheritdoc}
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;

        return $this;
    }
}
