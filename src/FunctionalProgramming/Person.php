<?php
namespace SnowIO\Demo\FunctionalProgramming;

class Person {
    public static function of(string $id, string $name)
    {
        return new self($id, $name);
    }

    private  function __construct(string $id, string $name)
    {
        $this->name = $name;
        $this->id = $id;
        $this->skills = SkillList::create();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSkills(): SkillList
    {
        return $this->skills;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function withSkill(Skill $skill)
    {
        $result = clone $this;
        $result->skills = $this->skills->with($skill);
        return $result;
    }


    public function toJson(): array
    {
        return [
            'skills' => $this->skills->toJson(),
            'name' => $this->name,
            'id' => $this->id,
        ];
    }

    private $skills;
    private $name;
    private $id;

}
