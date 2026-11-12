<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Reader;

use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\AntelopeLocationCriteriaTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder\AntelopeLocationResponseBuilderInterface;
use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;
use Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class AntelopeLocationReader implements AntelopeLocationReaderInterface
{
    public function __construct(
        protected AntelopeFacadeInterface $antelopeFacade,
        protected AntelopeLocationResponseBuilderInterface $antelopeLocationResponseBuilder,
    ) {
    }

    public function getAntelopeLocationCollection(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $antelopeLocationCollectionTransfer = $this->antelopeFacade
            ->getAntelopeLocationCollection(new AntelopeLocationCriteriaTransfer());

        return $this->antelopeLocationResponseBuilder->createAntelopeLocationResponse($antelopeLocationCollectionTransfer);
    }

    public function getAntelopeLocation(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $antelopeLocationCriteriaTransfer = (new AntelopeLocationCriteriaTransfer())
            ->setIdAntelopeLocation((int)$glueRequestTransfer->getResource()?->getId());

        try {
            $antelopeLocationResponseTransfer = $this->antelopeFacade->getAntelopeLocation($antelopeLocationCriteriaTransfer);
        } catch (EntityNotFoundException $exception) {
            return $this->antelopeLocationResponseBuilder->createErrorResponse(Response::HTTP_NOT_FOUND, $exception->getMessage());
        }

        $antelopeLocationCollectionTransfer = (new AntelopeLocationCollectionTransfer())
            ->addAntelopeLocation($antelopeLocationResponseTransfer->getAntelopeLocationOrFail());

        return $this->antelopeLocationResponseBuilder->createAntelopeLocationResponse($antelopeLocationCollectionTransfer);
    }
}
