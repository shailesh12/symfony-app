<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Trainee;
use App\Repository\TraineeRepository;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Version;

/**
 * @Version({"v1", "v2"})
 */
class TraineeApiController extends FOSRestController {

    /**
     * Creates an Article resource
     * @Rest\Post("/api/create_trainee")
     * @param Request $request
     * @return View
     */
    public function createTraineeAPI(Request $request): View {
        $entityManager = $this->getDoctrine()->getManager();
        $trainee = new Trainee();
        $trainee->setName('Trainee Five');
        $trainee->setEmail('trainee5@yopmail.com');
        $trainee->setGender('Female');
        $trainee->setDob(\DateTime::createFromFormat('Y-m-d', "1990-10-12"));
        $trainee->setCreatedAt(\DateTime::createFromFormat('Y-m-d', "2018-09-27"));
        $trainee->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', "2018-09-27"));
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($trainee);
        // actually executes the queries (i.e. the INSERT query)
        $traineeCreated = $trainee->getName();
//        if (!$traineeCreated) {
        $entityManager->flush();
//        }
        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($trainee, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an Article resource
     * @Rest\Get("api/trainee/{traineeId}")
     * @return View
     */
    public function getTraineeAPI(int $traineeId): View {
        $trainee = $this->getDoctrine()->getRepository(Trainee::class)->find($traineeId);
//        $article = $this->TraineeRepository->findById($traineeId);
        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($trainee, Response::HTTP_OK);
    }

    /**
     * Retrieves an Article resource
     * @Rest\Get("api/trainees")
     */
    public function getAllTraineeAPI(): View {
        $traineeList = $this->getDoctrine()->getRepository(Trainee::class)->findAll();
        //        $article = $this->TraineeRepository->findById($traineeId);
        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($traineeList, Response::HTTP_OK);
    }

}
