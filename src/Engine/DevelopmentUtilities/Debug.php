<?php

namespace MvcLite\Engine\DevelopmentUtilities;

class Debug
{
    public static function dump(mixed ...$values): void
    {
        foreach ($values as $value)
        {
            echo "<div mvclite-dd>
                      <pre>";

            var_dump($value);

            echo "    </pre>
                  </div>";
        }
    }

    public static function dd(mixed ...$values): void
    {
        self::dump($values);

        die;
    }
}