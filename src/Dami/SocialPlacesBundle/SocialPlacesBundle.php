<?php
namespace App\Dami\SocialPlacesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SocialPlacesBundle extends Bundle
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

    protected function getDoctrine()
{
    if (!$this->container->has('doctrine')) {
        throw new \LogicException('The DoctrineBundle is not registered in your application.');
    }

    return $this->container->get('doctrine');
}

    public function store(Request $request, ContactRepository $contactRepository ){
        // persist the new contact
        $contact = new Contact;
        $contact->setName($request->get('name'));
        $contact->setEmail($request->get('email'));
        $contact->setPhone($request->get('email'));
        $contact->setSubject($request->get('email'));
        $contact->setMessage($request->get('email'));
        $em = $this->container->get('doctrine')->getManager();
        $em->persist($contact);
        $em->flush();


        return $this->respondCreated($contactRepository->transform($request));
    }
}

