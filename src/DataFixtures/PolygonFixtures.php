<?php

namespace App\DataFixtures;

use App\Entity\Polygon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Sommet;

class PolygonFixtures extends Fixture{
    public function load(ObjectManager $manager){
        $polygon = new Polygon();
        
        $polygon->setCreatedAt(new \DateTimeImmutable('2023-03-27 00:31:56'));

        $sommet1 = new Sommet();
        $sommet1->setLat(48.125211130551);
        $sommet1->setLong(6.3806733808221);
        $sommet1->setPolygon($polygon);

        $sommet2 = new Sommet();
        $sommet2->setLat(48.119214175284);
        $sommet2->setLong(6.3780984601678);
        $sommet2->setPolygon($polygon);

        $sommet3 = new Sommet();
        $sommet3->setLat(48.117533373578);
        $sommet3->setLong(6.3876542776913);
        $sommet3->setPolygon($polygon);

        $sommet4 = new Sommet();
        $sommet4->setLat(48.124561813609);
        $sommet4->setLong(6.3908586242676);
        $sommet4->setPolygon($polygon);


        $manager->persist($polygon);
        $manager->persist($sommet1);
        $manager->persist($sommet2);
        $manager->persist($sommet3);
        $manager->persist($sommet4);
    
        $manager->flush();
    }
}