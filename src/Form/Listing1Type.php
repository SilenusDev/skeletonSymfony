<?php

namespace App\Form;

use App\Entity\Listing;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Listing1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('productionYear')
            ->add('mileage')
            ->add('price')
            ->add('createdAt')
            ->add('description')
            ->add('model' , EntityType::class , [
                'class' => Model::class,
                'choice_label' => 'name',
                'required' => true,
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
