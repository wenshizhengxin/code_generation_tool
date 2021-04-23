<?php
/**
 * 描述：
 * Created at 2021/3/15 19:30 by 陈庙琴
 */

namespace wenshizhengxin\code_generation_tool;


use epii\app\controller;
use epii\server\Args;
use epii\server\Response;
use epii\server\Tools;
use epii\template\engine\EpiiViewEngine;
use wenshizhengxin\code_generation_tool\libs\interface_set\ActionInterface;

class cgt_controller extends controller
{
    public function __construct()
    {
        $viewEngine = new EpiiViewEngine();
        $viewEngine->init(['tpl_dir' => __DIR__ . '/view', 'cache_dir' => Tools::getRuntimeDirectory() . '/../view']);
        $this->setViewEngine($viewEngine);
    }

    public function index()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $dbName = Args::params('db_name');
                $id = Args::params('id');
                $action = Args::params('action');

                $args = Args::params('args', '');
                $args = $this->getArgs($args);

                $driver = 'wenshizhengxin\\code_generation_tool\\libs\\action\\' . $action;
                if (class_exists($driver) === false) {
                    throw new \Exception('action类不存在' . $driver);
                }

                $code = $this->getCode(new $driver(), $dbName, $args, $id);

                Response::success(['code' => $code]);
            } else {
                $this->display('cgt/index');
            }
        } catch (\Exception $e) {
            Response::error($e->getMessage());
        }
    }

    private function getArgs(string $args)
    {
        $args = array_filter(explode("\n", $args));
        return $args;

        $data = [];
        foreach ($args as $i => $arg) {
            $key = explode('/', $arg)[0];
            $value = $arg;
            $data[$key] = $value;
        }

        return $data;
    }

    private function getCode(ActionInterface $action, $dbName = '', $args = [])
    {
        return $action->getCode($dbName, $args);
    }
}