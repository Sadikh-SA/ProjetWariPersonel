<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Utilisateur;
use App\Entity\Partenaire;
use App\Entity\Compte;

/**
 * @Route("/api")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/Partenaire/Utilisateur/inserer", name="inserer_un_partenaire_ou_utilisateur", methods={"POST"})
     */
    public function Ajouter_Partenaire_Utilisateur(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
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
                    $user->setIdPartenaire($idpartenaire->getIdPartenaire());
                } else {
                    $partenaire = new Partenaire();
                    $partenaire->setNinea($values->ninea);
                    $partenaire->setLocalisation($values->localisation);
                    $partenaire->setDomaineDActivite($values->domaine);
                    $entityManager->persist($partenaire);
                    $user->setIdPartenaire($partenaire);
                }   
            }
            elseif($user->getProfil()=="Utilisateur" || $user->getProfil()=="Caissier") {
                $idpartenaire=$user->setIdPartenaire($this->getDoctrine()->getRepository(Partenaire::class)->find($values->idPartenaire));
                $user->setIdPartenaire($idpartenaire->getIdPartenaire());
                if ($user->getProfil()=="Caissier") {
                    $user->setRoles(['ROLE_Caissier']);
                } else {
                    $user->setRoles(['ROLE_Utilisateur']);
                }
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
     * @Route("/utilisateur/status/{id}", name="update_status", methods={"PUT"})
     */
    public function update_Status(Request $request, Utilisateur $user, EntityManagerInterface $entityManager)
    {
        if ($user==NULL) {
            $data = [
                'status10' => 500,
                'message10' => 'cet utilisateur n\'existe pas dans la base' 
            ];
            return new JsonResponse($data,500);
        } else {
            $values = json_decode($request->getContent());
            $userModif = $entityManager->getRepository(Utilisateur::class)->find($user->getId());
            $userModif->SetStatus($values->status);
            $entityManager->flush();
            $data = [
                'status11' => 200,
                'message11' => 'Le statut de cet utilisateur a bien été mis à jour'
            ];
            return new JsonResponse($data,200);
        }


    }

    /**
     * @Route("/utilisateur/compte/{id}", name="update_compte", methods={"PUT"})
     */
    public function update_Compte(Request $request, Utilisateur $user, EntityManagerInterface $entityManager)
    {
        if ($user==NULL) {
            $data = [
                'status10' => 404,
                'message10' => 'cet utilisateur n\'existe pas dans la base' 
            ];
            return new JsonResponse($data,404);
        } else {
            $values = json_decode($request->getContent());
            $userModif = $entityManager->getRepository(Utilisateur::class)->find($user->getId());
            $idcompte=$userModif->setIdCompte($this->getDoctrine()->getRepository(Compte::class)->find($values->Compte));
            if ($idcompte->getIdCompte()!=NULL) {
                $userModif->SetIdCompte($idcompte->getIdCompte());
                $entityManager->flush();
                $data = [
                    'status12' => 200,
                    'message12' => 'Le Compte de travail de cet utilisateur a bien été mis à jour'
                ];
                return new JsonResponse($data,200);
            } else {
                $data = [
                    'status13' => 500,
                    'message13' => 'Ce compte d\'utilisateur n\'existe pas'
                ];
                return new JsonResponse($data,500);
            }
            
            
        }

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
