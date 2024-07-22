<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function scopeFilter(EloquentBuilder $builder, $filters)
    {
        $title = $filters['title'] ?? null;
        if ($title) {
            $builder->where('title', 'LIKE', "%$title%");
        }
    }
}
