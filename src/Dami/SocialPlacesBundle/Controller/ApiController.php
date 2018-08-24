<?php
namespace App\Dami\SocialPlacesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{

    /**
     * @var integer set default OK HTTP status code - 200
     */
    public $statusCode = 200;
    
    
    /**
     * returns the value of statusCode.
     *
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


    /**
     * Sets the value of statusCode.
     *
     * @param integer $statusCode the status code
     *
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns a JSON Respons
     * @param array $data
     * @param array $headers
     * 
     * @return Symfony\Component\HttpFoundation\JsonResponse

    */
    public function respond($data, $headers = [])
    {
        return new JsonResponse($data,$this->getStatusCode(), $headers);
    }

    /**
     * Returns a 201 Created HTTP Status Code
     *
     * @param array $data
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function respondCreated($data = [])
    {
        return $this->setStatusCode(201)->respond($data);
    }

    

}