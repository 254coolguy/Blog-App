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
        if ($this->record) {
            $viewCount = postview::where('post_id', '=', $this->record->id)->count();
        }

        return [
            'viewCount' => $viewCount,

            // 'upvotes' =>UpvoteDownvote::where('post_id', '=',$this->record->id)
            // ->where('upvote', '=',1)
            // ->count(),

            // 'downvotes' =>UpvoteDownvote::where('post_id', '=',$this->record->id)
            // ->where('upvote', '=', 0)
            // ->count(),
        ];
    }

    
    protected static string $view = 'filament.widgets.post-overview';
}
