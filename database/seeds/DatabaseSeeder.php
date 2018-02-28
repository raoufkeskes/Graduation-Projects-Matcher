<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/*Licence*/
         DB::table('Specialite')->insert([
            'spec' => "ISIL" ,
            'niveau' => "Licence" ,
            'label' =>"Ingénierie des Systèmes d’Information et des Logiciels" ,
        ]);

         DB::table('Specialite')->insert([
            'spec' => "ACAD" ,
            'niveau' => "Licence" ,
            'label' =>"Informatique Académique" ,
        ]);

         DB::table('Specialite')->insert([
            'spec' => "GTR" ,
            'niveau' => "Licence" ,
            'label' =>"Génie des Télécommunications et Réseaux" ,
        ]);
        /* End Licence*/

        /*Master*/
        DB::table('Specialite')->insert([
            'spec' => "RSD" ,
            'niveau' => "Master" ,
            'label' =>"Réseaux et Systèmes Distribués" ,
        ]);

         DB::table('Specialite')->insert([
            'spec' => "IL" ,
            'niveau' => "Master" ,
            'label' =>"Ingénierie du Logiciel" ,
        ]);

         DB::table('Specialite')->insert([
            'spec' => "SII" ,
            'niveau' => "Master" ,
            'label' =>"Systèmes Informatiques Intelligents" ,
        ]);
         DB::table('Specialite')->insert([
            'spec' => "SSI" ,
            'niveau' => "Master" ,
            'label' =>"Sécurité des Systèmes Informatiques" ,
        ]);

         DB::table('Specialite')->insert([
            'spec' => "APCI" ,
            'niveau' => "Master" ,
            'label' =>"Architectures Parallèles et Calcul Intensif" ,
        ]);

         DB::table('Specialite')->insert([
            'spec' => "MIND" ,
            'niveau' => "Master" ,
            'label' =>"Mathématiques et Informatique Décisionnelle" ,
        ]);

         DB::table('Specialite')->insert([
            'spec' => "INFVIS" ,
            'niveau' => "Master" ,
            'label' =>"Master Informatique Visuelle" ,
        ]);

       


       

         DB::table('annee_universitaire')->insert([
            'annee' => "L1" 
        ]);

         DB::table('annee_universitaire')->insert([
            'annee' => "L2" 
        ]);

         DB::table('annee_universitaire')->insert([
            'annee' => "L3" 
        ]);

         DB::table('annee_universitaire')->insert([
            'annee' => "M1" 
        ]);


    }
}
