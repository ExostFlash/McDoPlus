<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserSignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['placeholder' => 'Entrez votre nom de famille']
            ])
            ->add('fullname', null, [
                'attr' => ['placeholder' => 'Entrez votre prénom']
            ])
            ->add('mail', null, [
                'attr' => ['placeholder' => 'exemple@exostflash.ovh']
            ])
            ->add('mdp', PasswordType::class, [
                'attr' => ['placeholder' => 'Entrez votre mot de passe']
            ])
            ->add('address', null, [
                'attr' => ['placeholder' => '265 chemin de l\'exemple, 31840 Exemple']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
