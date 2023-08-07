<?php

namespace App\Filament\Widgets;

use App\Models\postview;
use App\Models\UpvoteDownvote;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class PostOverview extends Widget
{
    protected int | string | array $columnSpan = 3;
    //defining record
    public ?Model $record=null;

    protected function getViewData(): array
    {
        $viewCount = 0;
        $upvotes = 0;
        $downvotes = 0;
        if ($this->record) {
            // Get view count
            $viewCount = postview::where('post_id', '=', $this->record->id)->count();
    
            // Get upvotes count
            $upvotes = UpvoteDownvote::where('post_id', '=', $this->record->id)
                ->where('is_upvote', '=', 1)
                ->count();
    
            // Get downvotes count
            $downvotes = UpvoteDownvote::where('post_id', '=', $this->record->id)
                ->where('is_upvote', '=', 0)
                ->count();
        }
    
        return [
            'viewCount' => $viewCount,
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
        ];
    }

    
    protected static string $view = 'filament.widgets.post-overview';
}
