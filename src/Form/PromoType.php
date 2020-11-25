<?php

namespace App\Form;

use App\Entity\Promo;
use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromoType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('promoCode',TextType::class,$this->getConfiguration("Nom du code promo",""))
            ->add('promoReduction',IntegerType::class,$this->getConfiguration("Pourcentage de réduction","",['attr'=> ['min'=> 5,'step'=> 5]]))
            ->add('isActive',ChoiceType::class,$this->getConfiguration("Est Actif","",['choices'=>['Actif'=> true, 'Inactif' => false]]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Promo::class,
        ]);
    }
}
