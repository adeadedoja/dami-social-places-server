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
        //get request into array
        $data = json_decode($request->getContent(), true);
        
        // persist the new contact
        $contact = new Contact;

        //set form data
        $contact->setName($data['name']);
        $contact->setEmail($data['email']);
        $contact->setPhone($data['phone']);
        $contact->setSubject($data['subject']);
        $contact->setMessage($data['message']);

        //input data is added to database
        $em = $this->container->get('doctrine')->getManager();
        $em->persist($contact);
        $em->flush();

        //call sendMail method to send mail to client to confirm
        $mailController->sendMail($data['name'], $data['email'],'confirm');
        //call sendMail method to send mail to admin to alert of new contact
        $mailController->sendMail('admin', getenv('MAIL_ADMIN'),'contact-alert');

        //return name for display
        return $apiController->respond([
            [
                'name' => $data['name']
            ]
        ]);

    }
}
