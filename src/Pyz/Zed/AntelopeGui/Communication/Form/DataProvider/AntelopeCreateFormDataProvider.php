<?php

declare(strict_types=1);

namespace Pyz\Zed\AntelopeGui\Communication\Form\DataProvider;

use Orm\Zed\Antelope\Persistence\PyzAntelopeLocationQuery;
use Pyz\Zed\AntelopeGui\Communication\Form\AntelopeCreateForm;

class AntelopeCreateFormDataProvider
{
    public function __construct(protected PyzAntelopeLocationQuery $antelopeLocationQuery)
    {
    }

    /**
     * @return array<string,mixed>
     */
    public function getOptions(): array
    {
        return [
            AntelopeCreateForm::OPTION_ANTELOPE_LOCATION_CHOICES => $this->getAntelopeLocationChoices(),
        ];
    }

    /**
     * @return array<string,int> location name => id_location
     */
    protected function getAntelopeLocationChoices(): array
    {
        $antelopeLocationEntityCollection = $this->antelopeLocationQuery
            ->orderByLocationName()
            ->find();

        $antelopeLocationChoices = [];
        foreach ($antelopeLocationEntityCollection as $antelopeLocationEntity) {
            $antelopeLocationChoices[$antelopeLocationEntity->getLocationName()] = $antelopeLocationEntity->getIdLocation();
        }

        return $antelopeLocationChoices;
    }
}
