<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Dami\SocialPlacesBundle\Controller\MailController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, ValidatorInterface $validator, MailController $mailController)
    {
        //new contact object
        $contact = new Contact;

        $form = $this->createFormBuilder($contact)
            ->add('name', TextType::class)
            ->add('phone', TextType::class)
            ->add('email', EmailType::class)
            ->add('subject', TextType::class)
            ->add('message', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Get in Touch'))
            ->getForm();
        
        $form->handleRequest($request);

        //checks if submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {

            //checks errors in object
            $errors = $validator->validate($form);

            if (count($errors) > 0) {
                return $this->render('contact/index.html.twig', array(
                    'errors' => $errors,
                ));
            }
            
            //gets the submitted value and assigns it to the contact object
            $contact = $form->getData();

            //save to DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            //call sendMail method to send mail
            $mailController->sendMail($contact->getName(), $contact->getEmail());

            return $this->redirectToRoute('contact_add_success');
        }
        
        return $this->render('contact/index.html.twig', [
            'title' => 'Social Places Contact',
             'form' => $form->createView(),
        ]);
    }
}
