<?php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'note',
                IntegerType::class,
                [
                    'attr' => [
                        'min' => 1, // Valeur minimale autorisée
                        'max' => 5, // Valeur maximale autorisée
                    ],
                    'data' => 1, // Valeur par défaut
                    'constraints' => [
                        new Range([
                            'min' => 1,
                            'max' => 10,
                            'notInRangeMessage' => 'La note doit être entre {{ min }} et {{ max }}.',
                        ]),
                    ],
                ]
            )
            ->add('com')
            ->add('id_ticket', HiddenType::class, [
                'disabled' => true, // Désactive le champ
                'data' => $options['data']->getIdTicket() // Remplacez $valeurSpecifique par la valeur souhaitée
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
