<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi;

use Pyz\Glue\AntelopeLocationBackendApi\Processor\Creator\AntelopeLocationCreator;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Creator\AntelopeLocationCreatorInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Deleter\AntelopeLocationDeleter;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Deleter\AntelopeLocationDeleterInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper\AntelopeLocationMapper;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper\AntelopeLocationMapperInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Reader\AntelopeLocationReader;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Reader\AntelopeLocationReaderInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder\AntelopeLocationResponseBuilder;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder\AntelopeLocationResponseBuilderInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Updater\AntelopeLocationUpdater;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Updater\AntelopeLocationUpdaterInterface;
use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;
use Spryker\Glue\Kernel\Backend\AbstractFactory;

class AntelopeLocationBackendApiFactory extends AbstractFactory
{
    public function createAntelopeLocationReader(): AntelopeLocationReaderInterface
    {
        return new AntelopeLocationReader(
            $this->getAntelopeFacade(),
            $this->createAntelopeLocationResponseBuilder(),
        );
    }

    public function createAntelopeLocationCreator(): AntelopeLocationCreatorInterface
    {
        return new AntelopeLocationCreator(
            $this->getAntelopeFacade(),
            $this->createAntelopeLocationResponseBuilder(),
            $this->createAntelopeLocationMapper(),
        );
    }

    public function createAntelopeLocationUpdater(): AntelopeLocationUpdaterInterface
    {
        return new AntelopeLocationUpdater(
            $this->getAntelopeFacade(),
            $this->createAntelopeLocationResponseBuilder(),
            $this->createAntelopeLocationMapper(),
        );
    }

    public function createAntelopeLocationDeleter(): AntelopeLocationDeleterInterface
    {
        return new AntelopeLocationDeleter(
            $this->getAntelopeFacade(),
            $this->createAntelopeLocationResponseBuilder(),
        );
    }

    public function createAntelopeLocationResponseBuilder(): AntelopeLocationResponseBuilderInterface
    {
        return new AntelopeLocationResponseBuilder($this->createAntelopeLocationMapper());
    }

    public function createAntelopeLocationMapper(): AntelopeLocationMapperInterface
    {
        return new AntelopeLocationMapper();
    }

    public function getAntelopeFacade(): AntelopeFacadeInterface
    {
        return $this->getProvidedDependency(AntelopeLocationBackendApiDependencyProvider::FACADE_ANTELOPE);
    }
}
