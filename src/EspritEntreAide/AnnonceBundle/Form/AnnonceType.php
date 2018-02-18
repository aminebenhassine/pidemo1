<?php

namespace EspritEntreAide\AnnonceBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categorieA',ChoiceType::class,
            array('choices'
            => array('permutation' => 'permutation','collocation' => 'collocation' ,
                    'covoiturage' => 'covoiturage' ,'ObjetTrouve' => 'ObjetTrouve' ,'ObjetPerdu' => 'ObjetPerdu' )))
            ->add('titreA')

            ->add('descA')
            ->add('numTel')
            /*->add('idUser',EntityType::class,array(
                'class'=>"EspritEntreAide\UserBundle\Entity\User",
                'choice_label'=>"email"

            ))*/
            ->add('ajouter',SubmitType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EspritEntreAide\AnnonceBundle\Entity\Annonce'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'espritentreaide_annoncebundle_annonce';
    }


}
