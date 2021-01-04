<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id')->where('status', 1);
    }

    public function section()
    {
        return $this->belongsTo('App\Section', 'section_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id')->where('status', 1);
    }

    public function attributes()
    {
        return $this->hasMany('App\ProductsAttribute')->where('status', 1);
    }

    public function images()
    {
        return $this->hasMany('App\productsImage')->where('status', 1);
    }
}
