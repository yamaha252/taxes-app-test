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
            'country1' => 'Andorra',
            'country2' => 'Monaco',
            'country3' => 'Malta',
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
