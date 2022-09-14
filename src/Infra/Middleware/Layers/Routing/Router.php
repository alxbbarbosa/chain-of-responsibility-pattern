<?php

namespace Infra\Middleware\Layers\Routing;

class Router
{
    private array $collection = [];
    private ?array $segments = [];

    public function get(string $pattern, string|callable $callback): self
    {
        $this->collection['GET'][$pattern] = $callback;
        return $this;
    }

    public function post(string $pattern, string|callable $callback): self
    {
        $this->collection['POST'][$pattern] = $callback;
        return $this;
    }

    public function put(string $pattern, string|callable $callback): self
    {
        $this->collection['PUT'][$pattern] = $callback;
        return $this;
    }

    public function delete(string $pattern, string|callable $callback): self
    {
        $this->collection['DELETE'][$pattern] = $callback;
        return $this;
    }

    public function getSegments(): ?array
    {
        return $this->segments;
    }

    public function getRouteBy(string $method, string $pattern): string|callable
    {
        $selectedCollection = $this->collection[$method] ?? [];
        foreach ($selectedCollection as $patternStored => $element) {
            if (preg_match("#^$patternStored$#", $pattern, $matches)) {
                $this->extractSegments($pattern);
                return $element;
            }
        }

        return '';
    }
    protected function extractSegments(string $pattern): void
    {
        $this->segments = [];
        $extractedSegments = explode('/', $pattern);
        $sequence = 1;
        foreach ($extractedSegments as $segment) {
            if (!$segment) {
                continue;
            }
            $this->segments['segment' . $sequence++] = $segment;
        }
    }
}