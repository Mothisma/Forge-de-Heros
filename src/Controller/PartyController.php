<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Party;
use App\Form\PartyType;
use App\Repository\CharacterRepository;
use App\Repository\PartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/party')]
final class PartyController extends AbstractController
{
    #[Route(name: 'app_party_index', methods: ['GET'])]
    public function index(Request $request, PartyRepository $partyRepository): Response
    {
        $status = $request->query->get('status'); // full / available / null

        $parties = $partyRepository->findAll();

        // Filtre : groupes complets
        if ($status === 'full') {
            $parties = array_filter($parties, function (Party $party) {
                return count($party->getCharacters()) >= $party->getMaxSize();
            });
        }

        // Filtre : groupes avec places disponibles
        if ($status === 'available') {
            $parties = array_filter($parties, function (Party $party) {
                return count($party->getCharacters()) < $party->getMaxSize();
            });
        }

        return $this->render('party/index.html.twig', [
            'parties' => $parties,
            'status' => $status,
        ]);
    }

    #[Route('/new', name: 'app_party_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $party = new Party();
        $form = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($party);
            $entityManager->flush();

            return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('party/new.html.twig', [
            'party' => $party,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_party_show', methods: ['GET'])]
    public function show(    Party $party,
                             CharacterRepository $characterRepository
    ): Response {
        $user = $this->getUser();

        $charactersInParty = $party->getCharacters();

        $userCharacters = $characterRepository->findBy(['user' => $user]);

        $userCharactersInParty = array_filter(
            $userCharacters,
            fn($char) => $charactersInParty->contains($char)
        );

        $availableUserCharacters = array_filter(
            $userCharacters,
            fn($char) => !$charactersInParty->contains($char)
        );

        $characterCount = count($charactersInParty);

        return $this->render('party/show.html.twig', [
            'party' => $party,
            'allUsersCharacters' => $charactersInParty,
            'userCharactersInParty' => $userCharactersInParty,
            'userCharacters' => $availableUserCharacters,
            'characterCount' => $characterCount,
        ]);

    }

    #[Route('/{id}/add',name: 'app_party_add', methods: ['GET'])]
    public function add(Party $party, CharacterRepository $characterRepository): Response
    {
        $characterCount = 0;
        foreach ($party->getCharacters() as $character) {
            $characterCount++;
        }
        if ($characterCount >= $party->getMaxSize()) {
            return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
        }

        $availableCharacters = array_filter(
            $characterRepository->findBy(['user'=> $this->getUser()]),
            fn ($character)=> !$party->getCharacters()->contains($character)
        );

        return $this->render('party/add.html.twig', [
            'party' => $party,
            'availableCharacters' => $availableCharacters,
        ]);
    }

    #[Route('/{id}/add/{character_id}',name: 'app_party_add_character', methods: ['POST'])]
    public function addCharacter(PartyRepository $partyRepository, EntityManagerInterface $entityManager, CharacterRepository $characterRepository, int $id,int $character_id): Response
    {
        $party = $partyRepository->find($id);
        $character = $characterRepository->find($character_id);
        if ($character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
        }
        $characterCount = 0;
        foreach ($party->getCharacters() as $char) {
            $characterCount++;
        }
        if ($characterCount >= $party->getMaxSize()) {
            return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
        }

        $party->addCharacter($character);
        $entityManager->persist($party);
        $entityManager->flush();

        return $this->redirectToRoute('app_party_index', []);
    }

    #[Route('/{partyId}/delete/{characterId}', name: 'app_party_delete_character', methods: ['POST'])]
    public function unregisterCharacter(int $partyId, int $characterId, PartyRepository $partyRepository, CharacterRepository $characterRepository, EntityManagerInterface $entityManager): Response
    {
        $party = $partyRepository->find($partyId);
        $character = $characterRepository->find($characterId);

        if ($party && $character) {
            $party->removeCharacter($character);
            $entityManager->persist($party);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_party_show', ['id' => $partyId]);
    }

}
