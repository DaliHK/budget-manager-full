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
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'js-datepicker']
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'Montant total'
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
            ->add('nb_instalments', MoneyType::class, [
                'label' => 'Nombre de mensualités',
                'required' => false
            ])
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
