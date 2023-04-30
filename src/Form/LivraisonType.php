<?php

namespace App\Form;

use App\Entity\Livraison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\GreaterThan;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numCommande')
            ->add('nomLivreur', TextType::class, [
                'label' => 'Nom du livreur',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 3,
                    'maxlength' => 20,
                    'required' => true,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom du livreur ne peut pas être vide.'
                    ]),
                    new Length([
                        'min' => 4,
                        'max' => 12,
                        'maxMessage' => 'Le nom du livreur ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'error_bubbling' => true,
                'invalid_message' => 'le nom de livreur doit contenir entre 3 et 20 caractères.',
            ])
            ->add('dateLivraison', DateType::class, [
                'label' => 'Date de livraison',
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de livraison ne peut pas être vide.'
                    ]),
                    new Type([
                        'type' => \DateTimeInterface::class,
                        'message' => 'La date de livraison doit être une date valide.'
                    ]),
                    new GreaterThan([
                        'value' => 'today',
                        'message' => 'La date de livraison doit être postérieure à la date d\'aujourd\'hui.',
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'error_bubbling' => true,
                'invalid_message' => 'Veuillez entrer une date valide.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
