<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['placeholder' => 'Nom de famille']
            ])
            ->add('fullname', null, [
                'attr' => ['placeholder' => 'Prénom']
            ])
            ->add('email', null, [
                'attr' => ['placeholder' => 'exemple@exostflash.ovh']
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['placeholder' => 'Entrez votre mot de passe']
            ])
            ->add(
                'address',
                null,
                [
                    'attr' => ['placeholder' => '265 chemin de l\'exemple, 31840 Exemple']
                ]
            )
            ->add('grade', null, [
                'attr' => ['placeholder' => 'Client/Waiter/Chef/Root']
            ])
            ->add('id_resto');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
