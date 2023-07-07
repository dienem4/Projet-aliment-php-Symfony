<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $a1 = new Aliment();
        $a1->setNom("Carotte")
            ->setCalorie(36)
            ->setPrix(1.80)
            ->setImage("carotte.png")
            ->setProteines(0.77)
            ->setGlucides(6.45)
            ->setLipides(0.26);
        $manager->persist($a1);

        $a2 = new Aliment();
        $a2->setNom("Patate")
            ->setPrix(1.50)
            ->setCalorie(80)
            ->setImage("patate.jpg")
            ->setProteines(1.80)
            ->setGlucides(16.7)
            ->setLipides(0.34);
        $manager->persist($a2);

        $a3 = new Aliment();
        $a3->setNom("Tomate")
            ->setPrix(2.30)
            ->setCalorie(18)
            ->setImage("tomate.png")
            ->setProteines(0.86)
            ->setGlucides(2.26)
            ->setLipides(0.24);
        $manager->persist($a3);

        $a4 = new Aliment();
        $a4->setNom("Pomme")
            ->setPrix(2.35)
            ->setCalorie(52)
            ->setImage("pomme.png")
            ->setProteines(0.25)
            ->setGlucides(11.6)
            ->setLipides(0.25);
        $manager->persist($a4);

        $manager->flush();
    }
}
