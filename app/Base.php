<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    /**
     * Get the name of given class sans class namespace
     *
     * @return string
     */
    public static function className() : string
    {
        return class_basename(get_called_class());
    }

	/**
     * Get the namespace of given model name
     * e.g. for RecipeCuisine will be recipe-cuisine
     *
     * @return string
     */
    public static function namespace() : string
    {
        // /(?<!^)[A-Z]/ means - take every capital letter (except first)
        return strtolower(str_plural(preg_replace('/(?<!^)[A-Z]/', '-$0', self::className())));
    }

    /**
     * Get the plural form of given model name
     * e.g. for RecipeCuisine will be recipe cuisines
     *
     * @return string
     */
    public static function plural() : string
    {
        return strtolower(str_plural(preg_replace('/(?<!^)[A-Z]/', ' $0', self::className())));
    }

     /**
     * Get the singular form of given model name
     * e.g. for RecipeCuisine will be recipe cuisine
     *
     * @return string
     */
    public static function singular() : string
    {
        return strtolower(str_singular(preg_replace('/(?<!^)[A-Z]/', ' $0', self::className())));
    }

    /**
     * Helper function to retrieve namespace
     *
     * @return string
     */
    public function getNamespaceAttribute() : string
    {
        return $this->namespace();
    }

    /**
     * Helper function to retrieve plural
     *
     * @return string
     */
    public function getPluralAttribute() : string
    {
        return $this->plural();
    }

    /**
     * Helper function to retrieve singular
     *
     * @return string
     */
    public function getSingularAttribute() : string
    {
        return $this->singular();
    }
}
