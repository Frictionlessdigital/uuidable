<?php

namespace Fls\Uuidable\Tests\Models;

use Fls\Uuidable\Uuidable;
use Illuminate\Database\Eloquent\Model;

class AlternativeDummyModel extends Model
{
    use Uuidable;

    /**
     * Name of the field to to store the UUID.
     *
     * @var string
     */
    public const UUID = 'diuu';
}
