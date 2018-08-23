<?php

namespace App\Dami\SocialPlacesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
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

    
    /**
     * Get a name and email and sends a mail
     *
     * @param array $name
     * @param array $recipient
     *
     */
    public function sendMail($name, $recipient)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('damdey@gmail.com')
            ->setTo($recipient)
            ->setBody(
                $this->render(
                    "base.html.twig",
                    array('name' => $name)
                ),
                'text/html'
            )
        ;
        
        $transport = new \Swift_SmtpTransport();
        $mailer = new \Swift_Mailer($transport);
        $mailer->send($message);
    }

    /**
     * Store the request and returns the name
     *
     * @param array $request
     *
     */
    public function store(){
        // persist the new contact
        /*$contact = new Contact;

        //set form data
        $contact->setName($request->get('name'));
        $contact->setEmail($request->get('email'));
        $contact->setPhone($request->get('email'));
        $contact->setSubject($request->get('email'));
        $contact->setMessage($request->get('email'));

        //input data is added to database
        $em = $this->container->get('doctrine')->getManager();
        $em->persist($contact);
        $em->flush();*/

        //call sendMail method to send mail
        $this->sendMail('dami', 'damdey@yahoo.com');
        return $this->respond([
            [
                'name' => $request->get('name')
            ]
        ]);

    }
}
