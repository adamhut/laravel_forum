<?php

namespace App;

trait RecordActivity
{
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected static function bootRecordActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type'  => $this->getActivityType($event),
        ]);
        //
        //Activity::create([
        //    'user_id' => auth()->id(),
        //    'type'  => $this->getActivityType($event),
        //    'subject_id' => $this->id,
        //    'subject_type' => get_class($this),
        //]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    public function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName()); // App/Thread =>Thread
        return $event.'_'.$type;
    }
}
