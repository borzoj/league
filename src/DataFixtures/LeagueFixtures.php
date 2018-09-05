<?php

namespace App\DataFixtures;

use App\Entity\League;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LeagueFixtures extends Fixture
{
    const LEAGUES = [
        1 => 'league one',
        2 => 'league two',
        3 => 'league three',
        4 => 'league four',
        5 => 'league five',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::LEAGUES as $id => $name) {
            $league = new League();
            $league->setId($id);
            $league->setName($name);
            $manager->persist($league);
        }

        $manager->flush();
    }
}
