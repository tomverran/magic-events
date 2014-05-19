<?php
namespace tomverran\MagicEvent;
use InvalidArgumentException;
use LogicException;
use ReflectionFunction;

/**
 * Created by JetBrains PhpStorm.
 * User: tom
 * Date: 19/05/14
 * Time: 23:31
 * To change this template use File | Settings | File Templates.
 */

class Dispatcher
{
    private $byClassName = [];

    /**
     * @param callable $response
     * @throws LogicException
     */
    public function on(callable $response)
    {
        $rf = new ReflectionFunction($response);
        if ($rf->getNumberOfParameters() != 1) {
            throw new InvalidArgumentException('Closure should have exactly one param');
        }

        if (!$class = $rf->getParameters()[0]->getClass()) {
            throw new InvalidArgumentException('Argument must be type hinted');
        }

        if (!isset($this->byClassName[$class->getName()])) {
            $this->byClassName[$class->getName()] = [];
        }
        $this->byClassName[$class->getName()][] = $response;
    }

    /**
     * Fire an event given any old object
     * @param object $thing Some kind of object
     * @throws \InvalidArgumentException
     */
    public function fire($thing)
    {
        if (!is_object($thing)) {
            throw new InvalidArgumentException( 'this must be an object' );
        }

        $class = get_class($thing);
        if (isset($this->byClassName[$class])) {
            foreach ($this->byClassName[$class] as $callable) {
                $callable($thing);
            }
        }
    }
}