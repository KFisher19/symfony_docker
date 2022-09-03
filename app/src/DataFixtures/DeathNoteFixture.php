<?php

namespace App\DataFixtures;

use App\Entity\DeathNote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class DeathNoteFixture extends Fixture { //клас для заповнення таблиць

    private Generator $faker;

    public function __construct() {

        $this->faker = Factory::create(); //присвоєння властивості факер нового обєкта генератора
    }

    public function load(ObjectManager $manager): void
    {  //функція загрузки приймає змінну типу інтерфейс, яка управляє
                                            //таблицями
        for ($i = 0; $i < 10; $i++) {  //повторити 10 раз
            $manager->persist($this->getDeathNote()); //persist добавляє в таблицю новий обєкт, який получаєм від
        }                               // функції getDeathNote
        $manager->flush();  //хз, вроді завершення роботи з таблицею
    }

    private function getDeathNote(): DeathNote
    {

        return new DeathNote(   //повертає новий обєкт DeathNote
            $this->faker->name(),   //генерує імя
            $this->faker->year(),   //генерує рік
            $this->faker->city(),   //генерує місто
            $this->faker->year(),
            $this->faker->city()
        );
    }
}