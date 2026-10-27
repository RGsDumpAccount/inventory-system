<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; 

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'image', 'units_per_pack', 'stock',
        'cost_price', 'price_per_pack', 'price_per_stick', 'reorder_level',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    public function getPacksAttribute(): int
    {
        return intdiv($this->stock, max(1, $this->units_per_pack));
    }

    public function getLooseAttribute(): int
    {
        return $this->stock % max(1, $this->units_per_pack);
    }

    // "5 packs + 3 sticks", or "48 pcs" for single items
    public function getStockLabelAttribute(): string
    {
        if ($this->units_per_pack <= 1) {
            return $this->stock . ' pcs';
        }
        $label = $this->packs . ' packs';
        return $this->loose ? $label . ' + ' . $this->loose . ' sticks' : $label;
    }

    public function getIsLowAttribute(): bool
    {
        return $this->packs <= $this->reorder_level;
    }

    // Expected sales if everything is sold
    public function getExpectedByPackAttribute(): float
    {
        return ($this->stock / max(1, $this->units_per_pack)) * (float) $this->price_per_pack;
    }

    public function getExpectedByStickAttribute(): ?float
    {
        return $this->price_per_stick ? $this->stock * (float) $this->price_per_stick : null;
    }
}
