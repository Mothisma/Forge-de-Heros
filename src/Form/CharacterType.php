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

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('level')
            ->add('strength')
            ->add('dexterity')
            ->add('constitution')
            ->add('inteligence')
            ->add('wisdom')
            ->add('charisma')
            ->add('healthPoints')
            ->add('image')
            ->add('User', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('Race', EntityType::class, [
                'class' => Race::class,
                'choice_label' => 'id',
            ])
            ->add('Class', EntityType::class, [
                'class' => CharacterClass::class,
                'choice_label' => 'id',
            ])
            ->add('parties', EntityType::class, [
                'class' => Party::class,
                'choice_label' => 'id',
                'multiple' => true,
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
