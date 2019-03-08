<?php
namespace SnowIO\Demo\FunctionalProgramming;

class Skill
{
    private function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public static function of(string $id, string $title)
    {
        return new self($id, $title);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getExp()
    {
        return $this->exp;
    }

    public function getId(): string
    {
        return $this->id;
    }

    private $title;
    private $exp;
    private $id;

    public function toJson()
    {
        return [
            'title' => $this->title,
            'id' => $this->id
        ];
    }
}