<?php
declare(strict_types=1);

namespace BWT\Core;

use BWT\Exceptions\ConfigNotFoundException;

class Config
{
    private static array $config = [];

    public static function get(string $key): mixed
    {
        try {
            if (empty(self::$config)) {
                self::$config = json_decode(file_get_contents(BASE_DIR.'/config.json'), true);
            }

            $value = self::$config;
            foreach (explode('.', $key) as $item) {
                if (! isset($value[$item])) {
                    throw new ConfigNotFoundException(sprintf('Config key %s does not exist!', $key));
                }

                $value = $value[$item];
            }

            return $value;
        } catch (\Exception $e) {
            throw new ConfigNotFoundException($e->getMessage());
        }
    }
}
