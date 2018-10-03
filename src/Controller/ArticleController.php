<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Trainee;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends FOSRestController {

    /**
     * Creates an Article resource
     * @Rest\Post("/api/articles")
     * @param Request $request
     * @return View
     */
    public function postArticle(Request $request): View {
        $entityManager = $this->getDoctrine()->getManager();
        $trainee = new Trainee();
        $trainee->setName('Trainee Four');
        $trainee->setEmail('trainee4@yopmail.com');
        $trainee->setGender('Male');
        $trainee->setDob(\DateTime::createFromFormat('Y-m-d', "1990-10-12"));
        $trainee->setCreatedAt(\DateTime::createFromFormat('Y-m-d', "2018-09-27"));
        $trainee->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', "2018-09-27"));
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($trainee);
        // actually executes the queries (i.e. the INSERT query)
        $traineeCreated = $trainee->getName();
        if (!$traineeCreated) {
            $entityManager->flush();
        }
        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($trainee, Response::HTTP_CREATED);
    }

}
