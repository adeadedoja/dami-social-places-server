<?php
namespace App\Dami\SocialPlacesBundle\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{

    /**
     * Get a name and email and sends a mail
     *
     * @param array $name
     * @param array $recipient
     *
     */
    public function sendMail($name, $recipient, $type)
    {
        if($type == 'confirm'){
            $view = 'contact-confirmation';
            $subject = getenv('MAIL_SUBJECT');
        }elseif($type == 'contact-alert'){
            $view = 'contact-alert';
            $subject = 'You Got a New Contact';
        }
        $url =  getenv('BASE_URL')."/contacts";
        // Create the Transport
        $transport = (new \Swift_SmtpTransport(getenv('MAIL_HOST'), getenv('MAIL_PORT'),getenv('MAIL_ENCRYPTION')))->setUsername(getenv('MAIL_USERNAME'))->setPassword(getenv('MAIL_PASSWORD'));

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message($subject))
        ->setFrom(array(getenv('MAIL_USERNAME') => getenv('MAIL_FROM')))
        ->setTo(array($recipient => $name))
        ->setBody(
                        $this->renderView(
                            "emails/".$view.".html.twig",
                            array('name' => ucfirst($name), 'year' => date('Y'), 'url' => $url)
                        ),
                        'text/html'
                    );

        // Send the message
        $result = $mailer->send($message);
    }

}