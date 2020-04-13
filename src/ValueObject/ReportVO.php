<?php
namespace mghddev\adp\ValueObject;

/**
 * Class ReportVO
 * @package mghddev\adp\ValueObject
 */
class ReportVO
{
    /**
     * @var string|null
     */
    protected ?string $from_client_id;

    /**
     * @var string|null
     */
    protected ?string $from_id;

    /**
     * @var string|null
     */
    protected ?string $client_id;

    /**
     * @var string|null
     */
    protected ?string $id;

    /**
     * @var string|null
     */
    protected ?string $full;

    /**
     * @var string|null
     */
    protected ?string $src_address;

    /**
     * @return string|null
     */
    public function getFromClientId(): ?string
    {
        return $this->from_client_id;
    }

    /**
     * @param string|null $from_client_id
     * @return ReportVO
     */
    public function setFromClientId(?string $from_client_id)
    {
        $this->from_client_id = $from_client_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFromId(): ?string
    {
        return $this->from_id;
    }

    /**
     * @param string|null $from_id
     * @return ReportVO
     */
    public function setFromId(?string $from_id)
    {
        $this->from_id = $from_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    /**
     * @param string|null $client_id
     * @return ReportVO
     */
    public function setClientId(?string $client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return ReportVO
     */
    public function setId(?string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFull(): ?string
    {
        return $this->full;
    }

    /**
     * @param string|null $full
     * @return ReportVO
     */
    public function setFull(?string $full)
    {
        $this->full = $full;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSrcAddress(): ?string
    {
        return $this->src_address;
    }

    /**
     * @param string|null $src_address
     * @return ReportVO
     */
    public function setSrcAddress(?string $src_address)
    {
        $this->src_address = $src_address;
        return $this;
    }

}
