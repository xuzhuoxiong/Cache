<?php


namespace Lib\Cache;

use Lib\Cache\Interfaces\CacheInterfaces;

/*
 * 文件缓存类
 * 文件缓存保存在磁盘文件 一个key对应一个缓存文件
 * */

class File implements CacheInterfaces
{
    protected $preFix = 'j.k.x.y';//key前缀
    protected $cacheDir = ROOT . '/store';//缓存目录
    protected $fileExt = '.caches';//缓存文件扩展名

    public function __construct($options = [])
    {
        if (isset($options['preFix']) && $options['preFix']) {
            $this->preFix = $options['preFix'];
        }
        if (isset($options['fileExt']) && $options['fileExt']) {
            $this->fileExt = $options['fileExt'];
        }
    }

    /**
     * 获取缓存文件
     * @param $key
     * @return bool|string
     */
    public function getCacheFile($key)
    {
        if (!$key) {
            return false;
        }
        $key = $this->preFix . $key;
        $str = sha1($key);
        return $this->cacheDir . '/' . substr($str, 0, 2) . '/' . substr($str, 2, 2) . '/' .
            substr($str, 4) . $this->fileExt;
    }

    /**
     * 设置缓存
     * @param $key
     * @param $value
     * @param $ttl
     * @return bool
     */
    public function save($key, $value, $ttl=3600)
    {
        if (!$key || !$value) {
            return false;
        }
        $ttl       = $ttl <= 0 ? 3600 : $ttl;
        $cacheFile = $this->getCacheFile($key);
        $cacheDir  = dirname($cacheFile);
        if (!file_exists($cacheDir)) {
            if (!mkdir($cacheDir, 0777, true)) {
                return false;
            }
        }
        if (file_put_contents($cacheFile, $value, LOCK_EX) !== false) {
            @touch($cacheFile, $ttl + time());//修改文件的修改时间 用来判断过期时间
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取缓存
     * @param $key
     * @return bool|string
     */
    public function get($key)
    {
        if (!$key) {
            return false;
        }
        $cacheFile = $this->getCacheFile($key);
        if (!file_exists($cacheFile)) {
            return false;
        }
        //判断缓存是否过期
        if (filemtime($cacheFile) > time()) {
            return file_get_contents($cacheFile);
        } else {
            @unlink($cacheFile);//删除文件
        }
        return false;
    }

    /**
     * 自增
     * @param $key
     * @param int $value
     * @return bool
     */
    public function increment($key, $value = 1)
    {
        if (!$key) {
            return false;
        }
        $cacheFile = $this->getCacheFile($key);
        if (filemtime($cacheFile) < time()) {
            return false;
        }
        $content = file_get_contents($cacheFile);
        $content += $value;
        if ($this->save($key, $content)) {
            return true;
        }
    }

    /**
     * 自减
     * @param $key
     * @param $value
     * @return bool
     */
    public function decrement($key, $value=1)
    {
        return $this->increment($key,-$value);
    }

    /**
     * 删除缓存
     * @param $key
     * @return bool
     */
    public function delete($key)
    {
        if(!$key){
            return false;
        }
        $cacheFile = $this->getCacheFile($key);
        @unlink($cacheFile);
        return true;
    }

    /**
     * @return mixed
     */
    public function flush()
    {
        return $this->deleteCacheDir($this->cacheDir);
    }

    /**
     * 递归删除文件
     * @param $dir
     */
    public function deleteCacheDir($dir)
    {
        if(($handle = opendir($dir)) !== false){
            while (($file = readdir($handle)) !== false){//注意运算符的顺序先赋值后比较所以加（）了
                if($file[0] == '.'){
                    continue;
                }
                $path = $dir.'/'.$file;
                if(is_dir($path)){
                    $this->deleteCacheDir($path);
                }else{
                    @unlink($path);
                }
            }
            @rmdir($dir);//rmdir只可以删除空目录 放置位置不同删除目录的效果不同 注意体会
        }
        closedir($handle);
        return true;

    }


}