<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $acrobatics = new Skill();
        $acrobatics->setName('Acrobaties');
        $acrobatics->setAbility('DEX');
        $this->addReference('acrobatics', $acrobatics);

        $arcana = new Skill();
        $arcana->setName('Arcanes');
        $arcana->setAbility('INT');
        $this->addReference('arcana', $arcana);

        $athletics = new Skill();
        $athletics->setName('Athlétisme');
        $athletics->setAbility('STR');
        $this->addReference('athletics', $athletics);

        $discretion = new Skill();
        $discretion->setName('Discrétion');
        $discretion->setAbility('DEX');
        $this->addReference('discretion', $discretion);

        $dressage = new Skill();
        $dressage->setName('Dressage');
        $dressage->setAbility('WIS');
        $this->addReference('dressage', $dressage);

        $sleightOfHand = new Skill();
        $sleightOfHand->setName('Escamotage');
        $sleightOfHand->setAbility('DEX');
        $this->addReference('sleightOfHand', $sleightOfHand);

        $history = new Skill();
        $history->setName('Histoire');
        $history->setAbility('INT');
        $this->addReference('history', $history);

        $intimidation = new Skill();
        $intimidation->setName('Intimidation');
        $intimidation->setAbility('CHA');
        $this->addReference('intimidation', $intimidation);

        $investigation = new Skill();
        $investigation->setName('Investigation');
        $investigation->setAbility('INT');
        $this->addReference('investigation', $investigation);

        $medicine = new Skill();
        $medicine->setName('Médecine');
        $medicine->setAbility('WIS');
        $this->addReference('medicine', $medicine);

        $nature = new Skill();
        $nature->setName('Nature');
        $nature->setAbility('INT');
        $this->addReference('nature', $nature);

        $perception = new Skill();
        $perception->setName('Perception');
        $perception->setAbility('WIS');
        $this->addReference('perception', $perception);

        $insight = new Skill();
        $insight->setName('Perspicacité');
        $insight->setAbility('WIS');
        $this->addReference('insight', $insight);

        $persuasion = new Skill();
        $persuasion->setName('Persuasion');
        $persuasion->setAbility('CHA');
        $this->addReference('persuasion', $persuasion);

        $religion = new Skill();
        $religion->setName('Religion');
        $religion->setAbility('INT');
        $this->addReference('religion', $religion);

        $representation = new Skill();
        $representation->setName('Représentation');
        $representation->setAbility('CHA');
        $this->addReference('representation', $representation);

        $survival = new Skill();
        $survival->setName('Survie');
        $survival->setAbility('WIS');
        $this->addReference('survival', $survival);

        $deception = new Skill();
        $deception->setName('Tromperie');
        $deception->setAbility('CHA');
        $this->addReference('deception', $deception);

        $manager->persist($acrobatics);
        $manager->persist($arcana);
        $manager->persist($athletics);
        $manager->persist($discretion);
        $manager->persist($dressage);
        $manager->persist($sleightOfHand);
        $manager->persist($history);
        $manager->persist($intimidation);
        $manager->persist($investigation);
        $manager->persist($medicine);
        $manager->persist($nature);
        $manager->persist($perception);
        $manager->persist($insight);
        $manager->persist($persuasion);
        $manager->persist($religion);
        $manager->persist($representation);
        $manager->persist($survival);
        $manager->persist($deception);

        $manager->flush();
    }
}
