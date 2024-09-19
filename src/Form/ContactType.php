<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['class' => 'form-control']
            ])
            ->add(
                'email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control']
            ])
            ->add(
                'phoneNumber', TelType::class, [
                'label' => 'Numéro de Téléphone',
                'attr' => ['class' => 'form-control']
            ])->add(
                'addressSupplement', TelType::class, [
                'label' => 'Address Supplement',
                'attr' => ['class' => 'form-control']
            ])->add(
                'availability', TelType::class, [
                'label' => 'Availability',
                'attr' => ['class' => 'form-control']
            ])->add(
                'info', TelType::class, [
                'label' => 'Info',
                'attr' => ['class' => 'form-control']

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
