<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user_userName',TextType::class,$this->getConfiguration("  ","Votre Nom"))
            ->add('user_email',EmailType::class, $this->getConfiguration("  ","Votre adresse email"))
            ->add('user_subject',TextType::class, $this->getConfiguration("   ","Le sujet" ))
            ->add('content',TextareaType::class,$this->getConfiguration("   ","Votre message"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
