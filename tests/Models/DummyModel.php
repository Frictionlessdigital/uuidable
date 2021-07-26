<?php

namespace Fls\Uuidable\Tests\Models;

use Fls\Uuidable\Uuidable;
use Illuminate\Database\Eloquent\Model;

class DummyModel extends Model
{
    use Uuidable;
}
