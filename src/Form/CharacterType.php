<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\CharacterClass;
use App\Entity\Party;
use App\Entity\Race;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('level', null, ['attr' => ['min' => 1, 'max' => 20]])
            ->add('strength', null, ['attr' => ['min' => 8, 'max' => 15]])
            ->add('dexterity', null, ['attr' => ['min' => 8, 'max' => 15]])
            ->add('constitution', null, ['attr' => ['min' => 8, 'max' => 15]])
            ->add('inteligence', null, ['attr' => ['min' => 8, 'max' => 15]])
            ->add('wisdom', null, ['attr' => ['min' => 8, 'max' => 15]])
            ->add('charisma', null, ['attr' => ['min' => 8, 'max' => 15]])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'avatar',
                'download_uri' => false, 
                'label' => 'Avatar'
            ])
            ->add('race', EntityType::class, [
                'class' => Race::class,
                'choice_label' => 'name',
            ])
            ->add('class', EntityType::class, [
                'class' => CharacterClass::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
