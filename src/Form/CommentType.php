<?php

namespace App\Form;

use App\Entity\Comments;
use App\Entity\Users;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommentType extends AbstractType
{
    private $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => ' '
            ])
            ->add('user', EntityType::Class, [
                'class' => Users::class,
                'label' => 'Votre prénom et nom associés à cet email seront rendus publiques',
                'choice_label' => 'email',
                'choice_value' => 'id',
                'query_builder' => function (EntityRepository $us) {
                    return $us->createQueryBuilder('u')
                        ->where('u.id = :identifier')
                        ->setParameter('identifier', $this->user->getId());
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
