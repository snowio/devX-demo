<?php
namespace SnowIO\Demo\FunctionalProgramming;

use IteratorAggregate;

class SkillList implements IteratorAggregate
{
    public static function create()
    {
        return new self([]);
    }

    private function __construct(array $skills)
    {
        /** @var Skill $skill */
        foreach ($skills as $skill) {
            $this->items[$skill->getId()] = $skill;
        }
    }

    public static function of(array $skills)
    {
        return new self($skills);
    }

    public static function fromIterator(\Iterator $skills)
    {
        return new self(iterator_to_array($skills));
    }

    public function with(Skill $skill)
    {
        $result = clone $this;
        $result->items[$skill->getId()] = $skill;
        return $result;
    }

    public function get(string $id): ?Skill
    {
        return $result->items[$id] ?? null;
    }

    public function map(callable $function): array
    {
        return array_map($function, $this->items);
    }

    public function toJson()
    {
        return array_map(function (Skill $skill) {
            return $skill->toJson();
        }, $this->items);
    }

    private $items;

    public function getIterator()
    {
        foreach ($this->items as $item) {
            yield $item;
        }
    }
}