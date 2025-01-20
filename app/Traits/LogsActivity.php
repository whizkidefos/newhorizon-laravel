<?php

namespace App\Traits;

use App\Models\Activity;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function($model) {
            $model->logActivity('created');
        });

        static::updated(function($model) {
            $model->logActivity('updated');
        });

        static::deleted(function($model) {
            $model->logActivity('deleted');
        });
    }

    public function logActivity($action)
    {
        Activity::create([
            'log_name' => strtolower(class_basename($this)),
            'description' => "{$action} " . strtolower(class_basename($this)),
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'causer_type' => auth()->user() ? get_class(auth()->user()) : null,
            'causer_id' => auth()->id(),
            'properties' => [
                'old' => $action === 'updated' ? $this->getOriginal() : null,
                'attributes' => $this->getAttributes(),
            ]
        ]);
    }
}