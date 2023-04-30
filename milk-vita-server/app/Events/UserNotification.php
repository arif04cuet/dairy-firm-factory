<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithBroadcasting;

    //
    protected $user = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user=null)
    {
        $this->broadcastVia('pusher');
        $this->user = $user;
    }

    public function broadcastWith()
    {
        if($this->user){
            //
            $notifications = $this->user->unreadNotifications;

            $total_showable = $notifications->count();
            //
            $collection = collect($notifications)->map(function ($row, $key) use ($total_showable)
            {
                $data = (Object)$row->data;
                return [
                    'id'                => $row->id,
                    'title'             => ($data->title ?? '---'),
                    'push_notification' => ($total_showable == ($key+1) ? 'true' : 'false'),
                ];
            });
            //
            return [
                'total_unread'      => $notifications->count(),
                'notifications'     => $collection
            ];
        }
        return false;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if($this->user){
            return new Channel('user.notification.'.($this->user->id));
        }
    }
}
