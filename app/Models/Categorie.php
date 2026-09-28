<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorie extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];


    public function Products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }


    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'parent_id', "id")->withDefault([
            'name' => '-',
        ]);
    }

    public function childern()
    {
        return $this->hasMany(Categorie::class, 'parent_id', "id");
    }

    public function scopeFilter(Builder $builder, $filter)
    {
        $builder->when($filter['name'] ?? false, function ($builder, $value) {
            $builder->where('name', 'LIKE', "%{$value}%");
        });
        // if($filter['name']??false){
        // }
        $builder->when($filter['status'] ?? false, function ($builder, $value) {
            $builder->whereStatus($value);
        });
    }
}
