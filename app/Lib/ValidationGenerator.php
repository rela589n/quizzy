<?php


namespace App\Lib;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ValidationGenerator
{
    public const ARRAY_ELEMENT_WILDCARD = '*';
    public const ARRAY_ELEMENTS_DELIMITER = '.';
    public const ATTRIBUTES_DELIMITER = '|';

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

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
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
    protected function mountParts(string $param): void
    {
        $this->parts = explode(self::ARRAY_ELEMENT_WILDCARD, $param);
    }

    protected function handleBuildSingle(string $key, array &$result, &$singleRules): void
    {
        $keys = explode(self::ATTRIBUTES_DELIMITER, $key);
        foreach ($keys as $attribute) {
            $this->mountParts($attribute);

            foreach ($this->buildRecursive($this->parts[0], 1) as $built) {
                $result[$built][] = is_string($singleRules) ?
                    explode(self::ATTRIBUTES_DELIMITER, $singleRules) :
                    $singleRules;

                $result[$built] = Arr::flatten($result[$built], 1);
            }
        }
    }

    /**
     * @param string $key
     * @param array|string $value
     * @return array
     */
    protected function build(string $key, $value): array
    {
        $result = [];

        $this->handleBuildSingle($key, $result, $value);

        return $result;
    }

    protected function flattenBuild(array &$built) : void
    {
        foreach ($built as $key => $value) {
            if (is_array($value) && count($value) == 1) {
                $built[$key] = $value[0];
            }
        }
    }

    /**
     * @param string $attribute
     * @param array|string $rules
     * @return array
     */
    public function buildRule(string $attribute, $rules): array
    {
        return $this->build($attribute, $rules);
    }

    /**
     * Builds Laravel-feedable array, where keys are attributes <br>
     * and values are validation rules or their human-readable names
     * @param array $rules
     * @return array
     */
    public function buildManyRules(array $rules): array
    {
        $result = [];
        foreach ($rules as $attributes => $rule) {
            $attributes = explode(self::ATTRIBUTES_DELIMITER, $attributes);

            foreach ($attributes as $attribute) {
                $this->handleBuildSingle($attribute, $result, $rule);
            }
        }

        return $result;
    }

    /**
     * @param string $attribute
     * @param string $value
     * @return array
     */
    public function buildAttribute(string $attribute, string $value): array
    {
        $result = $this->build($attribute, $value);
        $this->flattenBuild($result);

        return $result;
    }

    /**
     * Builds Laravel-feedable array, where keys are attributes <br>
     * and values are human-readable names of attributes
     * @param array $attributes
     * @return array
     */
    public function buildManyAttributes(array $attributes)
    {
        $result = $this->buildManyRules($attributes);
        $this->flattenBuild($result);

        return $result;
    }
}
