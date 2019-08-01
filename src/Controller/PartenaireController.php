<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PartenaireController extends AbstractController
{
    /**
     * @Route("/partenaire/inserer", name="inserer_un_par", methods={"POST"})
     */
    // public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    // {
    //     $values = json_decode($request->getContent());
    //     if(isset($values->username,$values->password)) {
    //         $user = new Utilisateur();
    //         $user->setUsername($values->username);
    //         $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
    //         $user->setRoles($user->getRoles());
    //         $entityManager->persist($user);
    //         $entityManager->flush();

    //         $data = [
    //             'status' => 201,
    //             'message' => 'L\'utilisateur a été créé'
    //         ];

    //         return new JsonResponse($data, 201);
    //     }
    //     $data = [
    //         'status' => 500,
    //         'message' => 'Vous devez renseigner les clés username et password'
    //     ];
    //     return new JsonResponse($data, 500);
    // }
}
