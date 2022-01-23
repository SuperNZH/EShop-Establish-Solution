<?php

namespace controllers;


// 这是一个父类的controller
class BaseControllers
{
    protected $twig;
    protected $data = [];

    public function __construct()
    {
        // 模板加载到哪个目录下
        $loader = new \Twig\Loader\FilesystemLoader(TEMPDIR.'/app/views');// 要用绝对路径, C:/wamp64/www/eshop
        $this->twig = new \Twig\Environment($loader, [
            // 这个模板在开发的时候不要打开，要不然比较麻烦
//                'cache' => '/path/to/compilation_cache',
        ]);

    }

    protected function assign($var, $value = null)
    {
        // 是数组就传数组且合并，否则就转一个值
        if (is_array($var)) {
            $this->data = array_merge($this->data, $var);
        } else {
            $this->data[$var] = $value;
        }
    }

    protected function display($template)
    {
        $url = getCurUrl();

        $this->assign('uri', $url);

        echo $this->twig->render($template . '.html', $this->data);
    }

    protected function topsuccess($url, $mess) {
        echo "<script>";
        echo "alert('{$mess}');";

        if(!empty($url)) {
            echo "top.location.href='{$url}';";
        }

        echo "</script>";
    }

    // 成功跳转
    protected function success($url, $mess)
    {
        echo "<script>";
        echo "alert(' {$mess}');";

        if (!empty($url)) {
            echo "location.href='{$url}';";
        }

        echo "</script>";
    }

    // 失败跳转
    protected function error($url, $mess)
    {
        echo "<script>";
        echo "alert('ERROR: {$mess}');";

        if (!empty($url)) {
            echo "location.href='{$url}';";
        }

        echo "</script>";
    }
}
