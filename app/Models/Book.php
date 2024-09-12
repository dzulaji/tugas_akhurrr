<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'code', 'cover', 'author', 'publisher', 'description', 'category_id', 'stock',
        'call_number', 'pages', 'language', 'isbn_issn', 'content_type',
        'media_type', 'carrier_type', 'edition', 'subject', 'specific_detail_info'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
