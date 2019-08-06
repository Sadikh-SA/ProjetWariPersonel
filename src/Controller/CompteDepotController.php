<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Compte;
use App\Entity\Partenaire;
use App\Entity\Depot;
use App\Entity\Utilisateur;

/**
 * @Route("/api")
 */

class CompteDepotController extends AbstractController
{
    /**
     * @Route("/compte/partenaire/inserer", name="inserer_un_compte_partenaire", methods={"POST"})
     */
    public function register(Request $request, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if(isset($values->codeBank, $values->nomBeneficiaire)) {
                $compte = new Compte();
                $compte->setNomBeneficiaire(trim($values->nomBeneficiaire))
                       ->setCodeBank($values->codeBank)
                       ->setNumeroCompte(trim("SA".rand(10000000,99999999)."A19"))
                       ->setMontant(0);
                $idpartenaire=$compte->setIdPartenaire($this->getDoctrine()->getRepository(Partenaire::class)->find($values->idPartenaire));
                $compte->setIdPartenaire($idpartenaire->getIdPartenaire());
                if ($idpartenaire->getIdPartenaire()==NULL) {
                    $data = [
                        'status' => 400,
                        'message' => 'Ce partenaire n\'existe pas' 
                    ];
                    return new JsonResponse($data, 400);
                } else {
                    $entityManager->persist($compte);
                    $entityManager->flush();

                    $data = [
                        'status0' => 201,
                        'message0' => 'Le compte a été créé'
                    ];

                    return new JsonResponse($data, 201);
                }
        }
        else {
            $data = [
                'status' => 500,
                'message' => 'Vous devez Renseignez tous les champs'
            ];
            return new JsonResponse($data, 500);
        }
    }


    /**
     * @Route("/depot/compte/partenaire/inserer", name="depot_argent_compte_partenaire", methods={"POST"})
     */
    public function inserer(Request $request, EntityManagerInterface $entityManager)
    {
       $values = json_decode($request->getContent());
       $errors=[];
        if (isset($values->Compte,$values->montant)) {
            if ($values->montant>=75000 && is_numeric($values->montant)) {
                $depot = new Depot();
                $depot ->setDateDeDepot(new \DateTime())
                       ->setMontantDuDepot($values->montant);
                    $idcompte=$this->getDoctrine()->getRepository(Compte::class)->findByNumeroCompte($values->Compte);
                    var_dump($idcompte);die();
                    $idcaissier= $this->getUser();
                    if ($idcaissier==NULL || $idcompte==NULL) {
                        $errors[]= "Ce compte ou Partenaire n'exite pas";
                    } else {
                        $depot->setIdCompte($idcompte[0]);
                        $depot->setIdCaissier($idcaissier);
                        $idcompte[0]->setMontant($idcompte[0]->getMontant()+$values->montant);
                    }
                    
            } else {
                $errors [] = "Le Montant doit être supérieur à 75000";
            }
            if (!$errors) {
                $entityManager->persist($depot);
                $entityManager->flush();
    
                $data = [
                    'status0' => 201,
                    'message0' => 'Le dépot est fait avec succès'
                ];
    
                return new JsonResponse($data, 201);
            } else {
                return $this->json([
                    'errors' => $errors
                ], 400);
            }
            
        }
        else {
            $data = [
                'status2' => 500,
                'message2' => 'Vous devez renseigner tous les champs'
            ];
            return new JsonResponse($data, 500);
        }

    }
}
