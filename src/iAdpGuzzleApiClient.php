<?php
namespace mghddev\adp;

use mghddev\adp\ValueObject\Message;
use mghddev\adp\ValueObject\ReportVO;

/**
 * Interface iAdpGuzzleApiClient
 * @package mghddev\adp
 */
interface iAdpGuzzleApiClient
{
    public function send(Message $message);

    public function report(ReportVO $reportVO);

}
