<?php

namespace Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class County extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [State::class];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            // Andorra
            'state1' => [
                ['name' => 'County 1', 'taxRate' => 0.2, 'taxAmount' => 200],
                ['name' => 'County 2', 'taxRate' => 0.25, 'taxAmount' => 180],
                ['name' => 'County 3', 'taxRate' => 0.18, 'taxAmount' => 320],
            ],
            'state2' => [
                ['name' => 'County 4', 'taxRate' => 0.1, 'taxAmount' => 99],
                ['name' => 'County 5', 'taxRate' => 0, 'taxAmount' => 0],
            ],
            // Monaco
            'state3' => [
                ['name' => 'County 1', 'taxRate' => 0.2, 'taxAmount' => 765.77],
                ['name' => 'County 2', 'taxRate' => 0.25, 'taxAmount' => 2],
                ['name' => 'County 3', 'taxRate' => 0.18, 'taxAmount' => 11.1],
            ],
        ];

        foreach ($data as $stateCode => $counties) {
            /** @var \Model\State $state */
            $state = $this->getReference($stateCode);
            foreach ($counties as $data) {
                $county = new \Model\County;
                $county->setName($data['name']);
                $county->setTaxRate($data['taxRate']);
                $county->setTaxAmount($data['taxAmount']);
                $county->setState($state);
                $manager->persist($county);
            }
        }

        $manager->flush();
    }
}
