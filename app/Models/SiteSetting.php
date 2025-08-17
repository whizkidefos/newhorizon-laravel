<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'is_public',
    ];

    /**
     * Get a setting by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return $setting->value;
    }

    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value)
    {
        $setting = static::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->save();
        
        return $setting;
    }

    /**
     * Get all settings as key-value pairs
     *
     * @param string|null $group
     * @return array
     */
    public static function getAllSettings(?string $group = null)
    {
        $query = static::query();
        
        if ($group) {
            $query->where('group', $group);
        }
        
        return $query->pluck('value', 'key')->toArray();
    }
}
