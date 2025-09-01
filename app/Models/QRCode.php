<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRCode extends Model
{
    protected $fillable = ['item_id', 'code', 'image_path', 'active'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
