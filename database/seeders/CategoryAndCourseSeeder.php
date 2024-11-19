<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Course;

class CategoryAndCourseSeeder extends Seeder
{
    public function run()
    {
        // Criando as categorias relacionadas à programação
        $categories = [
            [
                'name' => 'Desenvolvimento Web',
                'description' => 'Cursos sobre criação de sites e aplicações web.',
                'courses' => [
                    'HTML e CSS para Iniciantes',
                    'JavaScript Moderno: ES6+',
                    'Construindo APIs com Laravel',
                    'React.js: Desenvolvimento de Interfaces',
                ]
            ],
            [
                'name' => 'Desenvolvimento Mobile',
                'description' => 'Cursos sobre desenvolvimento de aplicativos móveis.',
                'courses' => [
                    'Introdução ao Flutter',
                    'Criando Apps Nativos com Kotlin',
                    'Swift para iOS: Do Básico ao Avançado',
                    'React Native: Aplicativos Multi-Plataforma',
                ]
            ],
            [
                'name' => 'Banco de Dados',
                'description' => 'Cursos sobre gerenciamento e design de bancos de dados.',
                'courses' => [
                    'SQL Básico e Avançado',
                    'Modelagem de Dados Relacional',
                    'MongoDB para Iniciantes',
                    'Otimização de Consultas em MySQL',
                ]
            ],
            [
                'name' => 'Inteligência Artificial',
                'description' => 'Cursos sobre aprendizado de máquina e IA.',
                'courses' => [
                    'Introdução ao Machine Learning com Python',
                    'Deep Learning com TensorFlow',
                    'Chatbots com IA e NLP',
                    'Visão Computacional: Teoria e Prática',
                ]
            ],
            [
                'name' => 'Segurança da Informação',
                'description' => 'Cursos sobre proteção de sistemas e dados.',
                'courses' => [
                    'Segurança em Redes de Computadores',
                    'Criptografia na Prática',
                    'Testes de Penetração com Kali Linux',
                    'Segurança para Aplicações Web',
                ]
            ]
        ];

        // Criando as categorias e cursos no banco
        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['name' => $categoryData['name']],
                [
                    'slug' => Str::slug($categoryData['name']),
                    'description' => $categoryData['description'],
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Criando cursos reais para cada categoria
            foreach ($categoryData['courses'] as $courseTitle) {
                Course::firstOrCreate(
                    ['title' => $courseTitle],
                    [
                        'category_id' => $category->id,
                        'is_active' => 1,
                        'description' => "Descrição do curso: $courseTitle.",
                        'photo' => Str::slug($courseTitle) . '.jpg',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
