<?php

namespace Sylius\Bundle\ReviewBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating', 'choice', array('choices' => array_combine(range(1,5), range(1,5))))
            ->add('title', 'text')
            ->add('comment', 'textarea');
    }

    public function getName()
    {
        return 'sylius_review';
    }
}
