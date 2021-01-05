<?php

namespace App\Utils;

class HashMap {
    private $map = array();
    private $comparer;

    public function __construct(IEqualityComparer $keyComparer) {
        $this->comparer = $keyComparer;
    }

    public function has($key) {
        $hash = $this->comparer->getHashCode($key);

        if (!isset($this->map[$hash])) {
            return false;
        }

        foreach ($this->map[$hash] as $item) {
            if ($this->comparer->equals($item['key'], $key)) {
                return true;
            }
        }

        return false;
    }

    public function get($key) {
        $hash = $this->comparer->getHashCode($key);

        if (!isset($this->map[$hash])) {
            return false;
        }

        foreach ($this->map[$hash] as $item) {
            if ($this->comparer->equals($item['key'], $key)) {
                return $item['value'];
            }
        }

        return false;
    }

    public function del($key) {
        $hash = $this->comparer->getHashCode($key);

        if (!isset($this->map[$hash])) {
            return false;
        }

        foreach ($this->map[$hash] as $index => $item) {
            if ($this->comparer->equals($item['key'], $key)) {
                unset($this->map[$hash][$index]);
                if (count($this->map[$hash]) == 0)
                    unset($this->map[$hash]);

                return true;
            }
        }

        return false;
    }

    public function put($key, $value) {
        $hash = $this->comparer->getHashCode($key);

        if (!isset($this->map[$hash])) {
            $this->map[$hash] = array();
        }

        $newItem = array('key' => $key, 'value' => $value);

        foreach ($this->map[$hash] as $index => $item) {
            if ($this->comparer->equals($item['key'], $key)) {
                $this->map[$hash][$index] = $newItem;
                return;
            }
        }

        $this->map[$hash][] = $newItem;
    }
}
