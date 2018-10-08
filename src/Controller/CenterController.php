<?php

namespace App\Controller;

use App\Entity\Center;
use App\Form\CenterType;
use App\Repository\CenterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/center")
 */
class CenterController extends AbstractController
{
    /**
     * @Route("/", name="center_index", methods="GET")
     */
    public function index(CenterRepository $centerRepository): Response
    {
        return $this->render('center/index.html.twig', ['centers' => $centerRepository->findAll()]);
    }

    /**
     * @Route("/new", name="center_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $center = new Center();
        $form = $this->createForm(CenterType::class, $center);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($center);
            $em->flush();

            return $this->redirectToRoute('center_index');
        }

        return $this->render('center/new.html.twig', [
            'center' => $center,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="center_show", methods="GET")
     */
    public function show(Center $center): Response
    {
        return $this->render('center/show.html.twig', ['center' => $center]);
    }

    /**
     * @Route("/{id}/edit", name="center_edit", methods="GET|POST")
     */
    public function edit(Request $request, Center $center): Response
    {
        $form = $this->createForm(CenterType::class, $center);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('center_edit', ['id' => $center->getId()]);
        }

        return $this->render('center/edit.html.twig', [
            'center' => $center,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="center_delete", methods="DELETE")
     */
    public function delete(Request $request, Center $center): Response
    {
        if ($this->isCsrfTokenValid('delete'.$center->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($center);
            $em->flush();
        }

        return $this->redirectToRoute('center_index');
    }
}
