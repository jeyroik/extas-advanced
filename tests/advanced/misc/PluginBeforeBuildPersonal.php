<?php
namespace tests\advanced\misc;

use extas\components\plugins\Plugin;
use extas\interfaces\stages\IStageBeforeBuild;

/**
 * Class PluginBeforeBuildPersonal
 *
 * @package tests\advanced\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginBeforeBuildPersonal extends Plugin implements IStageBeforeBuild
{
    /**
     * @param array $parameters
     * @return array
     */
    public function __invoke(array $parameters): array
    {
        $parameters['test'] = $parameters['test'] . '.before(personal)';

        return $parameters;
    }
}
