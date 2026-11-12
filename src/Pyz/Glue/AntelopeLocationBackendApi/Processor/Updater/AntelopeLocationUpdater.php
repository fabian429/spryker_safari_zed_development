<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Updater;

use Generated\Shared\Transfer\AntelopeLocationBackendApiAttributesTransfer;
use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Propel\Runtime\Exception\ExceptionInterface as PropelExceptionInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper\AntelopeLocationMapperInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder\AntelopeLocationResponseBuilderInterface;
use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;
use Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class AntelopeLocationUpdater implements AntelopeLocationUpdaterInterface
{
    public function __construct(
        protected AntelopeFacadeInterface $antelopeFacade,
        protected AntelopeLocationResponseBuilderInterface $antelopeLocationResponseBuilder,
        protected AntelopeLocationMapperInterface $antelopeLocationMapper,
    ) {
    }

    public function updateAntelopeLocation(
        AntelopeLocationBackendApiAttributesTransfer $antelopeLocationBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer,
    ): GlueResponseTransfer {
        if (!$antelopeLocationBackendApiAttributesTransfer->getLocationName()) {
            return $this->antelopeLocationResponseBuilder->createErrorResponse(
                Response::HTTP_BAD_REQUEST,
                'Attribute "locationName" is required.',
            );
        }

        $antelopeLocationTransfer = $this->antelopeLocationMapper->mapAntelopeLocationBackendApiAttributesToAntelopeLocationTransfer(
            $antelopeLocationBackendApiAttributesTransfer,
            new AntelopeLocationTransfer(),
        );

        try {
            $antelopeLocationTransfer = $this->antelopeFacade->updateAntelopeLocation($antelopeLocationTransfer);
        } catch (EntityNotFoundException $exception) {
            return $this->antelopeLocationResponseBuilder->createErrorResponse(Response::HTTP_NOT_FOUND, $exception->getMessage());
        } catch (PropelExceptionInterface $exception) {
            return $this->antelopeLocationResponseBuilder->createErrorResponse(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                'Antelope location could not be updated.',
            );
        }

        $antelopeLocationCollectionTransfer = (new AntelopeLocationCollectionTransfer())->addAntelopeLocation($antelopeLocationTransfer);

        return $this->antelopeLocationResponseBuilder->createAntelopeLocationResponse($antelopeLocationCollectionTransfer);
    }
}
