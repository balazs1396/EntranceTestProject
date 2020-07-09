<?php

namespace App\Http\Services;

use App\WS\ChannelConsumer;
//use App\Channel;

class Channel
{        
    
    /**
     * consumer
     *
     * @var App\WS\ChannelConsumer
     */
    protected $consumer;  

    /**
     * appointments
     *
     * @var array
     */
    protected $appointments = [];
    
    /**
     * topChannels
     *
     * @var array
     */
    protected $topChannels = [];

    function __construct()
    {
        $this->consumer = app(ChannelConsumer::class);

        $this->dropActualTopChannels();
    }

    /**
     * getTopChannels
     *
     * @param  Integer $count
     * @return void
     */
    public static function getTopChannels($count = 5)
    {
        return (new static())->topChannels($count);
    }
    
    /**
     * getTopChannels - Return top X channel from port.hu
     *
     * @param  Integer $count
     * @return array
     */
    public function topChannels( $count)
    {
        try {
            $this->appointments = $this->consumer->geTopXChannel();
        } catch (\Exception $ex) {
            \Log::error('Some error happened to consume the port.hu api', ['message' => $ex->getMessage()]);
        }

        $i = 1;
        foreach ($this->appointments->channels as $channel) {
            $this->topChannels[] = $channel;

            $this->storeActulChannel($channel);
            
            if ($i++ >= 5) {
                break;
            }
        }

        $channels = $this->topChannels;
        return compact('channels');
    }
    
    /**
     * dropActualTopChannels - Every run refresh the actual top 5 channel
     *
     * @return void
     */
    protected function dropActualTopChannels()
    {
        \App\Channel::truncate();
    }
    
    /**
     * storeActulChannel - Store one channel in the db
     *
     * @param  Object $channel
     * @return void
     */
    protected function storeActulChannel($channel)
    {
        \App\Channel::create((array) $channel);
    }
}