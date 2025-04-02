<?php
namespace App\Models;

class Wishlist
{
    private array $wishlist = [
        [
            'id_offer' => 1,
            'titre' => 'Développeur Web chez Super U',
            'description' => 'Stage développement web front-end avec React.',
            'logo' => 'images/superU.png'
        ],
        [
            'id_offer' => 2,
            'titre' => 'Assistant RH chez Azaé',
            'description' => 'Stage dans le service des ressources humaines.',
            'logo' => 'images/azae.png'
        ]
    ];

    public function getAll(): array
    {
        return $this->wishlist;
    }
}
