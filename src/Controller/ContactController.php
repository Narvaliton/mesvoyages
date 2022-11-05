<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request; 
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * Description of ContactController
 *
 * @author maxco
 */
class ContactController extends AbstractController{
    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function index(Request $request, MailerInterface $mailer): Response{
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);
        
        if($formContact->isSubmitted() && $formContact->isValid()){
            $this->sendMail($mailer, $contact);
            $this->addFlash('success', 'Message envoyé');
            return $this->redirectToRoute('contact');
        }
        return $this->render("pages/contact.html.twig", [
            'contact' => $contact,
            'formcontact' => $formContact->createView()
        ]);
    }
    
    public function sendMail(MailerInterface $mailer, Contact $contact)
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('maxcolin@mc-narvaliton.go.yj.fr')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Message du site de voyages')
            ->html($this->renderView(
                    'pages/_email.html.twig', [
                        'contact' =>$contact
                    ]
                ),
                'utf-8'
            );

        $mailer->send($email);

        // ...
    }
}
