<?php

namespace App\Http\Services;

use App\WS\ChannelConsumer;

class Movie
{
    protected $channelId;
    /**
     * consumer
     *
     * @var App\WS\ChannelConsumer
     */
    protected $consumer;  

    function __construct($date)
    {
        $this->consumer = app(ChannelConsumer::class);

        foreach (\App\Channel::all() as $channel) {
            $this->deleteActualDateProgramsByChannel($channel->id, $date);
        }

        
    }

    /**
     * getTopChannels
     *
     * @param  Integer $count
     * @return void
     */
    public static function downloadProgramsByAllChannel($date)
    {
        return (new static($date))->download($date);
    }

    public function download($date)
    {
        foreach (\App\Channel::all() as $channel) {

            $this->channelId = $channel->getChannelId();
            $channels = $this->consumer->getAllProgramByChannelAndDate($this->channelId, $date);

            $this->storeChannels($channels);
        }
    }
    
        
    /**
     * deleteActualDateProgramsByChannel
     *
     * @param  \App\Channel Primary key $channelId
     * @param  Date $date
     * @return void
     */
    protected function deleteActualDateProgramsByChannel($channelId, $date)
    {
        \App\Program::where('channel_id', $channelId)
            ->where('start_datetime', $date)->delete();
    }

    protected function storeChannels($channels)
    {
        
        foreach ($channels as $channel) {
            foreach ($channel->channels[0]->programs as $program) {

                $ProgramModel = app(\App\Program::class);
                $ProgramModel->channel_id = $this->channelId;
                $ProgramModel->start_datetime = $program->start_datetime;
                $ProgramModel->title = $program->title;
                $ProgramModel->short_description = $program->short_description;
                $ProgramModel->age_limit = $program->restriction->age_limit;

                $ProgramModel->save();
            }
            
        }

        
        // dd(\App\Program::all());
        // dd($programs);

    }

    public static function getAllProgram()
    {
        foreach (\App\Program::all() as $program) {
            $tmp = new \stdClass;

            $tmp->channelName = \App\Channel::find($program->channel_id)->name;
            $tmp->channel_id = $program->channel_id;
            $tmp->start_datetime = $program->start_datetime;
            $tmp->title = $program->title;
            $tmp->short_description = $program->short_description;
            $tmp->age_limit = $program->age_limit;

            $programs[] = $tmp;
        }

        return compact('programs');
    }
}