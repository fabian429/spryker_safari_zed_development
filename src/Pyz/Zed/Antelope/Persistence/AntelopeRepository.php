<?php

namespace Pyz\Zed\Antelope\Persistence;

use Generated\Shared\Transfer\AntelopeCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeTransfer;
use Generated\Shared\Transfer\AntelopeLocationCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\Antelope\Persistence\AntelopePersistenceFactory getFactory()
 */
class AntelopeRepository extends AbstractRepository implements
    AntelopeRepositoryInterface
{
    public function getAntelope(AntelopeCriteriaTransfer $antelopeCriteriaTransfer): ?AntelopeTransfer
    {
        $antelopeEntity = $this->getFactory()->createAntelopeQuery()->filterByName(
            $antelopeCriteriaTransfer->getName(),
        )->findOne();
        if (!$antelopeEntity) {
            return null;
        }
        return (new AntelopeTransfer())->fromArray($antelopeEntity->toArray(), true);
    }

    public function getAntelopeLocationByID(int $idLocation): ?AntelopeLocationTransfer
    {
        $antelopeLocationEntity = $this->getFactory()->createAntelopeLocationQuery()->findPk(
            $idLocation,
        );
        if (!$antelopeLocationEntity) {
            return null;
        }
        return (new AntelopeLocationTransfer())->fromArray($antelopeLocationEntity->toArray(), true);
    }

    public function getAntelopeLocation(
        AntelopeLocationCriteriaTransfer $antelopeLocationCriteriaTransfer
    ): ?AntelopeLocationTransfer {
        // Without any criteria findOne() would return an arbitrary row, so treat that as "not found"
        if (
            $antelopeLocationCriteriaTransfer->getIdAntelopeLocation() === null
            && $antelopeLocationCriteriaTransfer->getLocationName() === null
        ) {
            return null;
        }

        $antelopeLocationQuery = $this->getFactory()->createAntelopeLocationQuery();
        if ($antelopeLocationCriteriaTransfer->getIdAntelopeLocation() !== null) {
            $antelopeLocationQuery->filterByIdLocation($antelopeLocationCriteriaTransfer->getIdAntelopeLocation());
        }
        if ($antelopeLocationCriteriaTransfer->getLocationName() !== null) {
            $antelopeLocationQuery->filterByLocationName($antelopeLocationCriteriaTransfer->getLocationName());
        }

        $antelopeLocationEntity = $antelopeLocationQuery->findOne();
        if (!$antelopeLocationEntity) {
            return null;
        }
        return (new AntelopeLocationTransfer())->fromArray($antelopeLocationEntity->toArray(), true);
    }
}
