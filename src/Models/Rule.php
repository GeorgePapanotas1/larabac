<?php

namespace Gpapanotas\Larabac\Models;


class Rule
{
    public function __construct(
        public string $id,
        public string $action,
        public array $conditions
    )
    {
    }

    /**
     * Create a Rule instance from an array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['action'],
            $data['conditions']
        );
    }

    /**
     * Convert the Rule instance to an array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'action' => $this->action,
            'conditions' => $this->conditions,
        ];
    }

    /**
     * Validate the rule's structure.
     */
    public function isValid(): bool
    {
        return isset($this->id, $this->action, $this->conditions) && is_array($this->conditions);
    }
}
