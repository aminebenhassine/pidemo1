<?php

namespace EspritEntreAide\StoreBundle\Form;

use EspritEntreAide\StoreBundle\Entity\Store;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbrCopie')
            ->add('idStore',EntityType::class,array(
                'class'=>Store::class,
                'choice_label'=>'nomStore'
            ))
            ->add('deadline')

            ->add('Ajouter',SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'espritentreaide_storebundle_store';
    }


}
