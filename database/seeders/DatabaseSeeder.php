<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/*
    Seeder principal
    
    Ce fichier crée les données de départ dans la base de données.
    On l'exécute une fois avec : php artisan db:seed
*/
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer le compte admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        echo "✅ Compte admin créé (admin@admin.com / password)\n";

        // Créer quelques catégories
        $categories = [
            ['name' => 'Électronique', 'description' => 'Appareils électroniques'],
            ['name' => 'Vêtements', 'description' => 'Habits et accessoires'],
            ['name' => 'Alimentation', 'description' => 'Produits alimentaires'],
            ['name' => 'Maison', 'description' => 'Produits pour la maison'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        echo "✅ 4 catégories créées\n";

        // Créer quelques fournisseurs
        $suppliers = [
            ['name' => 'TechSupply', 'email' => 'contact@techsupply.com', 'phone' => '01 23 45 67 89'],
            ['name' => 'FashionPro', 'email' => 'info@fashionpro.com', 'phone' => '01 98 76 54 32'],
        ];

        foreach ($suppliers as $sup) {
            Supplier::create($sup);
        }

        echo "✅ 2 fournisseurs créés\n";

        // Créer quelques produits
        $products = [
            ['name' => 'iPhone 15', 'sku' => 'IPHONE15', 'category_id' => 1, 'supplier_id' => 1, 'purchase_price' => 800, 'selling_price' => 999, 'quantity' => 25, 'min_quantity' => 5],
            ['name' => 'MacBook Pro', 'sku' => 'MACBOOK', 'category_id' => 1, 'supplier_id' => 1, 'purchase_price' => 1500, 'selling_price' => 1999, 'quantity' => 10, 'min_quantity' => 3],
            ['name' => 'T-Shirt Blanc', 'sku' => 'TSHIRT-W', 'category_id' => 2, 'supplier_id' => 2, 'purchase_price' => 5, 'selling_price' => 15, 'quantity' => 100, 'min_quantity' => 20],
            ['name' => 'Jean Slim', 'sku' => 'JEAN-SLIM', 'category_id' => 2, 'supplier_id' => 2, 'purchase_price' => 20, 'selling_price' => 45, 'quantity' => 50, 'min_quantity' => 10],
            ['name' => 'Café Premium', 'sku' => 'CAFE-P', 'category_id' => 3, 'supplier_id' => null, 'purchase_price' => 8, 'selling_price' => 12, 'quantity' => 3, 'min_quantity' => 10], // Stock faible !
            ['name' => 'Lampe LED', 'sku' => 'LAMP-LED', 'category_id' => 4, 'supplier_id' => null, 'purchase_price' => 15, 'selling_price' => 25, 'quantity' => 30, 'min_quantity' => 5],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }

        echo "✅ 6 produits créés\n";
        echo "\n🎉 Base de données prête ! Connectez-vous avec admin@admin.com / password\n";
    }
}
