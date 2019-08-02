<?php

namespace Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CountyRandom extends AbstractFixture implements DependentFixtureInterface
{
    const MAX = 30;

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [StateRandom::class];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->generator() as $county) {
            $manager->persist($county);
        }
        $manager->flush();
    }

    protected function generator()
    {
        $stateNum = 0;
        while ($state = $this->getState($stateNum)) {
            /** @var \Model\State $state */
            foreach (range(0, rand(0, static::MAX)) as $countyNum) {
                $countyNum++;
                $county = new \Model\County;
                $county->setName("County $countyNum");
                $county->setTaxRate(rand(0, 45) / 100);
                $county->setTaxAmount(rand(0, 10000));
                $county->setState($state);
                yield $county;
            }
            $stateNum++;
        }
    }

    protected function getState(int $num)
    {
        try {
            return $this->getReference("state$num");
        } catch (\OutOfBoundsException $e) {
            return null;
        }
    }
}
