<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper;

use Generated\Shared\Transfer\AntelopeLocationBackendApiAttributesTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;

class AntelopeLocationMapper implements AntelopeLocationMapperInterface
{
    public function mapAntelopeLocationBackendApiAttributesToAntelopeLocationTransfer(
        AntelopeLocationBackendApiAttributesTransfer $antelopeLocationBackendApiAttributesTransfer,
        AntelopeLocationTransfer $antelopeLocationTransfer,
    ): AntelopeLocationTransfer {
        return $antelopeLocationTransfer->fromArray($antelopeLocationBackendApiAttributesTransfer->toArray(), true);
    }

    public function mapAntelopeLocationTransferToAntelopeLocationBackendApiAttributes(
        AntelopeLocationTransfer $antelopeLocationTransfer,
        AntelopeLocationBackendApiAttributesTransfer $antelopeLocationBackendApiAttributesTransfer,
    ): AntelopeLocationBackendApiAttributesTransfer {
        return $antelopeLocationBackendApiAttributesTransfer->fromArray($antelopeLocationTransfer->toArray(), true);
    }
}
