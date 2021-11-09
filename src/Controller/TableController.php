<?php

namespace App\Controller;


use App\Entity\Table;
use App\Form\TableChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/table", name="table")
 */
class TableController extends AbstractController
{
    /**
     * @Route("/select",name="table_select")
     */
    public function select(Request $request)
    {
        $form = $this->createForm(TableChoiceType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $n = $data['table_number'];
            $m = $data['lines_count'];
            $color = $data['color'];

            $table = new Table($n);
            $calculations = $table->calcMultiply($m);

            dump($n);
            $response = $this->render('table/index.html.twig', [
                'controller_name' => 'TableController',
                'n' => $n,
                'calculations'  => $calculations,
                'color' => $color,
            ]);

        } else {
            dump("NOT isSubmitted");
            $response = $this->render('table/vue.html.twig', [
                'Formulaire' => $form->createView(),
            ]);}

        return $response;
    }

    /**
     * @Route("/print/{n}/{i}/{color}", name="table_print")
     */
    public function index(int $n, int $i, Request $request): Response
    {
        $color = $request->get('c');
        return $this->render('table/index.html.twig', [
            'controller_name' => 'TableController',
            'n' => $n,
            'i' => $i,
            'color' => $color,
        ]);
    }
}
