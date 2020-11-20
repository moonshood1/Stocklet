<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productName',TextType::class,$this->getConfiguration("Nom du Produit",""))
            ->add('productDescription1', TextareaType::class, $this->getConfiguration("Description du produit",""))
            ->add('productDescription2', TextareaType::class, $this->getConfiguration("Seconde description du produit",""))
            ->add('unitPrice',IntegerType::class,$this->getConfiguration("Prix du produit",""))
            ->add('oldUnitPrice',IntegerType::class,$this->getConfiguration("ancien prix du produit",""))
            ->add('productAvailable',ChoiceType::class,['choices' => ['Indisponible' => false,'Disponible'=>true]])
            ->add('brand',TextType::class,$this->getConfiguration("Marque du Produit",""))
            ->add('initialStock',IntegerType::class,$this->getConfiguration("Stock de départ du produit","", ['attr' => ['min' => 1,'step' => 1 ]]))
            ->add('currentStock',IntegerType::class,$this->getConfiguration("Stock de actuel du produit","", ['attr' => ['min' => 1,'step' => 1 ]]))
            ->add('spec1', TextareaType::class, $this->getConfiguration("Description de la Spécification 1",""))
            ->add('spec1Title',TextType::class,$this->getConfiguration("Titre de la Spécification 1",""))
            ->add('spec2', TextareaType::class, $this->getConfiguration("Description de la Spécification 2",""))
            ->add('spec2Title',TextType::class,$this->getConfiguration("Titre de la Spécification 2",""))
            ->add('spec3', TextareaType::class, $this->getConfiguration("Description de la Spécification 3",""))
            ->add('spec3Title',TextType::class,$this->getConfiguration("Titre de la Spécification 3",""))
            ->add('endDate',DateTimeType::class,$this->getConfiguration("Date de fin d'affiche du produit",""))
            ->add('leftPic1URL', UrlType::class,$this->getConfiguration("Url de l'image 1",""))
            ->add('leftPic2URL', UrlType::class,$this->getConfiguration("Url de l'image 2",""))
            ->add('leftPic3URL', UrlType::class,$this->getConfiguration("Url de l'image 3",""))
            ->add('rightPic1Url', UrlType::class,$this->getConfiguration("Url de l'image de droite 1",""))
            ->add('rightPic2Url', UrlType::class,$this->getConfiguration("Url de l'image de droite 2",""))
            ->add('rightPic3Url', UrlType::class,$this->getConfiguration("Url de l'image de droite 3",""))
            ->add('rightPic4Url', UrlType::class,$this->getConfiguration("Url de l'image de droite 4",""))
            ->add('rightPic5Url', UrlType::class,$this->getConfiguration("Url de l'image de droite 5",""))
            ->add('leftPic1File', FileType::class,$this->getConfiguration("Upload de l'image 1",""),['required'=> false])
            ->add('leftPic2File', FileType::class,$this->getConfiguration("Upload de l'image 2",""),['required'=> false])
            ->add('leftPic3File', FileType::class,$this->getConfiguration("Upload de l'image 3",""),['required'=> false])
            ->add('rightPic1File', FileType::class,$this->getConfiguration("Upload de l'image de doite 1",""),['required'=> false])
            ->add('rightPic2File', FileType::class,$this->getConfiguration("Upload de l'image de doite 2",""),['required'=> false])
            ->add('rightPic3File', FileType::class,$this->getConfiguration("Upload de l'image de doite 3",""),['required'=> false])
            ->add('rightPic4File', FileType::class,$this->getConfiguration("Upload de l'image de doite 4",""),['required'=> false])
            ->add('rightPic5File', FileType::class,$this->getConfiguration("Upload de l'image de doite 5",""),['required'=> false])
            ->add('category', EntityType::class,['class'=> Category::class,'choice_label'=> 'categoryName'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
