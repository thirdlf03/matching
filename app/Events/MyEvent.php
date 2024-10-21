<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MyEvent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $message;
  public $userId;

  public function __construct($message, $userId)
  {
      $this->message = $message;
      $this->userId = $userId;
  }

  public function broadcastOn(): PrivateChannel
  {
      return new PrivateChannel('my-channel'.$this->userId);
  }

  public function broadcastAs()
  {
      return 'my-event';
  }
}
