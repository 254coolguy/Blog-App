<?php

namespace App\View\Components;

use Closure;
use App\Models\Category;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class AppLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?string $metaTitle = null, public ?string $metaDescription = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        //selecting head bar categories
        $categories= Category::query()
        ->leftJoin('category_post', 'categories.id', '=', 'category_post.category_id')
        ->select('categories.title', 'categories.slug',   DB::raw('count(*) as total'))
        ->groupBy('categories.id')
        ->orderByDesc('total')
        ->get();
        return view('components.app-layout', compact('categories'));
    }
}
