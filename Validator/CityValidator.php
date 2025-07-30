<?php declare(strict_types=1);

namespace LokiCheckout\LoosenCityValidator\Validator;

use Magento\Customer\Model\Validator\City as OriginalCityValidator;

class CityValidator extends OriginalCityValidator
{
    public function __construct(
        private string $regex = '/([A-Za-z0-9\-\ \']+)/u',
        private int $maximumLength = 100,
    ) {
    }

    public function isValid($customer)
    {
        if (!$this->isValidCity((string)$customer->getCity())) {
            parent::_addMessages([
                [
                    'city' => "Invalid City. Please use A-Z, a-z, 0-9, -, ', spaces",
                ],
            ]);
        }

        return count($this->_messages) == 0;
    }

    private function isValidCity(string $cityValue): bool
    {
        if ($cityValue === '') {
            return true;
        }

        if (strlen($cityValue) > $this->maximumLength) {
            return false;
        }

        if (preg_match($this->regex, $cityValue, $matches)) {
            return $matches[0] === $cityValue;
        }

        return true;
    }
}
