<?php
class BaseController
{
    protected $mAccount;
    public function __construct()
    {
        $this->mAccount = new AccountModal();
    }

    protected function first_use($user)
    {
        return $this->mAccount->first_use($user);
    }

    function render($file, $data = array())
    {
        $view_file = __DIR__ . "/../view/pages/" . $file . '.php';
        if (is_file($view_file)) {
            ob_start();
            require_once($view_file);
            $content = ob_get_clean();
            require_once(__DIR__ . "/../view/layout/app.php");
        } else {
            header('Location: error');
        }
    }
}
