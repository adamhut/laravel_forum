<?php

namespace App;

use Illuminate\Support\Facades\Redis;

trait RecordVisits
{
    public function resetVisit()
    {
        Redis::del($this->visitsCacheKey());

        return $this;
    }

    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?: 0;
    }

    public function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}
