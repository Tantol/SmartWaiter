<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class StanMagazynowyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['edit'] === 'true'){
            $builder->add('ilosc')->add('cena')->add('dataUmieszczenia', DateType::class, array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd HH:mm:ss'))
            ->add('dostawca')->add('produkt');
        } else {
            $builder->add('ilosc')->add('cena')
            ->add('dostawca')->add('produkt');
        }
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\StanMagazynowy',
            'edit' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_stanmagazynowy';
    }


}
