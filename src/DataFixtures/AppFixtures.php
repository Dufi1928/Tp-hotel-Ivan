<?php

namespace App\DataFixtures;

use App\Entity\Suite;
use App\Entity\Hotel;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Storage\StorageInterface;
use Vich\UploaderBundle\Naming\SmartUniqueNamer;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager,)
    {
        $majorCities = [
            'Paris',
            'Lyon',
            'Marseille',
            'Toulouse',
            'Bordeaux',
            'New York',
            'London',
            'Tokyo',
            'Hong Kong',
            'Shanghai',
            'Beijing',
            'Mumbai',
            'Rio de Janeiro',
            'Istanbul',
            'Sydney',
        ];

        $faker = Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            $hotelNumber = $faker->numberBetween(1, 7);
            $hotel = new Hotel();
            $hotel->setAddress($faker->address);
            $hotel->setName($faker->company);
            $hotel->setCity($faker->randomElement($majorCities));
            $hotel->setNumberOfRooms($faker->numberBetween(50, 200));
            $hotel->setEmail($faker->email);
            $hotel->setDescription($faker->paragraph(3));
            $hotel->setCoverImgName('image' . $hotelNumber . '.jpg');

            $manager->persist($hotel);
        }

        $manager->flush();

        $faker = Factory::create();
        $hotels = $manager->getRepository(Hotel::class)->findAll();

        for ($i = 1; $i <= 200; $i++) {
            $roomNumber = $faker->numberBetween(1, 7);
            $photoName = 'room-' . $roomNumber . '.jpg';

            $suite = new Suite();
            $suite->setName('Suite ' . $i);
            $suite->setImageName($photoName);
            $suite->setDescription($faker->sentence(10));
            $suite->setPrice($faker->randomFloat(2, 100, 500) * 100);
            $suite->setBeds($faker->numberBetween(1, 3));
            $suite->setBathroom($faker->numberBetween(1, 2));
            $suite->setSize($faker->randomFloat(2, 40, 100));

            $randomHotel = $faker->randomElement($hotels);
            if ($randomHotel !== null) {
                $suite->setHotel($randomHotel);
            }

            $manager->persist($suite);
        }
        $manager->flush();

        $user = new User();
        $user->setEmail('bob@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->hashPassword(
            $user,
            '040998ih'
        ));
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setEmail('bob1@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->hashPassword(
            $user,
            '040998ih'
        ));
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setEmail('manager@gmail.com');
        $user->setRoles(['ROLE_MANAGER']);
        $user->setPassword($this->passwordEncoder->hashPassword(
            $user,
            '040998ih'
        ));
        $manager->persist($user);
        $manager->flush();
    }
}
