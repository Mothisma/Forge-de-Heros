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
    public function index(PartyRepository $partyRepository): Response
    {
        return $this->render('party/index.html.twig', [
            'parties' => $partyRepository->findAll(),
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
    public function show(Party $party): Response
    {
        return $this->render('party/show.html.twig', [
            'party' => $party,
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

    #[Route('/{id}/add/{character_id}',name: 'app_party_add', methods: ['POST'])]
    public function addCharacter(Request $request, EntityManagerInterface $entityManager, CharacterRepository $characterRepository): Response
    {
        $characterCount = 0;

    }

}
