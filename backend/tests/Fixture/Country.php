<?php

namespace Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class Country extends AbstractFixture
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            'country0' => 'Andorra',
            'country1' => 'Monaco',
            'country2' => 'Malta',
            'country3' => 'Laos',
            'country4' => 'Cyprus',
        ];

        foreach ($data as $code => $name) {
            $country = new \Model\Country;
            $country->setName($name);
            $manager->persist($country);
            $this->addReference($code, $country);
        }

        $manager->flush();
    }
}
