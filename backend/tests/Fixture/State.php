<?php

namespace Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class State extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [Country::class];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            'country0' => [
                'state1' => 'State 1',
                'state2' => 'State 2',
            ],
            'country1' => [
                'state3' => 'State 3',
                'state4' => 'State 4',
            ],
        ];

        foreach ($data as $countryCode => $states) {
            /** @var \Model\Country $country */
            $country = $this->getReference($countryCode);
            foreach ($states as $code => $name) {
                $state = new \Model\State;
                $state->setName($name);
                $state->setCountry($country);
                $manager->persist($state);
                $this->addReference($code, $state);
            }
        }

        $manager->flush();
    }
}
