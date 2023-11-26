<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entre')
            ->add('plat')
            ->add('dessert')
            ->add('id_resto', HiddenType::class, [
                'disabled' => true, // Désactive le champ
                'data' => $options['data']->getIdResto() // Remplacez $valeurSpecifique par la valeur souhaitée
            ])
            ->add('id_users', HiddenType::class, [
                'disabled' => true, // Désactive le champ
                'data' => $options['data']->getIdUsers() // Remplacez $valeurSpecifique par la valeur souhaitée
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
