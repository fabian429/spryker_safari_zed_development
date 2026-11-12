<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Reader;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;

interface AntelopeLocationReaderInterface
{
    public function getAntelopeLocationCollection(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer;

    public function getAntelopeLocation(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer;
}
