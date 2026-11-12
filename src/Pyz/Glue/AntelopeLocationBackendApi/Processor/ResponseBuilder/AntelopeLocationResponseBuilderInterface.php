<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder;

use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;

interface AntelopeLocationResponseBuilderInterface
{
    public function createAntelopeLocationResponse(
        AntelopeLocationCollectionTransfer $antelopeLocationCollectionTransfer,
    ): GlueResponseTransfer;

    public function createErrorResponse(int $httpStatus, string $message): GlueResponseTransfer;
}
