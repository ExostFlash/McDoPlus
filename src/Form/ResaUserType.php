<?php

namespace App\Form;

use App\Entity\Resa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\Range;

class ResaUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_resto', HiddenType::class, [
                'disabled' => true, // Désactive le champ
                'data' => $options['data']->getIdResto() // Remplacez $valeurSpecifique par la valeur souhaitée
            ])
            ->add('id_user', HiddenType::class, [
                'disabled' => true, // Désactive le champ
                'data' => $options['data']->getIdUser() // Remplacez $valeurSpecifique par la valeur souhaitée
            ])
            ->add('nb_user', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'placeholder' => 'Nombre de personnes (entre 1 et 10)',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez choisir un nombre de personnes.']),
                    new Range([
                        'min' => 1,
                        'max' => 10,
                        'minMessage' => 'Le nombre minimum de personnes est {{ limit }}.',
                        'maxMessage' => 'Le nombre maximum de personnes est {{ limit }}.',
                    ]),
                ],
            ])
            ->add('jour', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker', 'placeholder' => 'Format date : AAAA-MM-JJ'],
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'Vous ne pouvez pas choisir une date passée.',
                    ]),
                ],
            ])
            ->add('heur', ChoiceType::class, [
                'choices' => [
                    '12:00' => new \DateTime('12:00:00'),
                    '12:15' => new \DateTime('12:15:00'),
                    '12:30' => new \DateTime('12:30:00'),
                    '12:45' => new \DateTime('12:45:00'),
                    '13:00' => new \DateTime('13:00:00'),
                    '19:00' => new \DateTime('19:00:00'),
                    '19:15' => new \DateTime('19:15:00'),
                    '19:30' => new \DateTime('19:30:00'),
                    '19:45' => new \DateTime('19:45:00'),
                    '20:00' => new \DateTime('20:00:00'),
                    '20:15' => new \DateTime('20:15:00'),
                    '20:30' => new \DateTime('20:30:00'),
                    '20:45' => new \DateTime('20:45:00'),
                    '21:00' => new \DateTime('21:00:00'),
                ],
                'placeholder' => 'Choisissez une heure',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resa::class,
        ]);
    }
}
