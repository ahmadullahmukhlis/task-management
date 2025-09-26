<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->comment,
            'initials'=>$this->charecktor($this->name),
            'color'=>'bg-'.$this->color($this->id),
            'tasks'=>25 + $this->id,
            'progress'=>$this->id + 41,
            'progressColor'=>$this->color($this->id),
            'icon'=>$this->icon($this->id),
            'members'=>[
                [
                    'initials'=>'AJ',
                    'color'=> $this->color()
                ],        [
                    'initials'=>'AJ',
                    'color'=> $this->color()
                ]    ,    [
                    'initials'=>'AJ',
                    'color'=> $this->color()
                ]   ,     [
                    'initials'=>'AJ',
                    'color'=> $this->color()
                ]
                ],
                'created_by'=> $this->created_by == auth()->user()->id ? true : false

        ];
    }
private function charecktor(string $name): string
{
    $parts = array_values(array_filter(explode(' ', trim($name))));
    $initials = '';

    if (!empty($parts)) {
        $initials .= strtoupper($parts[0][0]); // first letter of first word
    }

    if (count($parts) > 1) {
        $initials .= strtoupper($parts[1][0]); // first letter of second word
    }

    return $initials;
}

    private   function dynamicBgColor(): string
    {

 $colors = [
            'bg-blue-600',
            'bg-pink-600',
            'bg-purple-600',
            'bg-green-600',
            'bg-yellow-600',
            'bg-red-600',
            'bg-indigo-600',
            'bg-teal-600',
            'bg-orange-600',
            'bg-gray-600',
        ];

        return $colors[array_rand($colors)];
    }
private function color(?int $id = null): string
{
    $colors = [
        'blue',
        'pink',
        'purple',
        'green',
        'yellow',
        'red',
        'indigo',
        'teal',
        'orange',
        'gray',
    ];

    if ($id === null) {
        // no id passed → random colour
        return $colors[array_rand($colors)];
    }

    // id passed → pick by index (wrap if bigger than array)
    // ensure non-negative integer
    $index = abs($id) % count($colors);

    return $colors[$index];
}
private function icon(int $id): string
{
    // 100 Material icon names that are relevant to apps / dashboards / tasks
    $icons = [
             // Tasks / projects / workflow
        'assignment', 'assignment_turned_in', 'assignment_late', 'fact_check', 'checklist',
        'event_note', 'pending_actions', 'rule', 'track_changes', 'flag',
        // Navigation / UI
        'home', 'dashboard', 'menu', 'more_vert', 'expand_more',
        'expand_less', 'arrow_back', 'arrow_forward', 'keyboard_arrow_up', 'keyboard_arrow_down',
        // People / users / roles
        'person', 'people', 'group', 'person_add', 'supervisor_account',
        'manage_accounts', 'admin_panel_settings', 'badge', 'account_circle', 'contacts',

        // Tasks / projects / workflow
        'assignment', 'assignment_turned_in', 'assignment_late', 'fact_check', 'checklist',
        'event_note', 'pending_actions', 'rule', 'track_changes', 'flag',

        // Communication
        'chat', 'forum', 'email', 'alternate_email', 'phone',
        'notifications', 'notifications_active', 'sms', 'mark_email_unread', 'support_agent',

        // Files / docs / storage
        'folder', 'folder_open', 'drive_file_move', 'file_present', 'upload_file',
        'download', 'download_done', 'cloud', 'cloud_upload', 'cloud_download',

        // Finance / payments
        'attach_money', 'credit_card', 'account_balance', 'request_quote', 'price_change',
        'price_check', 'monetization_on', 'shopping_cart', 'point_of_sale', 'receipt_long',

        // Actions / controls
        'add', 'edit', 'delete', 'save', 'send',
        'share', 'visibility', 'visibility_off', 'lock', 'lock_open',

        // Navigation / UI
        'home', 'dashboard', 'menu', 'more_vert', 'expand_more',
        'expand_less', 'arrow_back', 'arrow_forward', 'keyboard_arrow_up', 'keyboard_arrow_down',

        // Analytics / reports
        'insights', 'analytics', 'trending_up', 'query_stats', 'bar_chart',
        'stacked_bar_chart', 'leaderboard', 'timeline', 'donut_large', 'pie_chart',

        // Settings / system
        'settings', 'tune', 'build', 'bug_report', 'system_update_alt',
        'security', 'verified_user', 'autorenew', 'update', 'language',

        // Locations / logistics
        'location_on', 'location_off', 'map', 'directions', 'local_shipping',
        'directions_car', 'directions_bus', 'store', 'warehouse', 'inventory',

        // Miscellaneous project-related
        'work', 'school', 'calendar_today', 'date_range', 'history',
        'access_time', 'hourglass_empty', 'book', 'library_books', 'emoji_objects'
    ];

    // wrap index if it exceeds array length
    $index = abs($id) % count($icons);

    return $icons[$index];
}


}
