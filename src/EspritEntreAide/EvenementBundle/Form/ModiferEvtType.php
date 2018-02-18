<?php

namespace EspritEntreAide\EvenementBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModiferEvtType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titreE' )
            ->add('descE')
            ->add('dateE', DateTimeType::class)
            ->add('typeE',ChoiceType::class, array(
                'choices' =>array(
                    'Seminaire' => 'Seminaire',
                    'Workshop'=> 'Workshop',
                    'Culturel'=> 'Culturel',
                    'Gaming'=> 'Gaming',
                    'Coding'=> 'Coding',
                    'Sportif'=> 'Sportif',
                    'Autre'=> 'Autre'
                )))
            ->add('image', FileType::class, array('label' => 'Image(JPG)'))
            ->add('Modifier', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EspritEntreAide\EvenementBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'espritentreaide_evenementbundle_evenement';
    }


}
