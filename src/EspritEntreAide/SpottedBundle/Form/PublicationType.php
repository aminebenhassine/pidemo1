<?php

namespace EspritEntreAide\SpottedBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class PublicationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titreP', TextType::class, array('label' => false, 'attr'=> array('placeholder' => 'Titre','class'=>'validate[required,custom[onlyLetter],length[0,100]] feedback-input')))

            ->add('descP',TextareaType::class, array('label' => false, 'attr'=> array('placeholder' => 'Contenue','class'=>'validate[required,custom[onlyLetter],length[0,100]] feedback-input')))

            ->add('dateP', DateType::class,array('label' => false, 'attr'=> array('placeholder' => 'date','class'=>'validate[required,custom[onlyLetter],length[0,100]] feedback-input')))

            ->add('image', FileType::class,array('label' => 'Image(PNG)','data_class'=>null))
            ->add('categorieP', TextType::class,array('label' => false, 'attr'=> array('placeholder' => 'Categorie','class'=>'validate[required,custom[onlyLetter],length[0,100]] feedback-input')))
            ->add('note', TextType::class,array('label' => false, 'attr'=> array('placeholder' => 'Note','class'=>'validate[required,custom[onlyLetter],length[0,100]] feedback-input')));



       /* ->add('idUser',EntityType::class,array(
        'class'=>"EspritEntreAide\UserBundle\Entity\User"
    ))*/


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
       /* $resolver->setDefaults(array(
            'data_class' => 'EspritEntreAide\SpottedBundle\Entity\Publication'
        ));*/
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        //return 'espritentreaide_spottedbundle_publication';
    }


}
