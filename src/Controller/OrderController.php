<?php

namespace App\Controller;

use App\Entity\OrderProduct;
use App\Entity\OrderStatus;
use App\Repository\CategoryRepository;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
        	'orders' => $orderRepository->findAll()
		]);
    }

	#[Route('/order/{id}/edit', name: 'app_order_edit')]
	public function edit(OrderRepository $orderRepository, CategoryRepository $categoryRepository, ProductRepository $productRepository,
						 int $id) {
		$order = $orderRepository->find($id);
		if($order->getStatus() == OrderStatus::NEW) $order->setStatus(OrderStatus::PENDING);

		$products = $productRepository->findProductsInOrder($orderRepository->find($id));

		$total = 0;
		foreach ($products as $product) {
			$total += $product[0]->getPrice() * $product['quantity'];
		}

		return $this->render('order/edit.html.twig', [
			'order' => $order,
			'orderProducts' => $products,
			'categories' => $categoryRepository->findAll(),
			'total' => $total
		]);
	}

	#[Route('/order/{id}/add-product/{productId}', name: 'app_order_add_product')]
	public function addProduct(OrderRepository $orderRepository, OrderProductRepository $orderProductRepository,
							   ProductRepository $productRepository, EntityManagerInterface $manager,
							   int $id, int $productId)
	{
		$order = $orderRepository->find($id);

		// Add product to order
		$orderProduct = $orderProductRepository->findProductsQuantity($id, $productId);
		if(!is_null($orderProduct))
		{
			$orderProduct = $orderProductRepository->findOneBy(['orderLine' => $id, 'product' => $productId]);
			$orderProduct->setQuantity($orderProduct->getQuantity() + 1);
		}
		else
		{
			$orderProduct = new OrderProduct();
			$orderProduct->setOrderLine($order);
			$orderProduct->setProduct($productRepository->find($productId));
			$orderProduct->setQuantity(1);
		}

		$manager->persist($orderProduct);
		$manager->flush();

		return $this->redirectToRoute('app_order_edit', ['id' => $id]);
	}

	#[Route('/order/{id}/close', name: 'app_order_close')]
	public function closeOrder(OrderRepository $orderRepository, EntityManagerInterface $manager, int $id) {
		$order = $orderRepository->find($id);
		$order->setStatus(OrderStatus::FINISHED);

		$manager->persist($order);
		$manager->flush();

		return $this->redirectToRoute('app_order');
	}
}
