<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        if(isset($values->username,$values->password,$values->prenom,$values->nom,$values->tel,$values->adresse,$values->profil,$values->photo)) {
            $user = new Utilisateur();
            $user->setEmail(trim($values->username));
            $user->setPassword($passwordEncoder->encodePassword($user, trim($values->password)));
            $user->setPrenom(trim($values->prenom));
            $user->setNom(trim($values->nom));
            $user->setTel(trim($values->tel));
            $user->setAdresse(trim($values->adresse));
            $user->setProfil(trim($values->profil));
            $user->setPhoto(trim($values->photo));
            if (strtolower($user->getProfil())==strtolower("Super-Admin")) {
                $user->setRoles(['ROLE_Super-Admin']);
            }elseif (strtolower($user->getProfil())==strtolower("Admin-Partenaire")) {
                $user->setRoles(['ROLE_Admin-Partenaire']);
                if (!isset($values->ninea)) {
                    $idpartenaire=$user->setIdPartenaire($this->getDoctrine()->getRepository(Partenaire::class)->find($values->idPartenaire));
                    if ($idpartenaire->getIdPartenaire()!=NULL) {
                        $user->setIdPartenaire($idpartenaire->getIdPartenaire());
                    } else {
                        $data = [
                            'status15' => 305,
                            'message15' => 'Ce Partenaire n\'existe pas'
                        ];
                        return new JsonResponse($data, 305);
                    }
                } else {
                        $partenaire = new Partenaire();
                        $partenaire->setNinea($values->ninea);
                        $partenaire->setLocalisation(trim($values->localisation));
                        $partenaire->setDomaineDActivite(trim($values->domaine));
                        $entityManager->persist($partenaire);
                        $user->setIdPartenaire($partenaire);
                        if (isset($values->codeBank) && strlen($values->codeBank)==6 && is_numeric($values->codeBank)) {
                            $compte = new Compte();
                            $compte->setCodeBank($values->codeBank);
                            $compte->setNumeroCompte("SA".rand(100000000,99999999)."A19");
                            $compte->setNomBeneficiaire(trim($values->prenom)." ".trim($values->nom));
                            $compte->setMontant(0);
                            $compte->setIdPartenaire($partenaire);
                            $entityManager->persist($compte);
                            $user->setIdCompte($compte);
                        }
                        else {
                            $data = [
                                'status16' => 700,
                                'message16' => 'Vous n\'avez pas renseigné le code Bank ou bien ce code doit être numérique et 6 chiffre' 
                            ];
                            return new JsonResponse($data, 700);
                        }
                }   
            }
            elseif(strtolower($user->getProfil())==strtolower("Utilisateur") || strtolower($user->getProfil())==strtolower("Caissier")) {
                $idpartenaire=$user->setIdPartenaire($this->getDoctrine()->getRepository(Partenaire::class)->find($values->idPartenaire));
                if ($idpartenaire->getIdPartenaire()!=NULL) {
                    $user->setIdPartenaire($idpartenaire->getIdPartenaire());
                } else {
                    $data = [
                        'status15' => 305,
                        'message15' => 'Ce Partenaire n\'existe pas'
                    ];
                    return new JsonResponse($data, 305);
                }
                
                
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
     * isGranted({"ROLE_Super-Admin", "ROLE_Admin-Partenaire"})
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
     * @IsGranted({"ROLE_Super-Admin", "ROLE_Admin-Partenaire"})
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
                    'message12' => 'Ce Compte de travail a bien été mis à jour'
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
