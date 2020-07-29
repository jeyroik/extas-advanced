<?php
namespace extas\interfaces\stages;

/**
 * Interface IStageBeforeBuild
 *
 * @package extas\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageBeforeBuild
{
    public const NAME = 'extas.before.build.';
    public const NAME__ALL = self::NAME . '@classes';

    /**
     * Should return parameters.
     *
     * @param array $parameters
     * @return array
     */
    public function __invoke(array $parameters): array;
}
