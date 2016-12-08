<?php

class Controller_Main extends Controller
{
    public function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
        $this->model->connectDB();
    }

    function action_index()
    {
        $this->view->generate('main_view.php', 'template_view.php');
    }

    function action_check()
    {
        $data = $this->model->check();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function action_load()
    {
        $data = $this->model->load();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
}