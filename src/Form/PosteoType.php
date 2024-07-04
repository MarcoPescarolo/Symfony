<?php

namespace App\Form;

use App\Entity\Posteo;
use App\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PosteoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('descripcion')
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'titulo',
                'placeholder' => 'Selecciona una categoría',
            ])
            ->add('tag', TextType::class, [
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posteo::class,
        ]);
    }
}
