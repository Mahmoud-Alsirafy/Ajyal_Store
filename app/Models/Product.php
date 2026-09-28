<?php

namespace App\Models;

use App\Models\Categorie;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    protected $hidden = ['updated_at', 'created_at', 'deleted_at', 'image'];
    protected $appends = ['image_url'];

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }

    protected static function booted()
    {
        // the scope is class to call
        static::addGlobalScope(\App\Models\Scopes\storeScope::class);

        static::creating(fn(Product $product) => $product->slug = Str::slug($product->name));



        //    !!the scope in the model is here
        //    static::addGlobalScope('store',function (Builder $builder) {
        //     $user = Auth::user();
        //    if($user->store_id){
        //      $builder->where('store_id',$user->store_id);
        //    }
        //    });
    }

    // function store(){
    //     return $this->belongsTo(Store::class);
    // }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id', 'id', 'id');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return '';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSlaePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return round(100 - (100 * $this->price / $this->compare_price), 1);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if (is_numeric($value)) {
            return $this->where('id', $value)->first();
        }
        return $this->where($field ?? $this->getRouteKeyName(), $value)->first();
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], fn($query, $status) => $query->where('status', $status));

        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function ($builder, $value) {
            $builder->WhereExists(function ($query) use ($value) {
                $query->select(1)->from('product_tag')->whereRaw('product_id = products.id')
                    ->where('tag_id', $value);
            });
        });
    }
}