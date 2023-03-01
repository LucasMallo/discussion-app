<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model\PostFacade;
use Nette;
use Nette\Application\UI\Form;


final class PostFormFactory
{
	use Nette\SmartObject;

	public function __construct(
        private FormFactory $factory,
        private PostFacade $postFacade,
    ) {

	}


	public function create($userId, callable $onSuccess): Form
	{
		$form = $this->factory->create();
		$form->addText('title', 'Title:')
            ->setRequired();
        $form->addTextArea('content', 'Body:')
            ->setRequired();
        $form->addHidden('user_id', $userId);

        $form->addSubmit('send', 'Save');
        $form->onSuccess[] = function (Form $form, \stdClass $data) use ($onSuccess): void {
            try {
				$insertData = [
                    'title' => $data->title,
                    'content' => $data->content,
                    'user_id' => $data->user_id,
                ];
        
                $this->postFacade->insertPost($insertData);
			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('Incorect input.');
				return;
			}
			$onSuccess();
		};

		return $form;
        

	}
}