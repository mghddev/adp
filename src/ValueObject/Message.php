<?php
namespace mghddev\adp\ValueObject;

/**
 * Class Message
 */
class Message
{
    /**
     * @var string
     */
    protected string $dst_address;

    /**
     * @var string | null
     */
    protected ?string $src_address;

    /**
     * @var string
     */
    protected string $body;

    /**
     * @var int | null
     */
    protected ?int $client_id;

    /**
     * @var int | null
     */
    protected ?int $unicode;

    /**
     * @var int | null
     */
    protected ?int $src_port;

    /**
     * @var int | null
     */
    protected ?int $dst_port;

    /**
     * @var string | null
     */
    protected ?string $type;

    /**
     * @return string
     */
    public function getDstAddress(): string
    {
        return $this->dst_address;
    }

    /**
     * @param string $dst_address
     * @return $this
     */
    public function setDstAddress(string $dst_address)
    {
        $this->dst_address = $dst_address;
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
     * @return Message
     */
    public function setSrcAddress(?string $src_address)
    {
        $this->src_address = $src_address;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Message
     */
    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getClientId(): ?int
    {
        return $this->client_id;
    }

    /**
     * @param int|null $client_id
     * @return Message
     */
    public function setClientId(?int $client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUnicode(): ?int
    {
        return $this->unicode ?? null;
    }

    /**
     * @param int|null $unicode
     * @return Message
     */
    public function setUnicode(?int $unicode)
    {
        $this->unicode = $unicode;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSrcPort(): ?int
    {
        return $this->src_port ?? null;
    }

    /**
     * @param int|null $src_port
     * @return Message
     */
    public function setSrcPort(?int $src_port)
    {
        $this->src_port = $src_port;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDstPort(): ?int
    {
        return $this->dst_port ?? null;
    }

    /**
     * @param int|null $dst_port
     * @return Message
     */
    public function setDstPort(?int $dst_port)
    {
        $this->dst_port = $dst_port;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type ?? null;
    }

    /**
     * @param string|null $type
     * @return Message
     */
    public function setType(?string $type)
    {
        $this->type = $type;
        return $this;
    }
}