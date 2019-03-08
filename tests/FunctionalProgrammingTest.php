<?php
namespace SnowIO\Demo\Test;

use PHPUnit\Framework\TestCase;
use function SnowIO\Demo\FunctionalProgramming\getAllDistinctSkills;
use function SnowIO\Demo\FunctionalProgramming\getNamesFunctional;
use function SnowIO\Demo\FunctionalProgramming\getNamesOO;
use SnowIO\Demo\FunctionalProgramming\Person;
use SnowIO\Demo\FunctionalProgramming\PersonList;
use SnowIO\Demo\FunctionalProgramming\Skill;
use SnowIO\Demo\FunctionalProgramming\SkillList;

class FunctionalProgrammingTest extends TestCase
{
    /**
     * @test
     */
    public function basicDemo()
    {
        $people = PersonList::of([
            Person::of('ti_j23423r4','Steven'),
            Person::of('uc_4t2r424r','Kevin'),
            Person::of('mo_23r23r42','Jackson'),
        ]);
        self::assertEquals(getNamesOO($people), getNamesFunctional($people));
    }

    /**
     * @test
     * @dataProvider personListProvider
     * @param PersonList $personList
     * @param SkillList $expected
     */
    public function getAllDistinctSkills(PersonList $personList, SkillList $expected)
    {
        $actual = getAllDistinctSkills($personList);
        self::assertEquals($expected->toJson(), $actual->toJson());
    }

    public function personListProvider()
    {
        return [
            [
                PersonList::of([
                    Person::of('tu_0001','Steven')
                        ->withSkill(Skill::of('mi_01','PHP Programming'))
                        ->withSkill(Skill::of('di_01','DDD'))
                        ->withSkill(Skill::of('hc_02','Haskell Coding'))
                    ,
                    Person::of('tu_0002','Kevin')
                        ->withSkill(Skill::of('sa_01', 'System Architectures'))
                        ->withSkill(Skill::of('mi_01','PHP Programming'))
                        ->withSkill(Skill::of('di_01','DDD'))
                        ->withSkill(Skill::of('hc_02','Haskell Coding'))
                    ,
                    Person::of('tu_0003','Jackson')
                        ->withSkill(Skill::of('sa_01', 'System Architectures'))
                        ->withSkill(Skill::of('di_01','DDD'))
                        ->withSkill(Skill::of('hc_02','Haskell Coding')),
                ]),
                SkillList::of([
                    Skill::of('mi_01','PHP Programming'),
                    Skill::of('di_01','DDD'),
                    Skill::of('hc_02','Haskell Coding'),
                    Skill::of('sa_01', 'System Architectures')
                ])
            ]
        ];
    }


}