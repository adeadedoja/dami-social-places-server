<?php
namespace App\Dami\SocialPlacesBundle\Controller;

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
    public function sendMail($name, $recipient)
    {
        // Create the Transport
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587,'tls'))->setUsername('damdey@gmail.com')->setPassword('Kaos@1000');

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message('Wonderful Subject'))
        ->setFrom(array('damdey@gmail.com' => 'Our Code World'))
        ->setTo(array($recipient => $name))
        ->setBody(
                        $this->render(
                            "base.html.twig",
                            array('name' => $name)
                        ),
                        'text/html'
                    );

        // Send the message
        $result = $mailer->send($message);
    }

}