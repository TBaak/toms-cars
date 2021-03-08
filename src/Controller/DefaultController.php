<?php


namespace App\Controller;


use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(){

       return $this->render('index.html.twig');
    }

    /**
     * @Route("/cars", name="cars")
     */
    public function home(){

        $cars = $this->getDoctrine()->getRepository(Car::class)->findAll();

        return $this->render('carlist.html.twig', [
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/cars/info/{slug}", name="car-info")
     */
    public function carInfo($slug){

        $car = $this->getDoctrine()->getRepository(Car::class)->findOneBy([
            'slug' => $slug
        ]);

        return $this->render('carinfo.html.twig', [
            'car' => $car
        ]);
    }

}