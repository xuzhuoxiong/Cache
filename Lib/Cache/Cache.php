<?php
/**
 * Created by PhpStorm.
 * User: xu
 * Date: 2020/11/12
 * Time: 22:57
 */

namespace Lib\Cache;


class Cache
{
    protected static $type = ['File','Memcached'];
    /**
     *
     * @param $className
     * @param $options
     */
    public static function Factory($cacheType,$options=[])
    {
        try{
            if(!$cacheType){
//                throw new \UnexpectedValueException('342');报错查怎么用
                throw new \Exception('缓存类型不可为空');
            }
            $cacheType = ucfirst($cacheType);
            if(!in_array($cacheType, self::$type)){
                throw new \Exception('暂不支持当前的缓存类型');
            }
            $cacheType = __NAMESPACE__.'\\'.$cacheType;
            $obj = new $cacheType($options);
            return $obj;

        }catch (\Exception $e){
            echo $e->getMessage();
            return false;
        }

    }

}