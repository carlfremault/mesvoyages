<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of ContactController
 *
 * @author Carl Fremault
 */
class ContactController extends AbstractController {

    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response {
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);
        if ($formContact->isSubmitted() && $formContact->isValid()) {
            $this->envoiMail($mailer, $contact);
            $this->addFlash('succes', 'message envoyé');
            return $this->redirectToRoute("contact");
        }
        return $this->render("pages/contact.html.twig", [
                    'contact' => $contact,
                    'formcontact' => $formContact->createView()
        ]);
    }

    public function envoiMail(\Swift_Mailer $mailer, Contact $contact) {
        $message = (new \Swift_Message('Message du site de voyages'))
                ->setFrom($contact->getEmail())
                ->setTo('contact@mesvoyages.fr')
                ->setBody(
                $this->renderView(
                        'pages/_email.html.twig', [
                    'contact' => $contact
                        ]
                ),
                'text/html'
                )
        ;
        $mailer->send($message);
    }

}
