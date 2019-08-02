<?php

namespace Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class StateRandom extends AbstractFixture implements DependentFixtureInterface
{
    const MAX = 20;

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
        $count = 0;
        foreach ($this->generator() as $num => $state) {
            $count++;
            $manager->persist($state);
            $this->addReference("state$num", $state);
        }
        $manager->flush();
    }

    protected function generator()
    {
        $countryNum = 0;
        while ($country = $this->getCountry($countryNum)) {
            /** @var \Model\Country $country */
            foreach (range(0, rand(0, static::MAX)) as $stateNum) {
                $stateNum++;
                $state = new \Model\State;
                $state->setName("State $stateNum");
                $state->setCountry($country);
                yield $state;
            }
            $countryNum++;
        }
    }

    protected function getCountry(int $num)
    {
        try {
            return $this->getReference("country$num");
        } catch (\OutOfBoundsException $e) {
            return null;
        }
    }
}
