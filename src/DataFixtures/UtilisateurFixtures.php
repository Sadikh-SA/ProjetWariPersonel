<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurFixtures extends Fixture
{
    private $passwordEncoder;
    
    public function __construct( UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        
        $user = new Utilisateur();
                $user->setEmail("Sadikh");
                $user->setPassword($this->passwordEncoder->encodePassword($user, "Moimeme"));
                $user->setPrenom("Ababacar Sadikh");
                $user->setNom("GUEYE");
                $user->setAdresse("101 Hamo 4 Guédiawaye");
                $user->setEmail("abougueye96@yahoo.fr");
                $user->setTel("784408822");
                $user->setProfil("Super-Admin");
                if ($user->getProfil()=="Super-Admin") {
                    $user->setRoles(['ROLE_Super-Admin']);
                }elseif ($user->getProfil()=="Admin-Partenaire") {
                    $user->setRoles(['ROLE_Admin-Partenaire']);
                }elseif ($user->getProfil()=="Utilisateur") {
                    $user->setRoles(['ROLE_Utilisateur']);
                }
                $user->setPhoto("../../Images/sadikh.png");
                $user->setStatus(true);
        $manager->persist($user);

        $manager->flush();
    }
}
