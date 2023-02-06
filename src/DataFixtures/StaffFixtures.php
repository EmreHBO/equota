<?php

namespace App\DataFixtures;

use App\Entity\Staff;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\Persistence\ObjectManager;
use PhpParser\Node\Expr\Cast\Bool_;

/**
 *
 */
class StaffFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $item = new Staff();
            $item->setName('name'.$i);
            $item->setSurname('surname'.$i);
            $item->setSgkNo(12345678+$i);
            $item->setTcNo(12345678+$i);
            $item->setDepartment(1);
            $item->setStartDate('2023-01-01');
            $item->setEndDate('2023-01-01');
            $item->setCreatedAt(new DateTime('now'));
            $item->setUpdatedAt(new DateTime('now'));
            $item->setIsActive(1);
            $manager->persist($item);
            $manager->flush();
        }
    }
}