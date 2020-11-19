<?php
/**
 * 缓存类接口
 * Created by PhpStorm.
 * User: xu
 * Date: 2020/11/12
 * Time: 23:51
 */

namespace Lib\Cache\Interfaces;


interface CacheInterfaces
{
    /**
     * 保存缓存
     * @param $key
     * @param $value
     * @param $ttl
     * @return mixed
     */
    public function save($key, $value, $ttl);

    /**
     * 获取缓存
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * 删除缓存
     * @param $key
     * @return mixed
     */
    public function delete($key);

    /**
     * 自增
     * @param $key
     * @param int $value
     * @return mixed
     */
    public function increment($key,$value= 1);

    /**
     * 自减
     * @param $key
     * @param int $value
     * @return mixed
     */
    public function decrement($key,$value= 1);

    /**
     * 清空缓存
     * @return mixed
     */
    public function flush();
}