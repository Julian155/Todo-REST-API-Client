<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\TodoListForm;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoListApiController extends AbstractController
{
    protected const API_ROUTE_TODO_LIST = 'http://api:5001/todo-list';

    /**
     * @var \GuzzleHttp\Client
     */
    private Client $guzzleClient;

    /**
     * @param \GuzzleHttp\Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    #[Route(
        '/todoLists',
        name: 'getAllTodoLists'
    )]
    public function getAllTodoLists(Request $request): Response
    {
        $response = $this->guzzleClient->get(
            $this->buildTodoListRoute(),
            ['content-type' => 'application/json']
        );

        $decodedTodoListsResponse = json_decode($response->getBody()->getContents(), true);

        $todoLists = $decodedTodoListsResponse['lists'] ?? [];

        return $this->render('todo-lists.twig', [
            'todoLists' => $todoLists
        ]);
    }

    #[Route(
        '/todoList/update/{todoListId}',
        name: 'updateTodoList',
    )]
    public function updateTodoList(Request $request, string $todoListId): Response
    {
        $form = $this->createForm(TodoListForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoListData = $form->getData();

            $response = $this->guzzleClient->patch(
                $this->buildTodoListRoute(DIRECTORY_SEPARATOR.$todoListId),
                [
                    RequestOptions::JSON => $todoListData,
                ]
            );

            return $this->redirect('/todoLists');
        }

        return $this->render(
            'edit-todo-list.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route(
        '/todoList/create',
        name: 'createTodoList',
    )]
    public function createTodoList(Request $request): Response
    {
        $form = $this->createForm(TodoListForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoListData = $form->getData();

            $response = $this->guzzleClient->post(
                $this->buildTodoListRoute(),
                [
                    RequestOptions::JSON => $todoListData,
                ]
            );

            return $this->redirect('/todoLists');
        }

        return $this->render(
            'create-todo-list.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route(
        '/todoList/delete/{todoListId}',
        name: 'deleteTodoList',
    )]
    public function deleteTodoList(string $todoListId): Response
    {
        $response = $this->guzzleClient->delete(
            $this->buildTodoListRoute(DIRECTORY_SEPARATOR.$todoListId),
        );

        return $this->redirect('/todoLists');
    }

    #[Route(
        '/todoList/{todoListId}',
        name: 'getTodoListEntries',
    )]
    public function getTodoListEntries(string $todoListId): Response
    {
        $response = $this->guzzleClient->get(
            $this->buildTodoListRoute(DIRECTORY_SEPARATOR.$todoListId),
            ['content-type' => 'application/json']
        );

        $decodedTodoListEntriesResponse = json_decode($response->getBody()->getContents(), true);

        $todoEntries = $decodedTodoListEntriesResponse['entries'] ?? [];

        return $this->render('todo-entries.twig', [
            'todoEntries' => $todoEntries
        ]);
    }

    /**
     * @param string $routeData
     *
     * @return string
     */
    protected function buildTodoListRoute(string $routeData = ''): string
    {
        return sprintf(
            '%s%s',
            static::API_ROUTE_TODO_LIST,
            $routeData
        );
    }
}
