<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms;
use App\Model\PostFacade;
use App\Model\CommentFacade;
use Nette;
use Nette\Application\UI\Form;


final class PostPresenter extends BasePresenter
{
    private const PER_PAGE = 10;

    use RequireLoggedUser;

    public $onChange =  [];

    public function __construct(
        private PostFacade $postFacade,
        private CommentFacade $commentFacade,
        private Forms\PostFormFactory $postFactory,
        private Forms\CommentFormFactory $commentFactory,
    ) {

    }

    public function renderIndex(int $page = 1): void
    {
        $this->template->posts = $this->postFacade
            ->getPosts();
        $lastPage = 0;
        $this->template->posts = $this->template->posts->page($page, self::PER_PAGE, $lastPage);

        $this->template->page = $page;
        $this->template->lastPage = $lastPage;
    }

    public function renderShow(int $id): void
    {
        $this->template->post = $this->postFacade
            ->getPost($id);
        if ($this->template->post === null) {
            $this->error();
        }

        $this->template->user = $this->getUser()->getId();
        $this->template->comments = $this->template->post->related('comments')->order('created_at');
        $this->template->commentsCount = $this->template->comments->count('*');
    }

    protected function createComponentCommentForm(): Form
    {
        // return $this->signInFactory->create();
        $postId = $this->getParameter('id');
        
        return $this->commentFactory->create($this->getUser()->getId(), $postId, function (): void {
			$this->redrawControl('comments');			
		});
    }

    public function commentFormSucceeded(\stdClass $data): void
    {
        $postId = $this->getParameter('id');

        $insertData = [
            'post_id' => $postId,
            'user_id' => $this->getUser()->getId(),
            'content' => $data->content
        ];

        $this->commentFacade->insertComment($insertData);

        $this->flashMessage('Comment sent', 'success');
        $this->redrawControl('comments');
    }

    protected function createComponentPostForm(): Form
    {
        return $this->postFactory->create($this->getUser()->getId(), function (): void {
			// $this->restoreRequest($this->backlink);
			$this->redirect('Post:index');			
		});

        // return $form;
    }

    // public function postFormSucceeded(\stdClass $data): void
    // {
    //     $insertData = [
    //         'title' => $data->title,
    //         'content' => $data->content,
    //         'user_id' => $this->getUser()->getId(),
    //     ];

    //     $this->postFacade->insertPost($insertData);

    //     $this->flashMessage('Post published.', 'success');
    //     $this->redirect('Post:index');
    // }

}
