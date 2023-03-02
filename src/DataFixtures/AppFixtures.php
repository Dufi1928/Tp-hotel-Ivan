<?php
namespace App\DataFixtures;

use App\Entity\Suite;
use App\Entity\Hotel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 5; $i++) {
            $hotel = new Hotel();
            $hotel->setAdress($faker->address);
            $hotel->setName($faker->company);
            $hotel->setCity($faker->city);
            $hotel->setNumberOfRooms($faker->numberBetween(50, 200));
            $hotel->setEmail($faker->email);
            $hotel->setDescription($faker->paragraph(3));
            $hotel->setCoverImg('hotel-' . $i . '.jpg');

            $manager->persist($hotel);
        }
        $manager->flush();
        $hotels = $manager->getRepository(Hotel::class)->findAll();
        for ($i = 1; $i <= 200; $i++) {
            $roomNumber = $faker->numberBetween(1, 8);
            $photoName = 'room-' . $roomNumber . '.jpg';

            $suite = new Suite();
            $suite->setName('Suite ' . $i)
                ->setDescription($faker->sentence(10))
                ->setPhoto($photoName)
                ->setPrice($faker->randomFloat(2, 100, 500))
                ->setBeds($faker->numberBetween(1, 3))
                ->setBathroom($faker->numberBetween(1, 2))
                ->setSize($faker->randomFloat(2, 40, 100));
            $randomHotel = $faker->randomElement($hotels);
            $suite->setHotel($randomHotel);

            $manager->persist($suite);
        }

        $manager->flush();
    }
}