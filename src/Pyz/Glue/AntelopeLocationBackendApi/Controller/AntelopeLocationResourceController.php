<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi\Controller;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Spryker\Glue\Kernel\Backend\Controller\AbstractController;

class AntelopeLocationResourceController extends AbstractController
{
    public function getCollectionAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        return new GlueResponseTransfer();
    }

    public function getAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        return new GlueResponseTransfer();
    }

    public function postAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        return new GlueResponseTransfer();
    }

    /**
     * Updates an existing antelope location identified by the resource id in the URL.
     */
    public function putAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        return new GlueResponseTransfer();
    }

    /**
     * The backend router uses patch but in Step1 stands put
     */
    public function patchAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        return $this->putAction($glueRequestTransfer);
    }

    public function deleteAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        return new GlueResponseTransfer();
    }
}
