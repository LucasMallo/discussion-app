<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms;
use Nette;
use Nette\Application\UI\Form;


final class SignPresenter extends BasePresenter
{

	/** @persistent */
	public string $backlink = '';

	private Forms\SignInFormFactory $signInFactory;


	public function __construct(Forms\SignInFormFactory $signInFactory)
	{
		$this->signInFactory = $signInFactory;
	}


	/**
	 * Sign-in form factory.
	 */
	protected function createComponentSignInForm(): Form
	{
		return $this->signInFactory->create(function (): void {
			$this->restoreRequest($this->backlink);
			$this->redirect('Post:index');			
		});
	}

	public function actionOut(): void
	{
		$this->getUser()->logout();
	}
}