<?php

namespace App\Utils\Notification;

/**
 * Class AbstractNotifications
 * @package App\Utils\Notification
 * All clases that extends this class must have a __invoke method
 * Methods
 * @method void success($message, $duration = 5000, $options = null)
 * @method void warning($message, $duration = 5000, $options = null)
 * @method void danger($message, $duration = 5000, $options = null)
 * @method void info($message, $duration = 5000, $options = null)
 */
class AbstractNotifications
{
    protected $methods = ['success', 'warning', 'danger', 'info'];

    public function __call($name, $arguments)
    {
        $type = in_array($name, $this->methods) ? $name : 'success';

        return $this($type, $arguments);
    }

    public function __invoke($type, $arguments)
    {
        throw new \Exception('You must implement __invoke method');
    }
}
