<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Deleter;

use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Propel\Runtime\Exception\ExceptionInterface as PropelExceptionInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder\AntelopeLocationResponseBuilderInterface;
use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;
use Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class AntelopeLocationDeleter implements AntelopeLocationDeleterInterface
{
    public function __construct(
        protected AntelopeFacadeInterface $antelopeFacade,
        protected AntelopeLocationResponseBuilderInterface $antelopeLocationResponseBuilder,
    ) {
    }

    public function deleteAntelopeLocation(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        try {
            $this->antelopeFacade->deleteAntelopeLocation((int)$glueRequestTransfer->getResource()?->getId());
        } catch (EntityNotFoundException $exception) {
            return $this->antelopeLocationResponseBuilder->createErrorResponse(Response::HTTP_NOT_FOUND, $exception->getMessage());
        } catch (PropelExceptionInterface $exception) {
            return $this->antelopeLocationResponseBuilder->createErrorResponse(
                Response::HTTP_CONFLICT,
                'Antelope location is still referenced and cannot be deleted.',
            );
        }

        return $this->antelopeLocationResponseBuilder
            ->createAntelopeLocationResponse(new AntelopeLocationCollectionTransfer())
            ->setHttpStatus(Response::HTTP_NO_CONTENT);
    }
}
