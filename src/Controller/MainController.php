<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Form\TaskType;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $id = $user->getId();
        $data = $this->getDoctrine()->getRepository(Task::class)->findBy(['userid' => $id]);
        return $this->render('main/index.html.twig', [
            'add' => $data
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
            $id = $user->getId();
            $task->setUserID($id);
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
        return $this->render('main/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/try", name="try")
     */
    public function try()
    {
        $user = $this->getUser();
        $id = $user->getId();
        $data = $this->getDoctrine()->getRepository(Task::class)->findBy(['userid' => $id]);

        dd($data);
    }
}
