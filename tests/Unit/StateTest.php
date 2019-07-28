<?php

namespace Unit;

use Model\State;

class StateTest extends \TestCase
{
    /**
     * @var \Repository\State
     */
    protected $stateRepository;

    protected static function getFixtures(): iterable
    {
        return [
            new \Fixture\Country,
            new \Fixture\State,
            new \Fixture\County,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->stateRepository = $this->entityManager->getRepository(State::class);
    }

    public function testTaxData()
    {
        $data = $this->stateRepository->getAllTaxData();

        $this->assertCount(3, $data);

        $this->assertSame((float)200 + 180 + 320, $data[0]->overallTaxAmount);
        $this->assertSame((float)(200 + 180 + 320) / 3, $data[0]->averageTaxAmount);
        $this->assertSame((float)(0.2 + 0.25 + 0.18) / 3, $data[0]->averageTaxRate);

        $this->assertSame((float)99, $data[1]->overallTaxAmount);
        $this->assertSame((float)99 / 2, $data[1]->averageTaxAmount);
        $this->assertSame((float)0.1 / 2, $data[1]->averageTaxRate);

        $this->assertSame((float)765.77 + 2 + 11.1, $data[2]->overallTaxAmount);
        $this->assertSame((float)(765.77 + 2 + 11.1) / 3, $data[2]->averageTaxAmount);
        $this->assertSame((float)(0.2 + 0.25 + 0.18) / 3, $data[2]->averageTaxRate);
    }

    public function testOverallTaxAmount()
    {
        $this->assertOverallTaxAmount('State 1', 200 + 180 + 320);
        $this->assertOverallTaxAmount('State 2', 99);
        $this->assertOverallTaxAmount('State 3', 765.77 + 2 + 11.1);
        $this->assertOverallTaxAmount('State 4', 0);
    }

    public function testAverageTaxAmount()
    {
        $this->assertAverageTaxAmount('State 1', (200 + 180 + 320) / 3);
        $this->assertAverageTaxAmount('State 2', 99 / 2);
        $this->assertAverageTaxAmount('State 3', (765.77 + 2 + 11.1) / 3);
        $this->assertAverageTaxAmount('State 4', 0);
    }

    public function testAverageTaxRate()
    {
        $this->assertAverageTaxRate('State 1', (0.2 + 0.25 + 0.18) / 3);
        $this->assertAverageTaxRate('State 2', 0.1 / 2);
        $this->assertAverageTaxRate('State 3', (0.2 + 0.25 + 0.18) / 3);
        $this->assertAverageTaxRate('State 4', 0);
    }

    private function getModel(string $name): State
    {
        /** @var State $state */
        $state = $this->stateRepository->findOneBy(['name' => $name]);
        return $state;
    }

    private function assertOverallTaxAmount(string $name, float $value)
    {
        $modelId = $this->getModel($name)->getId();
        $this->assertSame((float)$value, $this->stateRepository->getOverallTaxAmount($modelId));
    }

    private function assertAverageTaxAmount(string $name, float $value)
    {
        $modelId = $this->getModel($name)->getId();
        $this->assertSame((float)$value, $this->stateRepository->getAverageTaxAmount($modelId));
    }

    private function assertAverageTaxRate(string $name, float $value)
    {
        $modelId = $this->getModel($name)->getId();
        $this->assertSame((float)$value, $this->stateRepository->getAverageTaxRate($modelId));
    }
}
