<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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
            ->add('password', HiddenType::class, [
                'disabled' => true, // Désactive le champ
                'data' => $options['data']->getPassword() // Remplacez $valeurSpecifique par la valeur souhaitée
            ])
            ->add(
                'address',
                null,
                [
                    'attr' => ['placeholder' => '265 chemin de l\'exemple, 31840 Exemple']
                ]
            )
            ->add('grade', ChoiceType::class, [
                'placeholder' => 'Sélectionner le grade',
                'choices' => [
                    'Client' => 'Client',
                    'Waiter' => 'Waiter',
                    'Chef' => 'Chef',
                    'Root' => 'Root',
                ],
                'attr' => [
                    'placeholder' => 'Client/Waiter/Chef/Root' // Ce placeholder peut ne pas être pris en compte pour les choix définis ici
                ],
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
