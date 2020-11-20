<?php
/**
 * Created by PhpStorm.
 * User: xzx_myself
 * Date: 2020/11/19
 * Time: 15:49
 */
namespace Lib\Model;

/**
 * mysqli 的数据库连接基类
 * Class Base
 * @package Lib\Model
 */
class Base{
    protected $mysqli;

    public function __construct()
    {
        try{
            $mysqli = new \mysqli("127.0.0.1","root","123456");//mysqli 连接数据库
            if(!$mysqli){
                throw new \Exception($mysqli->error);//若无连接成功 抛出异常
            }
            $mysqli->set_charset("utf8");//设置连接数据库编码为utf8
            $mysqli->select_db("cache");//等同于 use cache；
            $this->mysqli = $mysqli;
        }catch (\Exception $e){
            echo $e->getMessage();
                return false;
        }
    }
}