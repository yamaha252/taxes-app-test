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

    /**
     * @return \Generator<\Model\Country>
     */
    protected function generator()
    {
        /** @var \Model\Country $country */
        for ($i = 0; $country = $this->getCountry($i); $i++) {
            foreach (range(0, rand(0, static::MAX)) as $stateNum) {
                $stateNum++;
                $state = new \Model\State;
                $state->setName("State $stateNum");
                $state->setCountry($country);
                yield $state;
            }
        }
    }

    /**
     * @param int $num
     * @return \Model\Country|null
     */
    protected function getCountry(int $num)
    {
        try {
            /** @var \Model\Country $model */
            $model = $this->getReference("country$num");
            return $model;
        } catch (\OutOfBoundsException $e) {
            return null;
        }
    }
}
