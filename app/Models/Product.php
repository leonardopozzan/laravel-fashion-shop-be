<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function brand():BelongsTo{
        return $this->belongsTo(Brand::class);
    }
    public function type():BelongsTo{
        return $this->belongsTo(Type::class);
    }
    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function tags():BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }

    public function orders() :BelongsToMany{
        return $this->belongsToMany(Order::class);
    }
}
