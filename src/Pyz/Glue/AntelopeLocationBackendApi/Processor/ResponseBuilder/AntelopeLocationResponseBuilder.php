<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder;

use Generated\Shared\Transfer\AntelopeLocationBackendApiAttributesTransfer;
use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Generated\Shared\Transfer\GlueErrorTransfer;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Pyz\Glue\AntelopeLocationBackendApi\AntelopeLocationBackendApiConfig;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper\AntelopeLocationMapperInterface;

class AntelopeLocationResponseBuilder implements AntelopeLocationResponseBuilderInterface
{
    public function __construct(
        protected AntelopeLocationMapperInterface $antelopeLocationMapper,
    ) {
    }

    public function createAntelopeLocationResponse(
        AntelopeLocationCollectionTransfer $antelopeLocationCollectionTransfer,
    ): GlueResponseTransfer {
        $glueResponseTransfer = new GlueResponseTransfer();

        foreach ($antelopeLocationCollectionTransfer->getAntelopeLocations() as $antelopeLocationTransfer) {
            $glueResponseTransfer->addResource($this->mapAntelopeLocationTransferToGlueResourceTransfer($antelopeLocationTransfer));
        }

        return $glueResponseTransfer;
    }

    public function createErrorResponse(int $httpStatus, string $message): GlueResponseTransfer
    {
        $glueErrorTransfer = (new GlueErrorTransfer())
            ->setStatus($httpStatus)
            ->setCode((string)$httpStatus)
            ->setMessage($message);

        return (new GlueResponseTransfer())
            ->setHttpStatus($httpStatus)
            ->addError($glueErrorTransfer);
    }

    protected function mapAntelopeLocationTransferToGlueResourceTransfer(
        AntelopeLocationTransfer $antelopeLocationTransfer,
    ): GlueResourceTransfer {
        return (new GlueResourceTransfer())
            ->setType(AntelopeLocationBackendApiConfig::RESOURCE_ANTELOPE_LOCATION)
            ->setId((string)$antelopeLocationTransfer->getIdAntelopeLocation())
            ->setAttributes(
                $this->antelopeLocationMapper->mapAntelopeLocationTransferToAntelopeLocationBackendApiAttributes(
                    $antelopeLocationTransfer,
                    new AntelopeLocationBackendApiAttributesTransfer(),
                ),
            );
    }
}
