<?php


namespace App;

class Storage
{
    /** @var string */
    private static $fileName = 'storage';

    /**
     * Get all exchanges from storage
     *
     * @return array
     */
    public static function read(): array
    {
        $path = MAIN_DIR_NAME . '/' . self::$fileName;

        if (file_exists($path)) {
            $data = file_get_contents($path);

            return unserialize($data);
        }

        return [];
    }

    /**
     * Write exchanges to storage
     *
     * @param array $exchange
     * @return bool
     */
    public static function write(array $exchange): bool
    {
        return (bool)file_put_contents(MAIN_DIR_NAME . '/' . self::$fileName, serialize($exchange));
    }
}
