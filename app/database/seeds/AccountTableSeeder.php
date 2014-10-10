<?php

class AccountTableSeeder extends DatabaseSeeder {

    public function run() {

        $faker = $this->getFaker();

        for ($i = 0; $i < 500; $i++) {

            $identity = rand(0, 1);
            $firstname = ucwords($faker->word);
            $lastname = ucwords($faker->word);
            $email = $faker->email;
            $password = Hash::make("twomix");
            $tel = $faker->randomNumber(8);
            $permission = 3;
            $last_seen = $faker->iso8601;
            
            if ($identity == 1) {
                $cell_tel = $faker->randomNumber(8);
                $rating = rand(1, 5);
                $company = $faker->text(5);
                $license = ucwords($faker->word);
                $description = $faker->text(100);
                $template = $faker->text(100);
            } else {
                $cell_tel = null;
                $rating = null;
                $company = null;
                $license = null;
                $description = null;
                $template = null;
            }


            Account::create([
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email,
                "identity" => $identity,
                "password" => $password,
                "tel" => $tel,
                "last_seen" => $last_seen,
                "cell_tel" => $cell_tel,
                "rating" => $rating,
                "company" => $company,
                "license" => $license,
                "description" => $description,
                "template" => $template,
                "permission" => $permission
            ]);
            
         
            
        }
    }

}
