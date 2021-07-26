<?php

namespace Fls\Uuidable\Tests;

use Fls\Uuidable\Tests\Models\AlternativeDummyModel as DummyModel;

class AlternativeFieldUuidableTest extends TestCase
{
    /** @test */
    public function it_will_add_uuid_to_new_model()
    {
        $model = DummyModel::create([]);

        $this->assertNotNull($model->getAttribute($model->getUuidColumn()));
        $this->assertIsString($model->getAttribute($model->getUuidColumn()));
    }

    /** @test */
    public function it_will_find_a_model_by_uuid()
    {
        $model = DummyModel::create([]);
        $uuid = $model->getAttribute($model->getUuidColumn());

        $found = DummyModel::findByUuid($uuid);

        $this->assertTrue($model->is($found));
        $this->assertEquals($uuid, $found->getAttribute($model->getUuidColumn()));
    }

    /** @test */
    public function it_will_find_models_by_uuids()
    {
        $modelA = DummyModel::create([]);
        $modelB = DummyModel::create([]);
        $modelC = DummyModel::create([]);

        $value = $modelA->getAttribute($modelA->getUuidColumn());

        $array = [
            $modelA->getAttribute($modelA->getUuidColumn()),
            $modelB->getAttribute($modelB->getUuidColumn()),
        ];

        $arrayable = DummyModel::whereUuid($array)->pluck($modelA->getUuidColumn());

        $foundA = DummyModel::whereUuid($value)->get();
        $foundB = DummyModel::whereUuid($array)->get();
        $foundC = DummyModel::whereUuid($arrayable)->get();

        $this->assertCount(1, $foundA);
        $this->assertCount(2, $foundB);
        $this->assertCount(2, $foundC);
        $this->assertTrue($foundA->contains($modelA));
        $this->assertTrue($foundB->contains($modelA));
        $this->assertTrue($foundB->contains($modelB));
        $this->assertFalse($foundB->contains($modelC));
        $this->assertTrue($foundC->contains($modelA));
        $this->assertTrue($foundC->contains($modelB));
        $this->assertFalse($foundC->contains($modelC));
    }
}
