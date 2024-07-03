<?php

namespace App\Models;

use App\Traits\HasUuid;
use Laravel\Jetstream\Membership as JetstreamMembership;

class Membership extends JetstreamMembership
{
    use HasUuid;
}
