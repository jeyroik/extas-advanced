<?php
namespace extas\interfaces\stages;

/**
 * Interface IStageBeforeRun
 *
 * @package extas\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageBeforeRun
{
    public const NAME = 'extas.before.run.';
    public const NAME__ALL = '.@methods';

    /**
     * Should return method arguments.
     *
     * @param $object
     * @param mixed ...$methodArgs
     * @return array
     */
    public function __invoke($object, ...$methodArgs): array;
}
