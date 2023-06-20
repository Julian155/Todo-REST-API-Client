<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\TodoEntryForm;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoEntryApiController extends AbstractController
{
    protected const API_ROUTE_TODO_ENTRY = 'http://api:5001/entry/%s';
    protected const API_ROUTE_ADD_TODO_ENTRY = 'http://api:5001/todo-list/%s/entry';

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
        '/entry/add/{todoListId}',
        name: 'addTodoListEntry'
    )]
    public function addTodoListEntry(Request $request, string $todoListId): Response
    {
        $form = $this->createForm(TodoEntryForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoEntryData = $form->getData();

            $response = $this->guzzleClient->post(
                $this->buildTodoEntryRoute(
                    static::API_ROUTE_ADD_TODO_ENTRY,
                    $todoListId
                ),
                [
                    RequestOptions::JSON => $todoEntryData,
                ]
            );

            return $this->redirect('/todoLists');
        }

        return $this->render(
            'create-todo-entry.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route(
        '/entry/update/{todoEntryId}',
        name: 'updateTodoEntry'
    )]
    public function updateTodoEntry(Request $request, string $todoEntryId): Response
    {
        $form = $this->createForm(TodoEntryForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoEntryData = $form->getData();

            $response = $this->guzzleClient->patch(
                $this->buildTodoEntryRoute(
                    static::API_ROUTE_TODO_ENTRY,
                    $todoEntryId
                ),
                [
                    RequestOptions::JSON => $todoEntryData,
                ]
            );

            return $this->redirect('/todoLists');
        }

        return $this->render(
            'edit-todo-entry.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route(
        '/entry/delete/{todoEntryId}',
        name: 'deleteTodoEntry'
    )]
    public function deleteTodoEntry(Request $request, string $todoEntryId): Response
    {
        $response = $this->guzzleClient->delete(
            $this->buildTodoEntryRoute(
                static::API_ROUTE_TODO_ENTRY,
                $todoEntryId
            ),
        );

        return $this->redirect('/todoLists');
    }

    /**
     * @param string $route
     * @param string $routeData
     *
     * @return string
     */
    protected function buildTodoEntryRoute(string $route, string $routeData = ''): string
    {
        return sprintf(
            $route,
            $routeData
        );
    }
}
