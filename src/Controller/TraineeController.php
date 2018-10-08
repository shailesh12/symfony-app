<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Trainee;
use App\Exception\TraineeException;
use Psr\Log\LoggerInterface;

class TraineeController extends AbstractController {

    /**
     * @Route({"en":"/trainee",
     * "ln":"/over-ons"
     * }, name="trainee")
     */
    public function index(LoggerInterface $logger) {
        $traineesList = $this->getDoctrine()->getRepository(Trainee::class)->findAll();
//        asd($traineeList[0]);

        $logger->info('I just got the logger');
        $logger->error('An error occurred');

        $logger->critical('I left the oven on!', array(
            // include extra "context" info in your logs
            'cause' => 'in_hurry',
        ));
        return $this->render('trainee/index.html.twig', [
                    'data' => $traineesList,
        ]);
    }

    /**
     * @Route("/trainee/add", name="trainee_add")
     */
    public function add() {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
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
        $entityManager->flush();

        return $this->render('trainee/addTrainee.html.twig', [
                    'trainee_id' => $trainee->getId(),
        ]);

//        return new Response('Saved new product with id ' . $trainee->getId());
    }

    /**
     * @Route("/trainee/remove/{id}", name="trainee_remove")
     */
    public function remove($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $trainee = $entityManager->getRepository(Trainee::class)->find($id);

        if (!$trainee) {
            throw $this->createNotFoundException(
                    'No trainee found for id ' . $id
            );
        }

        $entityManager->remove($trainee);
        $entityManager->flush();
        return new Response('Trainee with id ' . $trainee->getId() . ' removed successfully');
    }

    /**
     * @Route("/trainee/{id}", name="trainee_show")
     */
    public function show($id) {
        $trainee = $this->getDoctrine()->getRepository(Trainee::class)->find($id);

        if (!$trainee) {
            $message = 'Trainee does not exist with  ' . $id;
            $code = 404;
            throw new TraineeException($message, $code);

//            throw $this->createNotFoundException(
//                    'No trainee found for id ' . $id
//            );
        }

        $dob = $trainee->getDob();
        $formattedDate = $dob ? $dob->format('d-M-Y') : 'N/A';
        $traineeArr = ['name' => $trainee->getName(),
            'email' => $trainee->getEmail(),
            'gender' => $trainee->getGender(),
            'dob' => $formattedDate];


        return $this->render('trainee/viewTrainee.html.twig', [
                    'traineeArr' => $traineeArr,
        ]);
//        return new Response('Trainee found with name: ' . $trainee->getName(). ' and email: '.$trainee->getEmail());
    }

}
