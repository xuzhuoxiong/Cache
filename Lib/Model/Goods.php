<?php
/**
 * Created by PhpStorm.
 * User: xzx_myself
 * Date: 2020/11/19
 * Time: 15:49
 */

namespace Lib\Model;

use Lib\Cache\Cache;

class Goods extends Base
{
    public function getOneGoodsById($goodsId)
    {
        if (!$goodsId) {
            return false;
        }
        $cacheKey = $this->getCacheKey($goodsId);
        $cache    = Cache::Factory('File', ['preFix' => "test", 'fileExt' => '.txt']);
        $goods    = $cache->get($cache);
        if (!$goods || $goods = json_decode($goods, true)) {
            //获取主表信息
            $sql = "SELECT * FROM jk_goods WHERE `id` = {$goodsId}";
            $obj = $this->mysqli->query($sql);
            if (!$obj->num_rows) {
                return false;
            }
            $goods = $obj->fetch_assoc();
            unset($obj, $sql);//unset 可以同时释放多个变量到的

            //查询图片信息
            $picList = [];
            $picIds  = '(' . implode(',', array_unique(explode(',', $goods['pic_ids']))) . ')';
            $sql     = "SELECT * FROM `jk_pic` WHERE `id` IN {$picIds}";
            $obj     = $this->mysqli->query($sql);
            if ($obj->num_rows) {
                while ($result = $obj->fetch_assoc()) {
                    $picList[] = $result;
                }
            }
            $goods['pic_list'] = $picList;
            unset($obj, $sql);

            //商品的详情信息
            $sql = "SELECT * FROM `jk_goods_info` WHERE `goods_id`={$goodsId}";
            $obj = $this->mysqli->query($sql);
            if ($obj->num_rows) {
                $goodsInfos = $obj->fetch_assoc();
                $goods      = array_merge($goods, $goodsInfos);
            }

            //查询商品的规格表
            unset($sql, $obj);
            $goodsAtty = [];
            $sql       = "SELECT * FROM `jk_goods_attr` WHERE goods_id ={$goodsId} ";
            $obj       = $this->mysqli->query($sql);
            if ($obj->num_rows) {
                while ($result = $obj->fetch_assoc()) {
                    $goodsAtty[] = $result;
                }
            }
            $goods['attr']           = $goodsAtty;
            $goods['cache_set_time'] = date("Y-m-d H:i:s", time());
        }
        return $goods;


    }

    /**
     * 获取缓存key
     * @param $goodsId
     * @return string
     */
    public function getCacheKey($goodsId)
    {
        return "goods:cache:{$goodsId}";
    }

    public function cleanGoodsCache($goodsId)
    {
        if(!$goodsId){
            return false;
        }
        $cacheKey = $this->getCacheKey($goodsId);
        $
    }
}