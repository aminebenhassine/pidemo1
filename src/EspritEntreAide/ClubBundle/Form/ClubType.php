<?php

namespace EspritEntreAide\ClubBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClubType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomC')
            ->add('mailC')
            ->add('dateCreation')
            //->add('idUser')
            ->add('descC')
            ->add('image', FileType::class, array('label' => 'Image(PNG)','data_class'=>null))
            ->add('idUser',EntityType::class,array(
                'class'=>"EspritEntreAide\UserBundle\Entity\User",
                'choice_label'=>"email",
                'multiple'=>false
            ))

            ->add('Ajouter',SubmitType ::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EspritEntreAide\ClubBundle\Entity\Club'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'espritentreaide_clubbundle_club';
    }


}
