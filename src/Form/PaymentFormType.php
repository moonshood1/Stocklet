<?php

namespace App\Form;

use App\Entity\PaymentCard;
use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentFormType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardNumber', TextType::class, $this->getConfiguration("Numéro de la carte",""))
            ->add('month', IntegerType::class,$this->getConfiguration("Mois","", ['attr' => ['min' => 1,'max'=> 12,'step' => 1 ]]))
            ->add('cvv',IntegerType::class,$this->getConfiguration("CVV","",['attr' => ['min' => 000,'step' => 1 ]]))
            ->add('year',IntegerType::class, $this->getConfiguration("Année","", ['attr' => ['min' => 2020,'step' => 1 ]]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaymentCard::class,
        ]);
    }
}
