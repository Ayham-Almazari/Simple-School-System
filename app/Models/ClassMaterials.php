<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassMaterials extends Model
{
    use HasFactory;

    protected $guarded=[ ];
    protected $dateFormat="Y-m-d H:i:s";

    public function To_class(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, "classroom_id");
    }
}
