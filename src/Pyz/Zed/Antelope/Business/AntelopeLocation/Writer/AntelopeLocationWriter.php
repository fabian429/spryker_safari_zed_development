<?php

namespace Pyz\Zed\Antelope\Business\AntelopeLocation\Writer;

use Generated\Shared\Transfer\AntelopeLocationResponseTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Pyz\Zed\Antelope\Persistence\AntelopeEntityManagerInterface;

class AntelopeLocationWriter
{
    public function __construct(
        protected AntelopeEntityManagerInterface $entityManager
    ) {
    }

    public function createAntelopeLocation(
        AntelopeLocationTransfer $antelopeLocationTransfer
    ): AntelopeLocationTransfer {
        return $this->entityManager->createAntelopeLocation($antelopeLocationTransfer);
    }

    public function updateAntelopeLocation(
        AntelopeLocationTransfer $antelopeLocationTransfer
    ): AntelopeLocationResponseTransfer {
        $updatedAntelopeLocationTransfer = $this->entityManager->updateAntelopeLocation($antelopeLocationTransfer);
        $antelopeLocationResponseTransfer = new AntelopeLocationResponseTransfer();
        $antelopeLocationResponseTransfer->setIsSuccessFul(false);
        if ($updatedAntelopeLocationTransfer) {
            $antelopeLocationResponseTransfer->setAntelopeLocation($updatedAntelopeLocationTransfer);
            $antelopeLocationResponseTransfer->setIsSuccessFul(true);
        }
        return $antelopeLocationResponseTransfer;
    }
}
