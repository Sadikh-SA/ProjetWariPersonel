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
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

/**
 * @Route("/api")
 */
class UtilisateurController extends AbstractController
{


    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder )
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/Partenaire/Utilisateur/inserer", name="inserer_un_partenaire_ou_utilisateur", methods={"POST"})
     */
    public function Ajouter_Partenaire_Utilisateur(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $user = new Utilisateur();
        $values = json_decode($request->getContent());
        $errors = [];
        if(isset($values->username,$values->password,$values->prenom,$values->nom,$values->tel,$values->adresse,$values->profil,$values->photo)) {
            
            $user->setEmail(trim($values->username));
            $user->setPassword($passwordEncoder->encodePassword($user, trim($values->password)));
            $user->setPrenom(trim($values->prenom));
            $user->setNom(trim($values->nom));
            $user->setRoles(['ROLE_Super-Admin']);
            $user->setTel(trim($values->tel));
            $user->setAdresse(trim($values->adresse));
            $user->setProfil(trim(ucfirst(strtolower($values->profil))));
            $user->setPhoto(trim($values->photo));
            $idpartenaire=$user->setIdPartenaire($this->getDoctrine()->getRepository(Partenaire::class)->find($values->idPartenaire));
            if (strtolower($user->getProfil())==strtolower("Admin-Partenaire") && !isset($values->ninea) && $idpartenaire->getIdPartenaire()!=NULL) {
                $user->setRoles(['ROLE_Admin-Partenaire']);
                $user->setIdPartenaire($idpartenaire->getIdPartenaire());
            }elseif (strtolower($user->getProfil())==strtolower("Admin-Partenaire") && isset($values->ninea) && isset($values->codeBank) && strlen($values->codeBank)==6 && is_numeric($values->codeBank)) {
                $user->setRoles(['ROLE_Admin-Partenaire']);
                $partenaire = new Partenaire();
                $partenaire->setNinea($values->ninea);
                $partenaire->setLocalisation(trim($values->localisation));
                $partenaire->setDomaineDActivite(trim($values->domaine));
                $entityManager->persist($partenaire);
                $user->setIdPartenaire($partenaire);
                $compte = new Compte();
                $compte->setCodeBank($values->codeBank);
                $compte->setNumeroCompte("SA".rand(10000000,99999999)."A19");
                $compte->setNomBeneficiaire(trim($values->prenom)." ".trim($values->nom));
                $compte->setMontant(0);
                $compte->setIdPartenaire($partenaire);
                $entityManager->persist($compte);
                $user->setIdCompte($compte);      
            }
            elseif(strtolower($user->getProfil())==strtolower("Utilisateur") || strtolower($user->getProfil())==strtolower("Caissier") && $idpartenaire->getIdPartenaire()!=NULL) {
                $idpartenaire=$user->setIdPartenaire($this->getDoctrine()->getRepository(Partenaire::class)->find($values->idPartenaire));
                $user->setIdPartenaire($idpartenaire->getIdPartenaire());
                if ($user->getProfil()=="Caissier") {
                    $user->setRoles(['ROLE_Caissier']);
                } else {
                    $user->setRoles(['ROLE_Utilisateur']);
                }
            }
            else {
                $errors[] = "Ce profil n\'existe pas vérifie bien ou l'Id du Partenaire n'existe pas ou le Code Bank n'est pas valide. Le code Bank doit être numérique et doit 6 caractères";
            }
            if (!$errors) {
                $user->setStatus(true);
                $entityManager->persist($user);
                $entityManager->flush();
    
                $data = [
                    'status0' => 201,
                    'message0' => 'Le Partenaire et son Admin-Partenaire ont été créé'
                ];
    
                return new JsonResponse($data,201);
            } else {
                return $this->json([
                    'errors' => $errors
                ], 400);
            }
        }
        $data = [
            'status1' => 500,
            'message1' => 'Vous devez renseigner tous les champs'
        ];
        return new JsonResponse($data,500);
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
     * @param JWTEncoderInterface $JWTEncoder
     * @param JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function login(Request $request , JWTEncoderInterface $JWTEncoder)
    {

        $values = json_decode($request->getContent());
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy([
            'email' => $values->username,
        ]);

        $isValid = $this->passwordEncoder->isPasswordValid($user, $values->password);
        if (!$isValid || !$user) {
            $data = [
                'code' => 401,
                'messag' => 'Username ou Mot de Passe incorrecte'
            ];
            return new JsonResponse($data,300);
        }
        if ($user->getStatus()==false) {
            $data = [
                'status135' => 404,
                'message135' => 'Ce compte est Bloqué'
            ];
            return new JsonResponse($data,404);
            
        }
        $token = $JWTEncoder->encode([
                'email' => $user->getEmail(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);
        return $this->json([
            'token' => $token
        ]);
    }       
}
