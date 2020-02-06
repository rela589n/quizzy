<?php


namespace App\Lib;


use Illuminate\Http\Request;

class ValidationGenerator
{
    public const ARRAY_ELEMENT_WILDCARD = '*';
    public const ARRAY_ELEMENTS_DELIMITER = '.';

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    private $parts;

    /**
     * ValidationGenerator constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function buildRecursive(string $base, int $nextPartIndex)
    {
        if ($nextPartIndex >= count($this->parts)) {
            yield $base;
        } else {
            foreach ($this->request->input(rtrim($base, self::ARRAY_ELEMENTS_DELIMITER), []) as $key => $value) {

                foreach ($this->buildRecursive($base . $key . $this->parts[$nextPartIndex], $nextPartIndex + 1) as $built) {
                    yield $built;
                }
            }
        }
    }

    /**
     * Split $param by delimiter and
     * set it's parts to appropriate variable
     * @param string $param
     * @return void
     */
    protected function mountParts(string $param) : void
    {
        $this->parts = explode(self::ARRAY_ELEMENT_WILDCARD, $param);
    }

    /**
     * @param string $key
     * @param array|string $value
     * @return array
     */
    protected function build(string $key, $value): array
    {
        $result = [];
        $this->mountParts($key);

        foreach ($this->buildRecursive($this->parts[0], 1) as $built) {
            $result[$built] = $value;
        }

        return $result;
    }

    /**
     * @param string $attribute
     * @param array|string $rules
     * @return array
     */
    public function buildRules(string $attribute, $rules): array
    {
        return $this->build($attribute, $rules);
    }

    /**
     * Builds Laravel-feedable array, where keys are attributes <br>
     * and values are validation rules
     * @param array $rules
     * @return array
     */
    public function buildManyRules(array $rules): array
    {
        $result = [];
        foreach ($rules as $attribute => $rule) {
            $this->mountParts($attribute);

            foreach ($this->buildRecursive($this->parts[0],1) as $built) {
                $result[$built] = $rule;
            }
        }

        return $result;
    }

    /**
     * @param string $attribute
     * @param array|string $messages
     * @return array
     */
    public function buildMessages(string $attribute, $messages): array
    {
        return $this->build($attribute, $messages);
    }

    /**
     * @param string $attribute
     * @param string $name
     * @return array
     */
    public function buildAttributes(string $attribute, string $name): array
    {
        return $this->build($attribute, $name);
    }
}
