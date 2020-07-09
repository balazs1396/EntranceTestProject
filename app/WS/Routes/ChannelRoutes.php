<?php

namespace App\WS\Routes;

class ChannelRoutes
{
    
    public function geTopXChannel()
    {
        return $this->consume('tvapi/init', 'GET');
	}
	
	public function getAllProgramByChannelAndDate($channelId, $date) 
	{
		return $this->consume('tvapi?channel_id=' . $channelId . '&i_datetime_from=' . $date . 
			'&i_datetime_to=' . $date, 'GET');	

		// ?channel_id=tvchannel-3&i_datetime_from=2020-07-07&i_datetime_to=2020-07-13
	}
}
