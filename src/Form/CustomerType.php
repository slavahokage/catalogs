<?php
declare(strict_types = 1);

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr'=>array('class'=>'form-control')))
            ->add('phone', TextType::class, array('attr'=>array('class'=>'form-control')))
            ->add('email', EmailType::class, array('attr'=>array('class'=>'form-control')))
            ->add('comment', TextType::class, array('attr'=>array('class'=>'form-control')))
            ->add('save', SubmitType::class, array('label' => 'Send', 'attr' => array('class' => 'btn btn-primary mt-3')));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Customer::class,
        ));
    }
}