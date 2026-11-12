<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Antelope\Persistence;

use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Generated\Shared\Transfer\AntelopeTransfer;
use Orm\Zed\Antelope\Persistence\PyzAntelope;
use Orm\Zed\Antelope\Persistence\PyzAntelopeLocation;
use Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\Antelope\Persistence\AntelopePersistenceFactory getFactory()
 */
class AntelopeEntityManager extends AbstractEntityManager implements
    AntelopeEntityManagerInterface
{
    public function createAntelope(AntelopeTransfer $antelopeTransfer): AntelopeTransfer
    {
        $antelopeEntity = new PyzAntelope();
        $antelopeEntity->fromArray($antelopeTransfer->modifiedToArray());
        $antelopeEntity->save();

        return $antelopeTransfer->fromArray($antelopeEntity->toArray(), true);
    }

    public function createAntelopeLocation(
        AntelopeLocationTransfer $antelopeLocationTransfer,
    ): AntelopeLocationTransfer {
        $antelopeEntity = new PyzAntelopeLocation();

        $antelopeEntity->fromArray($antelopeLocationTransfer->modifiedToArray());
        $antelopeEntity->save();

        return $antelopeLocationTransfer->fromArray(
            $antelopeEntity->toArray(),
            true,
        );
    }

    public function updateAntelopeLocation(
        AntelopeLocationTransfer $antelopeLocationTransfer,
    ): AntelopeLocationTransfer {
        $idAntelopeLocation = $antelopeLocationTransfer->getIdAntelopeLocationOrFail();
        $antelopeLocationEntity = $this->findAntelopeLocationEntity($idAntelopeLocation);

        $antelopeLocationEntity->setLocationName($antelopeLocationTransfer->getLocationName());
        $antelopeLocationEntity->save();

        return $antelopeLocationTransfer->fromArray(
            $antelopeLocationEntity->toArray(),
            true,
        );
    }

    public function deleteAntelopeLocation(int $idAntelopeLocation): void
    {
        $this->findAntelopeLocationEntity($idAntelopeLocation)->delete();
    }

    /**
     * @throws \Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException
     */
    protected function findAntelopeLocationEntity(int $idAntelopeLocation): PyzAntelopeLocation
    {
        $antelopeLocationEntity = $this->getFactory()
            ->createAntelopeLocationQuery()
            ->findPk($idAntelopeLocation);

        if ($antelopeLocationEntity === null) {
            throw new EntityNotFoundException(sprintf('Antelope Location %d not found', $idAntelopeLocation));
        }

        return $antelopeLocationEntity;
    }
}
