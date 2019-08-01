<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Utilisateur;
use App\Entity\Partenaire;

/**
 * @Route("/api")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/Partenaire/inserer", name="inserer_un_partenaire", methods={"POST"})
     */
    public function Ajouter_Partenaire(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
            $user = new Utilisateur();
            $user->setEmail($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setPrenom($values->prenom);
            $user->setNom($values->nom);
            $user->setTel($values->tel);
            $user->setAdresse($values->adresse);
            $user->setProfil($values->profil);
            $user->setPhoto($values->photo);
            if ($user->getProfil()=="Super-Admin") {
                $user->setRoles(['ROLE_Super-Admin']);
            }elseif ($user->getProfil()=="Admin-Partenaire") {
                $user->setRoles(['ROLE_Admin-Partenaire']);
                if (!isset($values->ninea)) {
                    $idpartenaire=$user->setIdPartenaire($this->getDoctrine()->getRepository(Partenaire::class)->find($values->idPartenaire));
                    var_dump($idpartenaire);
                    $user->setIdPartenaire($idpartenaire->getId());
                } else {
                    $partenaire = new Partenaire();
                    $partenaire->setNinea($values->ninea);
                    $partenaire->setLocalisation($values->localisation);
                    $partenaire->setDomaineDActivite($values->domaine);
                    $entityManager->persist($partenaire);
                    $user->setIdPartenaire($partenaire);
                }   
            }elseif($user->getProfil()=="Utilisateur") {
                $idpartenaire=$user->setIdPartenaire($this->getDoctrine()->getRepository(Partenaire::class)->find($values->idPartenaire));
                $user->setIdPartenaire($idpartenaire->getId());
            }
            else {
                $data = [
                    'status0' => 400,
                    'message0' => 'Ce profil n\'existe pas vérifie bien' 
                ];
    
                return new JsonResponse($data, 400);
            }
            $user->setStatus(true);
            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status0' => 201,
                'message0' => 'Le Partenaire et son Admin-Partenaire ont été créé'
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'status1' => 500,
            'message1' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);
    }


    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }       
}
