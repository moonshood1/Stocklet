<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,$this->getConfiguration("Prénoms",""))
            ->add('lastName', TextType::class,$this->getConfiguration("Nom",""))
            ->add('email', EmailType::class,$this->getConfiguration("Adresse Email",""))
            ->add('password',PasswordType::class,$this->getConfiguration("Mot de passe",""))
            ->add('confirmPassword',PasswordType::class,$this->getConfiguration("Confirmation du mot de passe",""))
            ->add('picture', UrlType::class, $this->getConfiguration("Url de votre avatar",""))
            ->add('imageFile', FileType::class,$this->getConfiguration("Upload de votre avatar",""),['required'=> false])
            ->add('address', TextType::class,$this->getConfiguration("Adresse",""))
            ->add('userPhone', TextType::class,$this->getConfiguration("Numéro de téléphone",""));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
