<?php

/**
 * @param  string  $className
 *
 * @return mixed
 */
function new_(string $className) {
    return app()->make($className);
}
