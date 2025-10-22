<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LuckyController extends AbstractController
{
    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route('/lucky/sentence')]
    public function sentence(): Response
    {
        $sentences = [
            'Today is your lucky day!',
            'Fortune favors the bold.',
            'Good things come to those who wait.',
            'The best is yet to come.',
            'Believe in yourself and magic will happen.'
        ];
        $selectedSentence = $sentences[array_rand($sentences)];

        return $this->render('lucky/sentence.html.twig', [
            'sentence' => $selectedSentence,
        ]);
    }
}
