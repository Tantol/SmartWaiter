<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\User;

class UserType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('username', Type\TextType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )
        ))
                ->add('email', Type\EmailType::class, array(
            'attr' => array(
                'class' => 'form-control'
            )
        ))
                ->add('password', Type\RepeatedType::class, array(
            'type' => Type\PasswordType::class,
            'invalid_message' => 'The password fields must match.',
            'options' => array(
                'attr' => array(
                'class' => 'password-field')),
            'required' => true,
            'first_options'  => array( 
                'attr' => array(
                 'class' => 'form-control'), 
                'label' => 'Password'),
            'second_options' => array( 
                'attr' => array(
                 'class' => 'form-control'), 
                'label' => 'Repeat password')
                    ))
                ->add('submit', Type\SubmitType::class, [
                    'attr' => [
                        'class' => 'btn btn-success'
                    ]
                ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

