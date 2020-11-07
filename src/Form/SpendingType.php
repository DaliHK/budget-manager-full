<?php

namespace App\Form;

use App\Entity\Spending;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SpendingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',  DateType::class, [
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'Montant'
            ])
            ->add('name', TextType::class, [
                'label' => 'Intitulé'
            ])
            ->add(
                'is_by_instalment',
                CheckboxType::class,
                [ 
                'required' => false,
                'label' => 'Paiement en plusieurs fois',
                ]
            )
            ->add('instalment_amount', MoneyType::class, [
                'label' => 'Montant de la mensualité',
                'required' => false
            ])
            ->add('instalment_ending_date', DateType::class, [
                'label' => 'Date de la dernière mensualité'
            ])
            ->add(
                'instalment_ending_date',
                DateType::class,
                [
                    'label' => 'Date de fin du paiement en plusieurs fois',
                    'required' => false
                ]
            )
            ->add(
                'is_fixed_cost',
                CheckboxType::class,
                [ 
                'required' => false,
                'label' => 'Charge fixe',
                ]
            )
            ->add('saveAndAdd', SubmitType::class, ['label' => 'Enregistrer la dépense']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spending::class,
        ]);
    }
}