<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi;

use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;
use Spryker\Glue\Kernel\Backend\AbstractFactory;

class AntelopeLocationBackendApiFactory extends AbstractFactory
{
    public function getAntelopeFacade(): AntelopeFacadeInterface
    {
        return $this->getProvidedDependency(AntelopeLocationBackendApiDependencyProvider::FACADE_ANTELOPE);
    }
}
