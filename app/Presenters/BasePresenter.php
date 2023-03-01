<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    protected function beforeRender(): void
    {
        parent::beforeRender();
        $this->redrawControl('content');
    } 
}