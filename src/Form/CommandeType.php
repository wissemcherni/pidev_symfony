<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numPanier', IntegerType::class, [
                'label' => 'Numéro de panier',
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'required' => true,
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'error_bubbling' => true,
                'invalid_message' => 'Veuillez entrer un nombre positif.',
            ])
            ->add('emetteur', TextType::class, [
                'label' => 'Emetteur',
                'attr' => [
                    'class' => 'form-control',
                    'required' => true,
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'error_bubbling' => true,
                'invalid_message' => 'Veuillez entrer un nom valide.',
            ])
            ->add('depot', TextType::class, [
                'label' => 'Dépôt',
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 3,
                    'maxlength' => 20,
                    'required' => true,
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'error_bubbling' => true,
                'invalid_message' => 'Le dépôt doit contenir entre 3 et 20 caractères.',
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En attente' => 'en_attente',
                    'En cours' => 'en_cours',
                    'Terminée' => 'terminee',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'required' => true,
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'error_bubbling' => true,
                'invalid_message' => 'Veuillez sélectionner un statut valide.',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Echange' => 'echange',
                    'Vente' => 'vente',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'required' => true,
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'error_bubbling' => true,
                'invalid_message' => 'Veuillez sélectionner un type valide.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
