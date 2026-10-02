<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class FeaturedProjectsSeeder extends Seeder
{
    public function run(): void
    {
        Project::updateOrCreate(
            ['title' => 'IDA Cours'],
            [
                'description' => 'IDA Cours est un projet réalisé par Seydou Bakhayokho, étudiant développeur en informatique. Découvrez son travail sur la plateforme en ligne.',
                'domain' => 'Éducation & formation',
                'technologies' => 'Plateforme web',
                'image_path' => 'images/projects/ida-cours.svg',
                'author_name' => 'Seydou Bakhayokho — Étudiant développeur en informatique',
                'demo_url' => 'https://ida-cours.site/',
                'is_featured' => true,
                'is_approved' => true,
            ],
        );

        Project::updateOrCreate(
            ['title' => 'Le Poulailler'],
            [
                'description' => 'Le Poulailler est un projet réalisé par Seydou Bakhayokho pour faciliter la gestion d’un élevage : suivi des poussins et des produits, ainsi que le suivi des dépenses et des recettes.',
                'domain' => 'Agriculture & gestion',
                'technologies' => 'Application web de gestion',
                'image_path' => 'images/projects/le-poulailler.svg',
                'author_name' => 'Seydou Bakhayokho',
                'demo_url' => 'https://le-poulailler-h648.vercel.app/',
                'is_featured' => true,
                'is_approved' => true,
            ],
        );
    }
}
