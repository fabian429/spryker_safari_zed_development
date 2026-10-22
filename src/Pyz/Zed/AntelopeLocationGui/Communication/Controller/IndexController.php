<?php

declare(strict_types=1);

namespace Pyz\Zed\AntelopeLocationGui\Communication\Controller;

use Generated\Shared\Transfer\AntelopeLocationCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Pyz\Zed\AntelopeLocationGui\AntelopeLocationGuiConfig;
use Pyz\Zed\AntelopeLocationGui\Communication\AntelopeLocationGuiCommunicationFactory;
use Pyz\Zed\AntelopeLocationGui\Communication\Form\AntelopeLocationCreateForm;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method AntelopeLocationGuiCommunicationFactory getFactory()
 */
class IndexController extends AbstractController
{
    protected const string MESSAGE_ANTELOPE_LOCATION_CREATED_SUCCESS = 'Antelope location was successfully created.';

    protected const string MESSAGE_ANTELOPE_LOCATION_NAME_EXISTS = 'An antelope location with this name already exists.';

    protected const string MESSAGE_ANTELOPE_LOCATION_UPDATED_SUCCESS = 'Antelope location was successfully updated.';

    protected const string MESSAGE_ANTELOPE_LOCATION_NOT_FOUND = 'Antelope location not found.';

    /**
     * @return array<string,mixed>
     */
    public function indexAction(): array
    {
        $table = $this->getFactory()
            ->createAntelopeLocationTable();

        return $this->viewResponse([
            'antelopeLocationTable' => $table->render(),
            'createUrl' => $this->getAntelopeLocationCreateUrl(),
        ]);
    }

    public function tableAction(): JsonResponse
    {
        $table = $this->getFactory()
            ->createAntelopeLocationTable();

        return $this->jsonResponse($table->fetchData());
    }

    /**
     * @param Request $request
     * @return RedirectResponse|array<string,mixed>
     */
    public function createAction(Request $request): RedirectResponse|array
    {
        $antelopeLocationCreateForm = $this->getFactory()
            ->createAntelopeLocationCreateForm(new AntelopeLocationTransfer())
            ->handleRequest($request);

        if ($antelopeLocationCreateForm->isSubmitted() && $antelopeLocationCreateForm->isValid()) {
            return $this->createAntelopeLocation($antelopeLocationCreateForm);
        }

        return $this->viewResponse([
            'antelopeLocationCreateForm' => $antelopeLocationCreateForm->createView(),
            'backUrl' => $this->getAntelopeLocationListUrl(),
        ]);
    }

    /**
     * @param FormInterface $antelopeLocationCreateForm
     * @return RedirectResponse|array<string,mixed>
     */
    protected function createAntelopeLocation(
        FormInterface $antelopeLocationCreateForm
    ): RedirectResponse|array {
        $antelopeLocationTransfer = $antelopeLocationCreateForm->getData();

        if ($this->isLocationNameTaken($antelopeLocationTransfer->getLocationNameOrFail())) {
            $antelopeLocationCreateForm
                ->get(AntelopeLocationCreateForm::FIELD_LOCATION_NAME)
                ->addError(new FormError(static::MESSAGE_ANTELOPE_LOCATION_NAME_EXISTS));

            return $this->viewResponse([
                'antelopeLocationCreateForm' => $antelopeLocationCreateForm->createView(),
                'backUrl' => $this->getAntelopeLocationListUrl(),
            ]);
        }

        $this->getFactory()
            ->getAntelopeFacade()
            ->createAntelopeLocation($antelopeLocationTransfer);

        $this->addSuccessMessage(static::MESSAGE_ANTELOPE_LOCATION_CREATED_SUCCESS);

        return $this->redirectResponse($this->getAntelopeLocationListUrl());
    }

