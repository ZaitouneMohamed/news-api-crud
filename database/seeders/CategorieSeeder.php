<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Actualités',
                'children' => [
                    ['name' => 'Politique'],
                    ['name' => 'Économie'],
                    ['name' => 'Sport'],
                ]
            ],
            [
                'name' => 'Divertissement',
                'children' => [
                    ['name' => 'Cinéma'],
                    ['name' => 'Musique'],
                    ['name' => 'Sorties'],
                ]
            ],
            [
                'name' => 'Technologie',
                'children' => [
                    [
                        'name' => 'Informatique',
                        'children' => [
                            ['name' => 'Ordinateurs de bureau'],
                            ['name' => 'PC portable'],
                            ['name' => 'Connexion internet'],
                        ]
                    ],
                    [
                        'name' => 'Gadgets',
                        'children' => [
                            ['name' => 'Smartphones'],
                            ['name' => 'Tablettes'],
                            ['name' => 'Jeux vidéo'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Santé',
                'children' => [
                    ['name' => 'Médecine'],
                    ['name' => 'Bien-être'],
                ]
            ],
        ];

        // Recursive function to seed categories and their children
        $this->seedCategories($categories, null);
    }

    private function seedCategories($categories, $parentCategory)
    {
        foreach ($categories as $categoryData) {
            $categorie = new Categorie(['name' => $categoryData['name']]);
            if ($parentCategory !== null) {
                $categorie->parent()->associate($parentCategory);
            }
            $categorie->save();

            if (isset($categoryData['children'])) {
                $this->seedCategories($categoryData['children'], $categorie);
            }
        }
    }
}
