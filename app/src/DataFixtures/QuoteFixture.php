<?php

namespace App\DataFixtures;

use App\Entity\Quote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class QuoteFixture extends Fixture {

    private Generator $faker;

    public function __construct() {

        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 20; $i++) {
            $manager->persist($this->getQuote());
        }
        $manager->flush();
    }
    private function getQuote(): Quote
    {

        return new Quote(
            $this->faker->sentence(10), //генерує речення мінімум з 10 слів (з рівно 10 слів?) ((ні то, ні то, я хз))
            $this->faker->name(),
            $this->faker->year(),
            $this->faker->address(),  //генерує адресу
        );
    }
}