    /**
     * @param Request $request
     * @return RedirectResponse|array<string,mixed>
     */
    public function editAction(Request $request): RedirectResponse|array
    {
        $idLocation = $request->query->get(AntelopeLocationGuiConfig::PARAM_ID_LOCATION);
        if (!is_numeric($idLocation)) {
            return $this->redirectToListWithError();
        }

        $antelopeLocationResponseTransfer = $this->getFactory()
            ->getAntelopeFacade()
            ->getAntelopeLocation(
                (new AntelopeLocationCriteriaTransfer())->setIdAntelopeLocation($this->castId($idLocation))
            );
        if (!$antelopeLocationResponseTransfer->getIsSuccessFul()) {
            return $this->redirectToListWithError();
        }

        $antelopeLocationEditForm = $this->getFactory()
            ->createAntelopeLocationCreateForm($antelopeLocationResponseTransfer->getAntelopeLocationOrFail())
            ->handleRequest($request);

        if ($antelopeLocationEditForm->isSubmitted() && $antelopeLocationEditForm->isValid()) {
            return $this->updateAntelopeLocation($antelopeLocationEditForm);
        }

        return $this->viewResponse([
            'antelopeLocationEditForm' => $antelopeLocationEditForm->createView(),
            'backUrl' => $this->getAntelopeLocationListUrl(),
        ]);
    }

    /**
     * @param FormInterface $antelopeLocationEditForm
     * @return RedirectResponse|array<string,mixed>
     */
    protected function updateAntelopeLocation(
        FormInterface $antelopeLocationEditForm
    ): RedirectResponse|array {
        $antelopeLocationTransfer = $antelopeLocationEditForm->getData();

        if (
            $this->isLocationNameTaken(
                $antelopeLocationTransfer->getLocationNameOrFail(),
                $antelopeLocationTransfer->getIdLocationOrFail()
            )
        ) {
            $antelopeLocationEditForm
                ->get(AntelopeLocationCreateForm::FIELD_LOCATION_NAME)
                ->addError(new FormError(static::MESSAGE_ANTELOPE_LOCATION_NAME_EXISTS));

            return $this->viewResponse([
                'antelopeLocationEditForm' => $antelopeLocationEditForm->createView(),
                'backUrl' => $this->getAntelopeLocationListUrl(),
            ]);
        }

        $antelopeLocationResponseTransfer = $this->getFactory()
            ->getAntelopeFacade()
            ->updateAntelopeLocation($antelopeLocationTransfer);
        if (!$antelopeLocationResponseTransfer->getIsSuccessFul()) {
            return $this->redirectToListWithError();
        }

        $this->addSuccessMessage(static::MESSAGE_ANTELOPE_LOCATION_UPDATED_SUCCESS);

        return $this->redirectResponse($this->getAntelopeLocationListUrl());
    }

    protected function redirectToListWithError(): RedirectResponse
    {
        $this->addErrorMessage(static::MESSAGE_ANTELOPE_LOCATION_NOT_FOUND);

        return $this->redirectResponse($this->getAntelopeLocationListUrl());
    }

    /**
     * @param string $locationName
     * @param int|null $excludedIdLocation
     *
     * @return bool
     */
    protected function isLocationNameTaken(string $locationName, ?int $excludedIdLocation = null): bool
    {
        $antelopeLocationCriteriaTransfer = (new AntelopeLocationCriteriaTransfer())
            ->setLocationName($locationName);

        $antelopeLocationResponseTransfer = $this->getFactory()
            ->getAntelopeFacade()
            ->getAntelopeLocation($antelopeLocationCriteriaTransfer);

        if (!$antelopeLocationResponseTransfer->getIsSuccessFul()) {
            return false;
        }

        return $antelopeLocationResponseTransfer->getAntelopeLocationOrFail()->getIdLocation() !== $excludedIdLocation;
    }

    protected function getAntelopeLocationListUrl(): string
    {
        return (string) Url::generate(AntelopeLocationGuiConfig::URL_ANTELOPE_LOCATION_LIST);
    }

    protected function getAntelopeLocationCreateUrl(): string
    {
        return (string) Url::generate(AntelopeLocationGuiConfig::URL_ANTELOPE_LOCATION_CREATE);
    }
}
