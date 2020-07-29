<?php
namespace mghddev\adp;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use mghddev\adp\Constant\MessageStatus;
use mghddev\adp\Exception\AdpAuthenticationException;
use mghddev\adp\Exception\AdpEnoughCreditException;
use mghddev\adp\Exception\AdpException;
use mghddev\adp\Exception\AdpInvalidArgumentException;
use mghddev\adp\Exception\AdpInvalidMessageBodyException;
use mghddev\adp\Exception\AdpMessageNotFoundException;
use mghddev\adp\Exception\AdpValidationException;
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
    protected array $default_config = ['base_uri' => 'http://ws2.adpdigital.com/url'];

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

    /**
     * AdpApiClient constructor.
     * @param string $username
     * @param string $password
     * @param array $config
     */
    public function __construct(string $username, string $password, array $config = [])
    {
        $this->base_uri = $config['base_uri'] ?? $this->default_config['base_uri'];
        $this->http_client = new Client(['base_uri' => $this->base_uri]);
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param Message $message
     * @return string|string[]
     * @throws AdpAuthenticationException
     * @throws AdpEnoughCreditException
     * @throws AdpException
     * @throws AdpInvalidMessageBodyException
     * @throws AdpValidationException
     */
    public function send(Message $message)
    {
        $url = '/send?username=' .
            $this->username .
            '&password=' .
            $this->password .
            '&dstaddress=' .
            $message->getDstAddress() .
            '&body=' .
            urlencode($message->getBody());


        if (!empty($message->getSrcAddress())) {
           $url = $url .
               '&srcaddress=' .
               $message->getSrcAddress();
        }

        if (!empty($message->getClientId())) {
            $url = $url .
                '&clientid=' .
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

        if (strpos($result, '--BEGIN') === 0) {
            $id = ltrim($result, '--BEGIN');
            $id = str_replace('--END', '', $id);
            $id = str_replace('ID:', '', $id);
            $id = str_replace(' ', '', $id);

            return $id;
        } else {
            $this->generateExceptionFromResultString($result);
        }
    }

    /**
     * @param ReportVO $reportVO
     * @return string|string[]
     * @throws AdpAuthenticationException
     * @throws AdpEnoughCreditException
     * @throws AdpException
     * @throws AdpInvalidMessageBodyException
     * @throws AdpMessageNotFoundException
     * @throws AdpValidationException
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

        $result_rep = file_get_contents($this->base_uri . $url);

        if (strpos($result_rep, '--BEGIN') === 0) {
            $id = ltrim($result_rep, '--BEGIN');
            if (strpos($id, 'INFO') === 1) {
                throw new AdpMessageNotFoundException($result_rep);
            } else {
                return $this->generateStatus($result_rep);
            }
        }

        $this->generateExceptionFromResultString($result_rep);
    }

    /**
     * @param ReportVO $reportVO
     * @return array
     * @throws AdpAuthenticationException
     * @throws AdpEnoughCreditException
     * @throws AdpException
     * @throws AdpInvalidMessageBodyException
     * @throws AdpMessageNotFoundException
     * @throws AdpValidationException
     */
    public function bulkReport(ReportVO $reportVO)
    {
        $url = '/report?username=' .
            $this->username . '&password=' .
            $this->password;

        if (!empty($reportVO->getFromClientId())) {
            $url = $url . '&fromclientid=' . $reportVO->getFromClientId();
        }

        if (!empty($reportVO->getFromId())) {
            $url = $url . '&fromid=' . $reportVO->getFromId();
        }

        if (!empty($reportVO->getFull())) {
            $url = $url . '&full=' . $reportVO->getFull();
        }

        if (!empty($reportVO->getSrcAddress())) {
            $url = $url . '&srcaddress=' . $reportVO->getSrcAddress();
        }

        $result_rep = file_get_contents($this->base_uri . $url);

        if (strpos($result_rep, '--BEGIN') === 0) {
            $id = ltrim($result_rep, '--BEGIN');
            if (strpos($id, 'INFO') === 1) {
                throw new AdpMessageNotFoundException($result_rep);
            } else {
                return $this->generateBulkStatus(ltrim($id));
            }
        }

        $this->generateExceptionFromResultString($result_rep);
    }

    /**
     * @param string $result
     * @throws AdpAuthenticationException
     * @throws AdpEnoughCreditException
     * @throws AdpException
     * @throws AdpInvalidMessageBodyException
     * @throws AdpValidationException
     */
    protected function generateExceptionFromResultString(string $result)
    {
        //‫‪User‬‬ ‫‪Authentication‬‬ ‫‪Failure‬‬
        if (strpos($result, 'User Authentication Failure')) {
            throw new AdpAuthenticationException($result);
        }

        //‫‪Not‬‬ ‫‪Enough‬‬ ‫‪Credit‬‬
        if (strpos($result, 'Not Enough Credit')) {
            throw new AdpEnoughCreditException($result);
        }

        //‫‪Null‬‬ ‫‪Parameter‬‬
        if (strpos($result, 'Null Parameter')) {
            throw new AdpInvalidArgumentException($result);
        }

        //‫‪Body‬‬ ‫‪Decoding‬‬ ‫‪Error‬‬
        if (strpos($result, 'Body Decoding Error')) {
            throw new AdpInvalidMessageBodyException($result);
        }

        //‫‪Parameter‬‬ ‫‪value‬‬ ‫‪is‬‬ ‫‪not‬‬ ‫‪valid‬‬
        if (strpos($result, 'Parameter Value is not Valid')) {
            throw new AdpValidationException($result);
        }

        //‫‪Parameter‬‬ ‫‪value‬‬ ‫‪is‬‬ ‫‪not‬‬ ‫‪valid‬‬
        if (strpos($result, 'Parameter Value is not Valid')) {
            throw new AdpValidationException($result);
        }

        throw new AdpException($result);

    }

    /**
     * @param string $result_rep
     * @return string
     */
    private function generateStatus(string $result_rep)
    {
        if (strpos($result_rep, MessageStatus::DELIVERED) !== false) {
            return MessageStatus::DELIVERED;
        }

        if (strpos($result_rep, MessageStatus::PENDING) !== false) {
            return MessageStatus::PENDING;
        }

        if (strpos($result_rep, MessageStatus::UNDELIVERABLE) !== false) {
            return MessageStatus::UNDELIVERABLE;
        }
    }

    private function generateBulkStatus(string $result)
    {
        $statuses = [];

        while (strpos($result, 'ID:') === 0) {
            $start = strpos($result, 'ID');
            $space = strpos($result, ' ');
            $str = substr($result, $start, $space - $start);
            $id = str_replace('ID:', '', $str);
            $result = ltrim(str_replace($str . ' ', '', $result));

            $start2 = strpos($result, 'CLIENTID');
            $space2 = strpos($result, ' ');
            $str2 = substr($result, $start2, $space2 - $start2);
            $result = ltrim(str_replace($str2 . ' ', '', $result));

            $start3 = strpos($result, 'STATUS');
            $space3 = strpos($result, ' ');

            $str3 = substr($result, $start3, $space3 - $start3);
            $status = str_replace('STATUS:', '', $str3);
            $result = ltrim(substr($result, $space3, strlen($result) - $space3));

            $statuses[$id] = $this->generateStatus($status);
        }

        return $statuses;

    }
}
