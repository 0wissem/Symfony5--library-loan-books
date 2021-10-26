<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('nbPages')
            ->add('dateEdition', DateType::class , ['widget'=>'single_text'])
            ->add('nbExemplaires')
            ->add('prix', NumberType::class,['attr'=>['value'=> 0]])
            ->add('isbn', NumberType::class, ['attr'=>['placeholder'=>'isbn 8 sur chiffres']])
            ->add('editeur')
            ->add('categorie', EntityType::class, ['class'=> Categorie::class , 'choice_label'=>'designation'])
            ->add('auteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
