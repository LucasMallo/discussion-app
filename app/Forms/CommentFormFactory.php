<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model\CommentFacade;
use Nette;
use Nette\Application\UI\Form;


final class CommentFormFactory
{
	use Nette\SmartObject;

	public function __construct(
        private FormFactory $factory,
        private CommentFacade $commentFacade,
    ) {

	}


	public function create($userId, $postId, callable $onSuccess): Form
	{
		$form = $this->factory->create();
        $form->addTextArea('content', 'Comment:')
            ->setRequired();
        $form->addHidden('user_id', $userId);
        $form->addHidden('post_id', $postId);

        $form->addSubmit('send', 'Save');
        $form->onSuccess[] = function (Form $form, \stdClass $data) use ($onSuccess): void {
            try {
				$insertData = [
                    'content' => $data->content,
                    'user_id' => $data->user_id,
                    'post_id' => $data->post_id,
                ];
        
                $this->commentFacade->insertComment($insertData);
			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('Incorect input.');
				return;
			}
			$onSuccess();
		};

		return $form;
        

	}
}