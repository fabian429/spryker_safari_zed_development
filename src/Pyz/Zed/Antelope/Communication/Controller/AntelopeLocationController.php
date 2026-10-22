<?php

namespace Pyz\Zed\Antelope\Communication\Controller;

use Faker\Factory as FakerFactory;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Generated\Shared\Transfer\AntelopeLocationCriteriaTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Antelope\Business\AntelopeFacadeInterface getFacade()
 */
class AntelopeLocationController extends AbstractController
{

    public function addAction(Request $request): array
    {
        $antelopeLocationTransfer = new AntelopeLocationTransfer();
        $locationName = $request->get('locationName');
        if (!$locationName) {
            $locationName = FakerFactory::create()->city();
        }
        $antelopeLocationTransfer->setLocationName($locationName);
        $antelopeLocationTransfer = $this->getFacade()->createAntelopeLocation($antelopeLocationTransfer);

        return $this->viewResponse(['location' => $antelopeLocationTransfer]);
    }

    public function getAction(Request $request): array
    {
        $antelopeLocationCriteriaTransfer = new AntelopeLocationCriteriaTransfer();
        if ($request->query->has('id')) {
            $antelopeLocationCriteriaTransfer->setIdAntelopeLocation($this->castId($request->query->get('id')));
        }
        if ($request->query->has('locationName')) {
            $antelopeLocationCriteriaTransfer->setLocationName($request->query->get('locationName'));
        }

        return $this->viewResponse(
            [
                'locationResponse' => $this->getFacade()->getAntelopeLocation(
                    $antelopeLocationCriteriaTransfer,
                ),
            ],
        );
    }
}
