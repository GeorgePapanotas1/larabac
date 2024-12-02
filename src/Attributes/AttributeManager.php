<?php

namespace Gpapanotas\Larabac\Attributes;

class AttributeManager
{
    protected array $handlers = [];

    public function registerHandler(string $type, $handler): void
    {
        $this->handlers[$type] = $handler;
    }

    public function getAttributes($user, $resource, array $context = []): array
    {
        $attributes = [];

        // Fetch user attributes
        if ($user && isset($this->handlers[get_class($user)])) {
            $userHandler = $this->handlers[get_class($user)];
            $attributes = array_merge($attributes, $userHandler->fetchAttributes($user, $resource, $context));
        }

        // Fetch resource attributes
        $type = is_object($resource) ? get_class($resource) : 'default';
        if ($resource && isset($this->handlers[$type])) {
            $resourceHandler = $this->handlers[$type];
            $attributes = array_merge($attributes, $resourceHandler->fetchAttributes($user, $resource, $context));
        }

        return $attributes;
    }
}