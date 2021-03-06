<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\CoreBundle\Model;

use PhpSpec\ObjectBehavior;
use Sylius\Bundle\CoreBundle\Model\OrderInterface;

/**
*
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderSpec extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\CoreBundle\Model\Order');
    }

    function it_should_implement_Sylius_order_interface()
    {
        $this->shouldImplement('Sylius\Bundle\SalesBundle\Model\OrderInterface');
    }

    function it_should_extend_Sylius_order_mapped_superclass()
    {
        $this->shouldHaveType('Sylius\Bundle\SalesBundle\Model\Order');
    }

    function it_should_not_have_user_defined_by_default()
    {
        $this->getUser()->shouldReturn(null);
    }

    /**
     * @param Sylius\Bundle\CoreBundle\Model\UserInterface $user
     */
    function it_should_allow_defining_user($user)
    {
        $this->setUser($user);
        $this->getUser()->shouldReturn($user);
    }

    function it_should_not_have_shipping_address_by_default()
    {
        $this->getShippingAddress()->shouldReturn(null);
    }

    /**
     * @param Sylius\Bundle\AddressingBundle\Model\AddressInterface $address
     */
    function it_should_allow_defining_shipping_address($address)
    {
        $this->setShippingAddress($address);
        $this->getShippingAddress()->shouldReturn($address);
    }

    function it_should_not_have_billing_address_by_default()
    {
        $this->getBillingAddress()->shouldReturn(null);
    }

    /**
     * @param Sylius\Bundle\AddressingBundle\Model\AddressInterface $address
     */
    function it_should_allow_defining_billing_address($address)
    {
        $this->setBillingAddress($address);
        $this->getBillingAddress()->shouldReturn($address);
    }

    function it_should_initialize_inventory_units_collection_by_default()
    {
        $this->getInventoryUnits()->shouldHaveType('Doctrine\Common\Collections\Collection');
    }

    /**
     * @param Sylius\Bundle\CoreBundle\Model\InventoryUnitInterface $unit
     */
    function it_should_add_inventory_units_properly($unit)
    {
        $unit->setOrder($this)->shouldBeCalled();
        $this->addInventoryUnit($unit);
    }

    /**
     * @param Sylius\Bundle\CoreBundle\Model\InventoryUnitInterface $unit
     */
    function it_should_remove_inventory_units_properly($unit)
    {
        $unit->setOrder($this)->shouldBeCalled();
        $this->addInventoryUnit($unit);

        $this->hasInventoryUnit($unit)->shouldReturn(true);

        $unit->setOrder(null)->shouldBeCalled();
        $this->removeInventoryUnit($unit);

        $this->hasInventoryUnit($unit)->shouldReturn(false);
    }

    function it_should_initialize_shipments_collection_by_default()
    {
        $this->getShipments()->shouldHaveType('Doctrine\Common\Collections\Collection');
    }

    /**
     * @param Sylius\Bundle\CoreBundle\Model\ShipmentInterface $shipment
     */
    function it_should_add_shipment_properly($shipment)
    {
        $this->hasShipment($shipment)->shouldReturn(false);

        $shipment->setOrder($this)->shouldBeCalled();
        $this->addShipment($shipment);

        $this->hasShipment($shipment)->shouldReturn(true);
    }

    /**
     * @param Sylius\Bundle\CoreBundle\Model\ShipmentInterface $shipment
     */
    function it_should_remove_shipment_properly($shipment)
    {
        $shipment->setOrder($this)->shouldBeCalled();
        $this->addShipment($shipment);

        $this->hasShipment($shipment)->shouldReturn(true);

        $shipment->setOrder(null)->shouldBeCalled();
        $this->removeShipment($shipment);

        $this->hasShipment($shipment)->shouldReturn(false);
    }

    /**
     * helper method
     *
     * @param Sylius\Bundle\CoreBundle\Model\OrderInterface $order
     * @param Sylius\Bundle\SalesBundle\Model\AdjustmentInterface $shippingAdjustment
     * @param Sylius\Bundle\SalesBundle\Model\AdjustmentInterface $taxAdjustment
     */
    protected function addShippingAndTaxAdjustments($order, $shippingAdjustment, $taxAdjustment)
    {
        $shippingAdjustment->getLabel()->willReturn(OrderInterface::SHIPPING_ADJUSTMENT);
        $shippingAdjustment->setAdjustable($order)->shouldBeCalled();
        $taxAdjustment->getLabel()->willReturn(OrderInterface::TAX_ADJUSTMENT);
        $taxAdjustment->setAdjustable($order)->shouldBeCalled();

        $order->addAdjustment($shippingAdjustment);
        $order->addAdjustment($taxAdjustment);
    }

    /**
     * @param Sylius\Bundle\SalesBundle\Model\AdjustmentInterface $shippingAdjustment
     * @param Sylius\Bundle\SalesBundle\Model\AdjustmentInterface $taxAdjustment
     */
    function it_should_return_shipping_adjustments($shippingAdjustment, $taxAdjustment)
    {
        $this->addShippingAndTaxAdjustments($this, $shippingAdjustment, $taxAdjustment);

        $this->getAdjustments()->count()->shouldReturn(2); //both adjustments have been added

        $shippingAdjustments = $this->getShippingAdjustments();
        $shippingAdjustments->count()->shouldReturn(1); //but here we only get shipping
        $shippingAdjustments->first()->shouldReturn($shippingAdjustment);
    }

    /**
     * @param Sylius\Bundle\SalesBundle\Model\AdjustmentInterface $shippingAdjustment
     * @param Sylius\Bundle\SalesBundle\Model\AdjustmentInterface $taxAdjustment
     */
    function it_should_remove_shipping_adjustments($shippingAdjustment, $taxAdjustment)
    {
        $this->addShippingAndTaxAdjustments($this, $shippingAdjustment, $taxAdjustment);

        $this->getAdjustments()->count()->shouldReturn(2); //both adjustments have been added

        $shippingAdjustment->setAdjustable(null)->shouldBeCalled();
        $this->removeShippingAdjustments();

        $this->getAdjustments()->count()->shouldReturn(1); //one has been removed
        $this->getShippingAdjustments()->count()->shouldReturn(0); //shipping adjustment has been removed
    }

    /**
     * @param Sylius\Bundle\SalesBundle\Model\AdjustmentInterface $shippingAdjustment
     * @param Sylius\Bundle\SalesBundle\Model\AdjustmentInterface $taxAdjustment
     */
    function it_should_return_tax_adjustments($shippingAdjustment, $taxAdjustment)
    {
        $this->addShippingAndTaxAdjustments($this, $shippingAdjustment, $taxAdjustment);

        $this->getAdjustments()->count()->shouldReturn(2); //both adjustments have been added

        $taxAdjustments = $this->getTaxAdjustments();
        $taxAdjustments->count()->shouldReturn(1); //but here we only get tax
        $taxAdjustments->first()->shouldReturn($taxAdjustment);
    }

    /**
     * @param Sylius\Bundle\SalesBundle\Model\AdjustmentInterface $shippingAdjustment
     * @param Sylius\Bundle\SalesBundle\Model\AdjustmentInterface $taxAdjustment
     */
    function it_should_remove_tax_adjustments($shippingAdjustment, $taxAdjustment)
    {
        $this->addShippingAndTaxAdjustments($this, $shippingAdjustment, $taxAdjustment);

        $this->getAdjustments()->count()->shouldReturn(2); //both adjustments have been added

        $taxAdjustment->setAdjustable(null)->shouldBeCalled();
        $this->removeTaxAdjustments();

        $this->getAdjustments()->count()->shouldReturn(1); //one has been removed
        $this->getTaxAdjustments()->count()->shouldReturn(0); //tax adjustment has been removed
    }

    /*
    function it_should_not_have_currency_defined_by_default()
    {
        $this->getCurrency()->shouldReturn(null);
    }
    */

    function it_should_allow_defining_currency()
    {
        $this->setCurrency('PLN');
        $this->getCurrency()->shouldReturn('PLN');
    }
}
