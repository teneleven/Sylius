<?php

namespace Sylius\Bundle\ReviewBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GuestReviewType extends ReviewType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
        	->add('name', 'text')
        	->add('email', 'text');
    }

    public function getName()
    {
        return 'guest_review';
    }
}
