<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Vendors;


class VendorController extends AbstractController
{
    /**
     * @Route("/vendor", name="app_vendor")
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()
            ->getRepository(Vendors::class)
            ->findAll();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'username' => $product->getUsername(),
            ];
        }


        return $this->json($data);
    }

    /**
     * @Route("/vendor", name="vendor_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $project = new Client();
        $project->setUsername($request->request->get('username'));

        $entityManager->persist($project);
        $entityManager->flush();

        return $this->json('Created new project successfully with id ' . $project->getId());
    }

    /**
     * @Route("/vendor/{id}", name="vendor_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $project = $this->getDoctrine()
            ->getRepository(Vendors::class)
            ->find($id);

        if (!$project) {

            return $this->json('No project found for id' . $id, 404);
        }

        $data =  [
            'id' => $project->getId(),
            'name' => $project->getUsername(),
        ];

        return $this->json($data);
    }

    /**
     * @Route("/vendor/{id}", name="vendor_edit", methods={"PUT"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository(Vendors::class)->find($id);

        if (!$project) {
            return $this->json('No project found for id' . $id, 404);
        }

        $project->setUsername($request->request->get('name'));
        $entityManager->flush();

        $data =  [
            'id' => $project->getId(),
            'name' => $project->getUsername(),
        ];

        return $this->json($data);
    }

    /**
     * @Route("/vendor/{id}", name="vendor_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository(Vendors::class)->find($id);

        if (!$project) {
            return $this->json('No project found for id' . $id, 404);
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->json('Deleted a project successfully with id ' . $id);
    }
}
