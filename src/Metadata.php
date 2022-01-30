<?php

namespace PaulMorel\Metascraper;


class Metadata
{

    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function data(): array
    {
        if (is_array($this->data) === true) {
            return $this->data;
        }

        return $this->data = [];
    }

    public function get($key, $default = null)
    {
        if (is_array($key) === true) {
            $result = [];
            foreach ($key as $k) {
                $result[$k] = $this->get($k);
            }
            return $result;
        }

        return $this->data()[$key] ?? $default;
    }

    public function toArray(): array
    {
        return $this->data();
    }

    public function toJson(): string
    {
        return json_encode($this->data());
    }

    public function toString(): string
    {
        return http_build_query($this->data());
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
