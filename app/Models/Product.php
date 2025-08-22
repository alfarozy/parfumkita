<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'price',
        'stock',
        'fragrance_family',
        'volume_ml',
        'gender_target',
        'usage_time',
        'situation',
        'longevity',
        'image',
        'enabled',
    ];

    /*
     * Relasi ke kategori parfum
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
     * Getter untuk thumbnail
     */
    public function getThumbnail()
    {
        return asset('storage/' . $this->image);
    }

    /*
     * Scope untuk filter rekomendasi parfum
     */
    public function scopeRecommended($query, $answers)
    {
        return $query
            ->when(isset($answers['gender_target']), fn($q) =>
            $q->where('gender_target', $answers['gender_target']))
            ->when(isset($answers['usage_time']), fn($q) =>
            $q->where('usage_time', $answers['usage_time']))
            ->when(isset($answers['situation']), fn($q) =>
            $q->where('situation', $answers['situation']))
            ->when(isset($answers['longevity']), fn($q) =>
            $q->where('longevity', $answers['longevity']));
    }
}
