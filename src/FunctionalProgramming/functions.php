<?php
namespace SnowIO\Demo\FunctionalProgramming;

use Joshdifabio\Transform\Distinct;
use Joshdifabio\Transform\FlatMapElements;
use Joshdifabio\Transform\Pipeline;

function getNamesOO(PersonList $people)
{
    $names = [];
    /** @var Person $person */
    foreach ($people as $person) {
        $names[$person->getId()] = $person->getName();
    }
    return $names;
}

function getNamesFunctional(PersonList $people)
{
    return $people->map(function (Person $person) {
        return $person->getName();
    });
}

function getAllDistinctSkills(PersonList $people) : SkillList
{
    return SkillList::fromIterator(Pipeline::of(
        FlatMapElements::via(function (Person $person) {
            return $person->getSkills();
        }),
        Distinct::withRepresentativeValueFn(function (Skill $skill) {
            return $skill->getId();
        })
    )->applyTo($people));
}