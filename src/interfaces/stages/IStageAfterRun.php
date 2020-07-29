<?php
namespace extas\interfaces\stages;

/**
 * Interface IStageAfterRun
 *
 * @package extas\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageAfterRun
{
    public const NAME = 'extas.after.run.';
    public const NAME__ALL = '.@methods';

    /**
     * Should return result.
     *
     * @param $result
     * @param $object
     * @param mixed ...$methodArgs
     * @return mixed
     */
    public function __invoke($result, $object, ...$methodArgs);
}
