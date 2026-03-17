<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use App\Entity\CharacterClass;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ClassesFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies() : array
    {
        return [
            SkillsFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $barbarian = new CharacterClass();
        $barbarian->setName('Barbare');
        $barbarian->setHealthDice(12);
        $barbarian->setDescription('Guerrier sauvage animé par une rage dévastatrice.');
        $barbarian->addSkill(
            $this->getReference('athletics', Skill::class)
        );
        $barbarian->addSkill(
            $this->getReference('intimidation', Skill::class)
        );
        $barbarian->addSkill(
            $this->getReference('survival', Skill::class)
        );

        $bard = new CharacterClass();
        $bard->setName('Barde');
        $bard->setHealthDice(8);
        $bard->setDescription('Artiste et conteur dont la musique possède un pouvoir magique.');
        $bard->addSkill(
            $this->getReference('representation', Skill::class)
        );
        $bard->addSkill(
            $this->getReference('persuasion', Skill::class)
        );
        $bard->addSkill(
            $this->getReference('deception', Skill::class)
        );
        $bard->addSkill(
            $this->getReference('sleightOfHand', Skill::class)
        );

        $cleric = new CharacterClass();
        $cleric->setName('Clerc');
        $cleric->setHealthDice(8);
        $cleric->setDescription('Serviteur divin canalisant la puissance de sa divinité.');
        $cleric->addSkill(
            $this->getReference('religion', Skill::class)
        );
        $cleric->addSkill(
            $this->getReference('medicine', Skill::class)
        );
        $cleric->addSkill(
            $this->getReference('insight', Skill::class)
        );

        $druid = new CharacterClass();
        $druid->setName('Druide');
        $druid->setHealthDice(8);
        $druid->setDescription('Gardien de la nature capable de se métamorphoser.');
        $druid->addSkill(
            $this->getReference('nature', Skill::class)
        );
        $druid->addSkill(
            $this->getReference('dressage', Skill::class)
        );
        $druid->addSkill(
            $this->getReference('survival', Skill::class)
        );
        $druid->addSkill(
            $this->getReference('perception', Skill::class)
        );

        $fighter = new CharacterClass();
        $fighter->setName('Guerrier');
        $fighter->setHealthDice(10);
        $fighter->setDescription('Maître des armes et des tactiques de combat.');
        $fighter->addSkill(
            $this->getReference('athletics', Skill::class)
        );
        $fighter->addSkill(
            $this->getReference('intimidation', Skill::class)
        );
        $fighter->addSkill(
            $this->getReference('history', Skill::class)
        );

        $mage = new CharacterClass();
        $mage->setName('Mage');
        $mage->setHealthDice(6);
        $mage->setDescription('Érudit de l\'arcane maîtrisant de puissants sortilèges.');
        $mage->addSkill(
            $this->getReference('arcana', Skill::class)
        );
        $mage->addSkill(
            $this->getReference('history', Skill::class)
        );
        $mage->addSkill(
            $this->getReference('investigation', Skill::class)
        );

        $paladin = new CharacterClass();
        $paladin->setName('Paladin');
        $paladin->setHealthDice(10);
        $paladin->setDescription('Chevalier sacré combinant prouesse martiale et magie divine.');
        $paladin->addSkill(
            $this->getReference('athletics', Skill::class)
        );
        $paladin->addSkill(
            $this->getReference('religion', Skill::class)
        );
        $paladin->addSkill(
            $this->getReference('persuasion', Skill::class)
        );

        $ranger = new CharacterClass();
        $ranger->setName('Ranger');
        $ranger->setHealthDice(10);
        $ranger->setDescription('Chasseur et pisteur expert des terres sauvages.');
        $ranger->addSkill(
            $this->getReference('survival', Skill::class)
        );
        $ranger->addSkill(
            $this->getReference('perception', Skill::class)
        );
        $ranger->addSkill(
            $this->getReference('nature', Skill::class)
        );
        $ranger->addSkill(
            $this->getReference('discretion', Skill::class)
        );

        $wizard = new CharacterClass();
        $wizard->setName('Sorcier');
        $wizard->setHealthDice(6);
        $wizard->setDescription('Lanceur de sorts dont le pouvoir est inné et instinctif.');
        $wizard->addSkill(
            $this->getReference('arcana', Skill::class)
        );
        $wizard->addSkill(
            $this->getReference('deception', Skill::class)
        );
        $wizard->addSkill(
            $this->getReference('intimidation', Skill::class)
        );

        $rogue = new CharacterClass();
        $rogue->setName('Voleur');
        $rogue->setHealthDice(8);
        $rogue->setDescription('Spécialiste de la discrétion, du crochetage et des attaques sournoises.');
        $rogue->addSkill(
            $this->getReference('discretion', Skill::class)
        );
        $rogue->addSkill(
            $this->getReference('sleightOfHand', Skill::class)
        );
        $rogue->addSkill(
            $this->getReference('acrobatics', Skill::class)
        );
        $rogue->addSkill(
            $this->getReference('investigation', Skill::class)
        );

        $manager->persist($barbarian);
        $manager->persist($bard);
        $manager->persist($cleric);
        $manager->persist($druid);
        $manager->persist($fighter);
        $manager->persist($mage);
        $manager->persist($paladin);
        $manager->persist($ranger);
        $manager->persist($wizard);
        $manager->persist($rogue);

        $manager->flush();
    }
}
