<?php

declare(strict_types=1);

namespace Pyz\Zed\AntelopeGui\Communication;

use Generated\Shared\Transfer\AntelopeTransfer;
use Orm\Zed\Antelope\Persistence\PyzAntelopeLocationQuery;
use Orm\Zed\Antelope\Persistence\PyzAntelopeQuery;
use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;
use Pyz\Zed\AntelopeGui\AntelopeGuiConfig;
use Pyz\Zed\AntelopeGui\AntelopeGuiDependencyProvider;
use Pyz\Zed\AntelopeGui\Communication\Form\AntelopeCreateForm;
use Pyz\Zed\AntelopeGui\Communication\Form\DataProvider\AntelopeCreateFormDataProvider;
use Pyz\Zed\AntelopeGui\Communication\Table\AntelopeTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException;
use Symfony\Component\Form\FormInterface;

/**
 * @method AntelopeGuiConfig getConfig()
 */
class AntelopeGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @throws ContainerKeyNotFoundException
     */
    public function createAntelopeTable(): AntelopeTable
    {
        return new AntelopeTable(
            $this->getAntelopePropelQuery()
        );
    }

    /**
     * @throws ContainerKeyNotFoundException
     */
    public function getAntelopePropelQuery(): PyzAntelopeQuery
    {
        return $this->getProvidedDependency(AntelopeGuiDependencyProvider::PROPEL_QUERY_ANTELOPE);
    }

    /**
     * @throws ContainerKeyNotFoundException
     */
    public function getAntelopeLocationPropelQuery(): PyzAntelopeLocationQuery
    {
        return $this->getProvidedDependency(AntelopeGuiDependencyProvider::PROPEL_QUERY_ANTELOPE_LOCATION);
    }

    /**
     * @param AntelopeTransfer $antelopeTransfer
     * @param array $options <string,mixed>
     * @return FormInterface
     */
    public function createAntelopeCreateForm(
        AntelopeTransfer $antelopeTransfer,
        array $options = []
    ): FormInterface {
        return $this->getFormFactory()->create(
            AntelopeCreateForm::class,
            $antelopeTransfer,
            array_merge($this->createAntelopeCreateFormDataProvider()->getOptions(), $options)
        );
    }

    /**
     * @throws ContainerKeyNotFoundException
     */
    public function createAntelopeCreateFormDataProvider(): AntelopeCreateFormDataProvider
    {
        return new AntelopeCreateFormDataProvider(
            $this->getAntelopeLocationPropelQuery()
        );
    }

    /**
     * @throws ContainerKeyNotFoundException
     */
    public function getAntelopeFacade(): AntelopeFacadeInterface
    {
        return $this->getProvidedDependency(AntelopeGuiDependencyProvider::FACADE_ANTELOPE);
    }
}
