<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class Ticket2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_resto', HiddenType::class, [
                'disabled' => true, // Désactive le champ
                'data' => $options['data']->getIdResto()
            ])
            ->add('id_users', HiddenType::class, [
                'disabled' => true, // Désactive le champ
                'data' => $options['data']->getIdUsers()
            ])
            ->add('payement', HiddenType::class, [
                'disabled' => true, // Désactive le champ
                'data' => $options['data']->getPayement()
            ])
            ->add('id_menu', HiddenType::class, [
                'disabled' => true, // Désactive le champ
                'data' => $options['data']->getIdMenu()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
