<?php

namespace App\View\Components;


use Closure;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function __construct(public ?string $metaTitle = null, public ?string $metaDescription = null)
    {
        //
    }
    
    public function render(): View
    {
         //selecting head bar categories
         $categories= Category::query()
         ->leftJoin('category_post', 'categories.id', '=', 'category_post.category_id')
         ->select('categories.title', 'categories.slug',   DB::raw('count(*) as total'))
         ->groupBy('categories.id')
         ->orderByDesc('total')
         ->get();
         return view('layouts.app-layout', compact('categories'));
    }
}
