<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class UserFixture extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this-> passwordHasher = $passwordHasher;
        
        
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user ->setUsername("admin");
        //stockage du mot de passe en clair dans une variable temporairement
        $plaintextPassword = "admin";
        //utilisation de password hasher pour hacher le mot de passe vu precedemment en clair en passant par
        //l'utilisateur et le mdp comme arguments
        $hashedPassword = $this->passwordHasher->hashPassword(
                $user, 
                $plaintextPassword
                );
        //Assignation du mot de passe haché
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();
    }
}
