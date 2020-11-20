<?php

namespace App\Form;

use App\Entity\Order;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CheckoutType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shippingCity', TextType::class, $this->getConfiguration("Ville",""))
            ->add('shippingDistrict', TextType::class, $this->getConfiguration("Quartier",""))
            ->add('shippingAddress1', TextType::class, $this->getConfiguration("Adresse Complète",""))
            ->add('shippingAddress2', TextType::class, $this->getConfiguration("Adresse secondaire",""))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
