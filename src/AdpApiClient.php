<?php
namespace mghddev\adp;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use mghddev\adp\ValueObject\Message;
use mghddev\adp\ValueObject\ReportVO;

/**
 * Class AdpApiClient
 * @package mghddev\adp
 */
class AdpApiClient implements iAdpGuzzleApiClient
{

    /**
     * @var array
     */
    protected array $default_config = ['base_uri' => 'http://ws.adpdigital.com/url'];

    /**
     * @var Client
     */
    protected Client $http_client;

    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string
     */
    protected string $base_uri;

    public function __construct(string $username, string $password, array $config = [])
    {
        $this->base_uri = $config['base_uri'] ?? $this->default_config['base_uri'];
        $this->http_client = new Client(['base_uri' => $this->base_uri]);
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param Message $message
     * @return false|string
     */
    public function send(Message $message)
    {
        $url = '/send?username=' .
            $this->username .
            '&password=' .
            $this->password .
            '&dstaddr=' .
            $message->getDstAddress() .
            '&body=' .
            $message->getBody();

        if (!empty($message->getSrcAddress())) {
           $url = $url .
               '&srcaddress=' .
               $message->getSrcAddress();
        }

        if (!empty($message->getClientId())) {
            $url = $url .
                '&body=' .
                $message->getClientId();
        }

        if (!empty($message->getUnicode())) {
            $url = $url .
                '&unicode=' .
                $message->getUnicode();
        }

        if (!empty($message->getSrcPort())) {
            $url = $url .
                '&srcport=' .
                $message->getSrcPort();
        }

        if (!empty($message->getDstPort())) {
            $url = $url .
                '&dstport=' .
                $message->getDstPort();
        }

        if (!empty($message->getType())) {
            $url = $url .
                '&type=' .
                $message->getType();
        }

        $result = file_get_contents($this->base_uri . $url);

        return $result;
    }

    /**
     * @param ReportVO $reportVO
     * @return false|string
     */
    public function report(ReportVO $reportVO)
    {
        $url = '/report?username=' .
            $this->username . '&password=' .
            $this->password;

        if (!empty($reportVO->getFromClientId())) {
            $url = $url . '&fromclientid=' . $reportVO->getFromClientId();
        }

        if (!empty($reportVO->getClientId())) {
            $url = $url . '&clientid=' . $reportVO->getClientId();
        }

        if (!empty($reportVO->getFromId())) {
            $url = $url . '&fromid=' . $reportVO->getFromId();
        }

        if (!empty($reportVO->getId())) {
            $url = $url . '&id=' . $reportVO->getId();
        }

        if (!empty($reportVO->getFull())) {
            $url = $url . '&full=' . $reportVO->getFull();
        }

        if (!empty($reportVO->getSrcAddress())) {
            $url = $url . '&srcaddress=' . $reportVO->getSrcAddress();
        }

        $result_rec = file_get_contents($this->base_uri . $url);

        return $result_rec;
    }

}
