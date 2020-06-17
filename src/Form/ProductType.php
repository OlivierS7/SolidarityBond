<?php

namespace App\Form;

use App\Entity\Products;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nom'])
            ->add('price', null, ['label' => 'Prix'])
            ->add('status', HiddenType::class, ['label' => 'Disponible'])
            ->add('description', null, ['label' => 'Description'])
            ->add('category',null, [
                'label' => 'Catégorie',
                'choice_label' => 'name'
            ])
            ->add('image', FileType::class, array(
                'label' => 'Image',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
