<?php

namespace App\Dami\SocialPlacesBundle\Controller;

//The mail controller is called here
use App\Dami\SocialPlacesBundle\Controller\MailController;
//The APIController that handles the api response logic
use App\Dami\SocialPlacesBundle\Controller\ApiController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * Store the request and returns the name
     *
     * @param array $request
     *
     */
    public function store(MailController $mailController, ApiController $apiController, Request $request){
        // persist the new contact
        $contact = new Contact;

        //set form data
        $contact->setName($request->get('name'));
        $contact->setEmail($request->get('email'));
        $contact->setPhone($request->get('email'));
        $contact->setSubject($request->get('email'));
        $contact->setMessage($request->get('email'));

        //input data is added to database
        $em = $this->container->get('doctrine')->getManager();
        $em->persist($contact);
        $em->flush();

        //call sendMail method to send mail
        $mailController->sendMail($request->get('name'), $request->get('email'));

        //return name for display
        return $apiController->respond([
            [
                'name' => $request->get('name')
            ]
        ]);

    }
}
