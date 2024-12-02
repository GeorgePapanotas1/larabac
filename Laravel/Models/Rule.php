<?php

namespace Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{

    /**
     * The table associated with the model.
     */
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('permissioning.database.table', 'rules');
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'action',
        'conditions',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'conditions' => 'array',
    ];

    /**
     * Find rules by action.
     */
    public static function findByAction(string $action)
    {
        return static::where('action', $action)->get();
    }
}