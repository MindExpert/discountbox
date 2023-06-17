<?php

namespace App\Support;

class TranslatableValidation
{
    protected array $locales;

    public function __construct()
    {
        $this->locales = config('app.locales');
    }

    public static function make(): self
    {
        return new self();
    }

    public function rules(string $name, array|string $rules, ?bool $required = false): array
    {
        $validationRules = [
            $name => [$required ? 'required' : 'nullable', 'array'],
        ];

        foreach ($this->locales as $locale) {
            $validationRules["$name.$locale"] = $rules;
        }

        return $validationRules;
    }

    public function attributes(string $name, string $translation): array
    {
        $attributes = [
            $name => $translation,
        ];

        foreach ($this->locales as $locale) {
            $attributes["$name.$locale"] = $translation . ' ' . __("general.locales.inputs.$locale");
        }

        return $attributes;
    }

    /**
     * Get the attribute name and the inputArray and check
     * if the translation is missing for other locales.
     * and then add the default locale translation to the missing locales.
     * primary locale should be the same as the fallback locale.
     * locale === fallback_locale
     * @param string|array $field
     * @param array $userInputs
     *
     * @return array
     */
    public function unifyTranslation(string|array $field, array $userInputs): array
    {
        if (is_string($field)) {
            $field = [$field];
        }

        foreach ($field as $name) {
            if (!isset($userInputs[$name]) || !is_array($userInputs[$name]) || count($userInputs[$name]) === 0) {
                continue;
            }

            $translations = [];
            $primaryLocale = config('app.fallback_locale');

            if (!array_key_exists($primaryLocale, $userInputs[$name])) {
                continue;
            }

            $defaultContent = $userInputs[$name][$primaryLocale] ?? null;

            foreach ($userInputs[$name] as $lang => $content) {
                if (!isset($content) && $lang !== $primaryLocale) {
                    $translations[$lang] = $defaultContent;
                } else {
                    $translations[$lang] = $content;
                }
            }
            $userInputs[$name] = $translations;
        }

        return $userInputs;
    }
}
