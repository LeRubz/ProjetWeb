<?php
namespace App\Controllers;

use App\Models\Wishlist;
use Twig\Environment;

class WishlistController extends Controller
{
    public function __construct(Environment $templateengine)
    {
        parent::__construct($templateengine, new Wishlist());
    }

    public function WishlistPage()
    {
        $wishlist = $this->model1->getAll();
        $this->render('wishlist.html.twig', ['wishlist' => $wishlist]);
    }
}
