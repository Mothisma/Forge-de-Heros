<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Character;
use App\Entity\CharacterClass;
use App\Entity\Party;
use App\Entity\Race;
use App\Repository\CharacterRepository;
use App\Repository\PartyRepository;
use App\Repository\RaceRepository;
use App\Repository\CharacterClassRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/api/v1')]
class APIController extends AbstractController
{

    #[Route('/races', name: 'api_races', methods: ['GET'])]
    public function racesIndex(RaceRepository $repository): JsonResponse
    {
        $races = $repository->findAll();

        return $this->json(array_map(function ($race) {
            return [
                'id' => $race->getId(),
                'name' => $race->getName(),
            ];
        }, $races));
    }

    #[Route('/races/{id}', name: 'api_race', methods: ['GET'])]
    public function raceShow(Race $race): JsonResponse
    {
        return $this->json([
            'id' => $race->getId(),
            'name' => $race->getName(),
            'description' => $race->getDescription(),
        ]);
    }

    #[Route('/classes', name: 'api_classes', methods: ['GET'])]
    public function classesIndex(CharacterClassRepository $repository): JsonResponse
    {
        $classes = $repository->findAll();

        return $this->json(array_map(function ($class) {
            return [
                'id' => $class->getId(),
                'name' => $class->getName(),
            ];
        }, $classes));
    }

    #[Route('/classes/{id}', name: 'api_class', methods: ['GET'])]
    public function classShow(CharacterClass $class): JsonResponse{
        return $this->json([
            'id' => $class->getId(),
            'name' => $class->getName(),
            'description' => $class->getDescription(),
            'healthDice' => $class->getHealthDice(),
            'skills' => array_map(function ($skill) {
                return
                    [
                        'id' => $skill->getId(),
                        'name' => $skill->getName()
                    ];
            }, $class->getSkills()->toArray()),
        ]);
    }

    #[Route('/skills', name: 'api_skills', methods: ['GET'])]
    public function skillsIndex(SkillRepository $repository): JsonResponse
    {
        $skills = $repository->findAll();

        return $this->json(array_map(function ($skill) {
            return [
                'id' => $skill->getId(),
                'name' => $skill->getName(),
                'ability' => $skill->getAbility(),
            ];
        }, $skills));
    }

    #[Route('/characters', name: 'api_characters', methods: ['GET'])]
    public function charactersIndex(CharacterRepository $repository): JsonResponse
    {
        $characters = $repository->findAll();

        return $this->json(array_map(function ($character) {
            return [
                'id' => $character->getId(),
                'name' => $character->getName(),
                'level' => $character->getLevel(),
                'image' => $character->getImage(),
                'race' => [
                    'id' => $character->getRace()->getId(),
                    'name' => $character->getRace()->getName(),
                ],
                'class' => [
                    'id' => $character->getClass()->getId(),
                    'name' => $character->getClass()->getName(),
                ],
            ];
        }, $characters));
    }

    #[Route('/characters/{id}', name: 'api_character', methods: ['GET'])]
    public function characterShow(Character $character): JsonResponse
    {
        return $this->json([
            'id' => $character->getId(),
            'name' => $character->getName(),
            'level' => $character->getLevel(),
            'strength' => $character->getStrength(),
            'dexterity' => $character->getDexterity(),
            'constitution' => $character->getConstitution(),
            'intelligence' => $character->getIntelligence(),
            'wisdom' => $character->getWisdom(),
            'charisma' => $character->getCharisma(),
            'healthPoints' => $character->getHealthPoints(),
            'image' => $character->getImage(),
            'race' => [
                'id' => $character->getRace()->getId(),
                'name' => $character->getRace()->getName(),
            ],
            'class' => [
                'id' => $character->getClass()->getId(),
                'name' => $character->getClass()->getName(),
            ],
            'parties' => array_map(function ($party) {
                return [
                    'id' => $party->getId(),
                    'name' => $party->getName()
                ];
            }, $character->getParties()->toArray()),
        ]);
    }

    #[Route('/parties', name: 'api_parties', methods: ['GET'])]
    public function partiesIndex(PartyRepository $repository): JsonResponse
    {
        $parties = $repository->findAll();

        return $this->json(array_map(function ($party) {
            return [
                'id' => $party->getId(),
                'name' => $party->getName(),
                'places' => $party->getMaxSize() - $party->getCharacters()->count(),
            ];
        }, $parties));
    }

    #[Route('/parties/{id}', name: 'api_party', methods: ['GET'])]
    public function partyShow(Party $party): JsonResponse
    {
        return $this->json([
            'id' => $party->getId(),
            'name' => $party->getName(),
            'description' => $party->getDescription(),
            'places' => $party->getMaxSize() - $party->getCharacters()->count(),
            'maxSize' => $party->getMaxSize(),
            'characters' => array_map(function ($character) {
                return [
                    'id' => $character->getId(),
                    'name' => $character->getName()
                ];
            }, $party->getCharacters()->toArray()),
        ]);
    }
}
