<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Orders;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order_index", methods={"GET"})
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()
            ->getRepository(Orders::class)
            ->findAll();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'date' => $product->getName(),
                'products' => $product->getProducts(),
                'sum' => $product->getSum(),
            ];
        }


        return $this->json($data);
    }

    /**
     * @Route("/order", name="order_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $project = new Orders();
        $project->setDate($request->request->get('date'));
        $project->setProducts($request->request->get('products'));
        $project->setSum($request->request->get('sum'));

        $entityManager->persist($project);
        $entityManager->flush();

        return $this->json('Created new project successfully with id ' . $project->getId());
    }

    /**
     * @Route("/order/{id}", name="order_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $project = $this->getDoctrine()
            ->getRepository(Orders::class)
            ->find($id);

        if (!$project) {

            return $this->json('No project found for id' . $id, 404);
        }

        $data =  [
            'id' => $project->getId(),
            'products' => $project->getProducts(),
            'price' => $project->getPrice(),
        ];

        return $this->json($data);
    }

    /**
     * @Route("/order/{id}", name="order_edit", methods={"PUT"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository(Orders::class)->find($id);

        if (!$project) {
            return $this->json('No project found for id' . $id, 404);
        }

        $project->setName($request->request->get('name'));
        $project->setDescription($request->request->get('description'));
        $entityManager->flush();

        $data =  [
            'id' => $project->getId(),
            'products' => $project->getProducts(),
            'price' => $project->getPrice(),
        ];

        return $this->json($data);
    }

    /**
     * @Route("/order/{id}", name="order_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository(Orders::class)->find($id);

        if (!$project) {
            return $this->json('No project found for id' . $id, 404);
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->json('Deleted a project successfully with id ' . $id);
    }
}
