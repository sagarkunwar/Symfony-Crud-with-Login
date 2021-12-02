<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Form\TaskType;
use Knp\Component\Pager\PaginatorInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();
        $id = $user->getId();
        $data = $this->getDoctrine()->getRepository(Task::class)->findByID($id);
        $result = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3),
        );
        return $this->render('main/index.html.twig', [
            'add' => $result
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $user = $this->getUser();

            $task->setUserID($user);
            // $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            $this->addFlash('notice', 'Sucesssfully inserted');
        }
        return $this->render('main/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="task_delete")
     */

    public function delete($id)
    {
        $data = $this->getDoctrine()->getRepository(Task::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        $this->addFlash('notice', 'Deleted Successfully');


        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/update/{id}", name="task_update")
     */

    public function update(Request $request, $id)
    {
        $task = $this->getDoctrine()->getRepository(Task::class)->find($id);
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            $this->addFlash('notice', 'Update inserted');
        }
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/try", name="try")
     */
    public function try()
    {
        $user = $this->getUser();
        dd($user);
        $id = $user->getId();
        $data = $this->getDoctrine()->getRepository(Task::class)->findBy(['userid' => $id]);
        dd($data);
    }

    /**
     * @Route("/join", name="join")
     */
    public function leftJoin(Request $request, PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();
        $id = $user->getId();
        $data = $this->getDoctrine()->getRepository(Task::class)->leftJoin($id);

        $result = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3),
        );
        return $this->render('Join.html.twig', [
            'Join' => $result
        ]);
    }
}
