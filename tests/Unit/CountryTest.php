<?php

namespace Unit;

use Model\Country;

class CountryTest extends \TestCase
{
    /**
     * @var \Repository\Country
     */
    protected $countryRepository;

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
        $this->countryRepository = \Connection::getEntityManager()->getRepository(Country::class);
    }

    public function testTaxData()
    {
        $data = $this->countryRepository->getAllTaxData();

        $this->assertCount(2, $data);

        $model = $this->getModel('Andorra');
        $item = $data[$model->getId()];
        $this->assertSame((float)(0.2 + 0.25 + 0.18 + 0.1) / 5, $item->averageTaxRate);
        $this->assertSame((float)200 + 180 + 320 + 99, $item->overallTaxAmount);

        $model = $this->getModel('Monaco');
        $item = $data[$model->getId()];
        $this->assertSame((float)(0.2 + 0.25 + 0.18) / 3, $item->averageTaxRate);
        $this->assertSame((float)765.77 + 2 + 11.1, $item->overallTaxAmount);
    }

    public function testAverageTaxRate()
    {
        $this->assertAverageTaxRate('Andorra', (0.2 + 0.25 + 0.18 + 0.1) / 5);
        $this->assertAverageTaxRate('Monaco', (0.2 + 0.25 + 0.18) / 3);
        $this->assertAverageTaxRate('Malta', 0);
    }

    public function testOverallTaxAmount()
    {
        $this->assertOverallTaxAmount('Andorra', 200 + 180 + 320 + 99);
        $this->assertOverallTaxAmount('Monaco', 765.77 + 2 + 11.1);
        $this->assertOverallTaxAmount('Malta', 0);
    }

    private function getModel(string $name): Country
    {
        /** @var Country $country */
        $country = $this->countryRepository->findOneBy(['name' => $name]);
        return $country;
    }

    private function assertAverageTaxRate(string $name, float $value)
    {
        $modelId = $this->getModel($name)->getId();
        $this->assertSame((float)$value, $this->countryRepository->getAverageTaxRate($modelId));
    }

    private function assertOverallTaxAmount(string $name, float $value)
    {
        $modelId = $this->getModel($name)->getId();
        $this->assertSame((float)$value, $this->countryRepository->getOverallTaxAmount($modelId));
    }
}
