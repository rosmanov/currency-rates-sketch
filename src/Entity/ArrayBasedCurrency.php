<?php
declare(strict_types=1);

namespace App\Entity;

/**
 * A currency entity constructible from an associative array. Can be useful for
 * parsing the rows fetched from database (poor man's hydration).
 */
class ArrayBasedCurrency implements CurrencyInterface {
    /**
     * @var string
     */
    private const ID_KEY = 'id';

    /**
     * @var string
     */
    private const CODE_KEY = 'code';

    /**
     * @var string
     */
    private const SYMBOL_KEY = 'symbol';

    /**
     * @var int
     */
    private $id;

    /**
     * Currency code such as USD, RUB etc.
     *
     * @var string
     */
    private $code;

    /**
     * International currency symbol in UTF-8
     *
     * @var string
     */
    private $symbol;

    /**
     * @param array $row Associative array representing a currency entity
     * (usually comes from database)
     */
    public function __construct(array $row)
    {
        $this->id = (int)($row[self::ID_KEY] ?? null);
        $this->code = (string)($row[self::CODE_KEY] ?? '');
        $this->symbol = (string)($row[self::SYMBOL_KEY] ?? '');
    }

    /**
     * {@inheritDoc}
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function symbol(): string
    {
        return $this->symbol;
    }

    /**
     * {@inheritDoc}
     */
    public function isValid(): bool
    {
        return $this->id > 0 && $this->code !== '' && $this->symbol !== '';
    }

    private function toArray(): array
    {
        return [
            self::ID_KEY => $this->id,
            self::CODE_KEY => $this->code,
            self::SYMBOL_KEY => $this->symbol,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $row = unserialize($serialized);

        $this->id = (int)($row[self::ID_KEY] ?? null);
        $this->code = (string)($row[self::CODE_KEY] ?? '');
        $this->symbol = (string)($row[self::SYMBOL_KEY] ?? '');
    }
}
