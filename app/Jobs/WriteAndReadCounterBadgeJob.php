<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Cache;
use Closure;

class WriteAndReadCounterBadgeJob
{
    public $keys = [];


    public function __construct(
        public ?string $key = null, 
        public ?string $type = null, 
        public ?Closure $function = null,
        public ?int $amount = null,
    ){
        $this->handle();
    }

    public function handle()
    {
        if ($this->key != null && $this->type != null && $this->function != null && $this->function instanceof Closure) {
            if (Cache::has($this->key)) {
                if ($this->type == 'increment') $this->increment();
                if ($this->type == 'decrement') $this->decrement();
            } else {
                $this->write($this->key, $this->function);
            }
        }
    }

    public static function getInstance()
    {
        return new self();
    }

    /** 
     * If there is no cache, it will write and retrieve the value.
     * @param ?string $key
     * @param ?string $type - increment or decrement
     * @param Closure $function
    */
    public function writeAndReadCache(string $key, Closure $function)
    {
        $this->keys[] = $key;
        if (Cache::has($key)) {
            $this->{$key} = Cache::get($key);
        } else {
            $this->{$key} = Cache::rememberForever($key, $function);
        }
        return $this;
    }

    public function write($key, Closure $function)
    {
        $this->keys[] = $key;
        $result = $function();
        Cache::put($key, $result);

        $this->{$key} = Cache::get($key);
        return $this;
    }

    private function increment()
    {
        $this->keys[] = $this->key;
        if ($this->amount) Cache::increment($this->key, $this->amount);
        else Cache::increment($this->key);
        $this->{$this->key} = Cache::get($this->key);
        return $this;
    }

    private function decrement()
    {
        $this->keys[] = $this->key;
        if ($this->amount) Cache::decrement($this->key, $this->amount);
        else Cache::decrement($this->key);
        $this->{$this->key} = Cache::get($this->key);
        return $this;
    }

    public function get()
    {
        $result = new \stdClass();
        foreach ($this->keys as $key) {
            $result->{$key} = $this->{$key};
        }
        return $result;
    }
}