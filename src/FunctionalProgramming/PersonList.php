<?php
namespace SnowIO\Demo\FunctionalProgramming;

use IteratorAggregate;

class PersonList implements IteratorAggregate
{
    public static function of(array $people)
    {
        return new self($people);
    }

    public static function create()
    {
        return new self([]);
    }

    public function with(Person $person)
    {
        $result = clone $this;
        $result->items[$person->getId()] = $person;
        return $result;
    }

    private function __construct(array $people)
    {
        /** @var Person $person */
        foreach ($people as $person) {
            $this->items[$person->getId()] = $person;
        }
    }

    public function get(string $id)
    {
        return $this->items[$id] ?? null;
    }

    public function map(callable $function): array
    {
        return array_map($function, $this->items);
    }

    public function toJson()
    {
        return array_map(function (Person $person) {
            return $person->toJson();
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