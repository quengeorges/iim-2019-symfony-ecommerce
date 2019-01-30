<?php
/**
 * Created by PhpStorm.
 * User: Banji
 * Date: 29/01/2019
 * Time: 23:54
 */

namespace App\Form;


use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('deliveryAddress')
            ->add('deliveryCity')
            ->add('deliveryCountry')
            ->add('deliveryZipcode')
            ->add('billingAddress')
            ->add('billingCity')
            ->add('billingCountry')
            ->add('billingZipcode')
            ->add('card')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}