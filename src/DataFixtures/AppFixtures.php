<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Phone;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create('fr_FR');
        $user = new User();
        $user->setEmail('user@user.com')
             ->setPassword('$2y$13$vtgqKAtTOc.A7RxKIuRc6uhcQrOcbJU0/X8kgTbEvVsT9LJYzSKN.')
             ->setRoles(["ROLE_USER"])
             ->setNom($faker->lastName())
             ->setPrenom($faker->firstNameFemale());
        $manager->persist($user);     
        
        $user2 = new User();
        $user2->setEmail('user2@user.com')
             ->setPassword('$2y$13$vtgqKAtTOc.A7RxKIuRc6uhcQrOcbJU0/X8kgTbEvVsT9LJYzSKN.')
             ->setRoles(["ROLE_USER"])
             ->setNom($faker->lastName())
             ->setPrenom($faker->firstNameMale());     
        $manager->persist($user2);    
        
        $admin = new User();
        $admin->setEmail('admin@admin.com')
             ->setPassword('$2y$13$vtgqKAtTOc.A7RxKIuRc6uhcQrOcbJU0/X8kgTbEvVsT9LJYzSKN.')
             ->setRoles(["ROLE_ADMIN"])
             ->setNom($faker->lastName())
             ->setPrenom($faker->firstNameMale());  
        $manager->persist($admin);

        for($i = 0; $i < 10; $i++){
        
            $client = new Client();

            $client->setNom($faker->lastName())
                   ->setPrenom($faker->firstNameFemale())
                   ->setMail($faker->email())
                   ->setAdresse($faker->address())
                   ->setTelephone($faker->phoneNumber())
                   ->setDateAjoutAt($faker->dateTimeBetween('-6 months'))
                   ->setUser($user);

            $manager->persist($client);
        }

        for($i = 0; $i < 10; $i++){
        
            $client = new Client();

            $client->setNom($faker->lastName())
                   ->setPrenom($faker->firstNameMale())
                   ->setMail($faker->email())
                   ->setAdresse($faker->address())
                   ->setTelephone($faker->phoneNumber())
                   ->setDateAjoutAt($faker->dateTimeBetween('-6 months'))
                   ->setUser($user2);

            $manager->persist($client);
        }

        for($i = 0; $i < 20; $i++){
        
            $phone = new Phone();

            $phone->setNom($faker->word(8))
                  ->setReference($faker->randomNumber(8))
                  ->setCouleur($faker->colorName())
                  ->setDimension($faker->randomNumber(2) . 'x' . $faker->randomNumber(2) )
                  ->setPrix($faker->randomNumber(3))
                  ->setImage($faker->imageUrl())
                  ->setDescription($faker->paragraph())
                  ->setDateAjoutAt($faker->dateTimeBetween('-6 months'));
                   
            $manager->persist($phone);
        }

    $manager->flush();
    
    }
}
