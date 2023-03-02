<?php

namespace App\Controller;


use App\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\HotelRepository;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Config\Framework\RequestConfig;


class ApiPostController extends AbstractController
{
    #[Route('/api/hotel', name: 'app_api_post_index', methods: ["GET"])]
    public function index(HotelRepository  $hotelRepository ): Response
    {
        return $this->json($hotelRepository->findAll(), 200, [], ['groups' =>'hotel:read']);
    }

    #[Route('/api/hotel', name: 'app_api_post_create', methods: ["POST"])]
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator){
        $jsonGet = $request->getContent();
        try {
            $hotel = $serializer->deserialize($jsonGet, Hotel::class,'json');

            $errors = $validator->validate($hotel);
            if (count($errors) > 0){
                return $this -> json($errors, 400);
            }
            $em ->persist($hotel);
            $em -> flush();

            return $this->json($hotel, 201,[],['groups' =>'hotel:read']);
        }
        catch (NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ],400);
        }

    }
}
