<?php
/**
 * Created by PhpStorm.
 * User: uob
 * Date: 07/09/18
 * Time: 00:16
 */

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class TeamFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (LeagueFixtures::LEAGUE_NAMES as $id => $name) {
            $league = $this->getReference('league_'.$id);
            $leagueId = $league->getId();
            $leagueName = $league->getName();
            for ($j = 1; $j <= 5; $j++) {
                $team = new Team();
                $team->setName("team $leagueId.$j");
                $team->setStrip("in league $leagueId");
                $team->setLeague($league);
                $manager->persist($team);
            }
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return array(
            LeagueFixtures::class,
        );
    }
}