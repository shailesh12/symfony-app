<?php

namespace App\Controller\v2;

use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;

/**
 *  @Version("v2")
 */
class TraineeApiController extends FOSRestController {
    /**
     * @View
     * @Route("/api/test.{_format}",defaults={"_format": "json"},condition="request.attributes.get('version') == 'v2'")
     */
    public function getTestAction()
    {
        $output = array();
        echo "test2";
        $view = $this->view($output, 200);
        return $this->handleView($view);
    }

}
