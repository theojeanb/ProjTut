<?php

namespace App\DataFixtures;

use App\Entity\Equipement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Arme;
use App\Entity\Armure;
use App\Entity\Ennemi;
use App\Entity\Potion;
use App\Entity\Type;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $n = "7641743792047461691217802962928255710667124601088812189826971421203703652459726180054553349532686870856113940361566037662823365406366891324331269682419503804747539182226267593041803999070468662354229333249901475561597088977648720437559994785606812947823468162276323622913127207617617106693070686060263";
    private $c = "961";

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadTypes($manager);
        $this->loadArmes($manager);
        $this->loadArmures($manager);
        $this->loadEnnemis($manager);
        $this->loadPotions($manager);
        $this->loadUsers($manager);
    }

    private function loadTypes(ObjectManager $manager)
    {
        $types = [
            ['id' => 1, 'nom' => 'Casque'],
            ['id' => 2, 'nom' => 'Plastron'],
            ['id' => 3, 'nom' => 'Jambieres'],
            ['id' => 4, 'nom' => 'Chaussures']
        ];
        foreach ($types as $type) {
            $type_new = new Type();
            $type_new->setNom($type['nom']);
            $manager->persist($type_new);
            $manager->flush();
        }
    }

    private function loadArmes(ObjectManager $manager)
    {
        $armes = [
            ['id' => 1, 'nom' => 'Master Sword', 'degats' => 300, 'rarete' => 4,'sprite'=> 'epee.png','prix'=>'999'],
            ['id' => 2, 'nom' => 'Masamune', 'degats' => 200, 'rarete' => 3,'sprite'=> 'masamune.png','prix'=>'666'],
            ['id' => 3, 'nom' => 'Buster Sword', 'degats' => 200, 'rarete' => 3,'sprite'=> 'epeeEnchant.png','prix'=>'555'],
            ['id' => 4, 'nom' => 'Monado', 'degats' => 100, 'rarete' => 2,'sprite'=> 'monado.png','prix'=>'50']
        ];
        foreach ($armes as $arme) {
            $arme_new = new Arme();
            $arme_new->setNom($arme['nom']);
            $arme_new->setDegats($arme['degats']);
            $arme_new->setRarete($arme['rarete']);
            $arme_new->setSprite($arme['sprite']);
            $arme_new->setPrix($arme['prix']);
            $manager->persist($arme_new);
            $manager->flush();
        }
    }

    private function loadArmures(ObjectManager $manager)
    {
        $armures = [
            ['id' => 1, 'nom' => 'Thunder Helmet', 'defense' => 10, 'rarete' => 2, 'type' => 'Casque','sprite'=> 'casque.png','prix'=>'120'],
            ['id' => 2, 'nom' => 'Magic Armor', 'defense' => 500, 'rarete' => 4, 'type' => 'Plastron','sprite'=> 'plastronR.png','prix'=>'90'],
            ['id' => 3, 'nom' => 'SPEEEED', 'defense' => 50, 'rarete' => 3, 'type' => 'Jambières','sprite'=> 'jambières.png','prix'=>'95'],
            ['id' => 4, 'nom' => 'Crocs', 'defense' => 30, 'rarete' => 1, 'type' => 'Chaussures','sprite'=> 'botte.png','prix'=>'60']
        ];
        foreach ($armures as $armure) {
            $armure_new = new Armure();
            $armure_new->setNom($armure['nom']);
            $armure_new->setDefense($armure['defense']);
            $armure_new->setRarete($armure['rarete']);
            $armure_new->setSprite($armure['sprite']);
            $armure_new->setPrix($armure['prix']);
            $type = $manager->getRepository(Type::class)->findOneBy(["nom" => $armure['type']]);
            $armure_new->setType($type);
            $manager->persist($armure_new);
            $manager->flush();
        }
    }

    private function loadEnnemis(ObjectManager $manager)
    {
        $ennemis = [
            ['id' => 1, 'nom' => 'Gobelin', 'degats' => 10, 'pv' => 5, 'sprite' => ''],
            ['id' => 2, 'nom' => 'Koopa', 'degats' => 20, 'pv' => 10, 'sprite' => ''],
            ['id' => 3, 'nom' => 'Sephiroth', 'degats' => 100, 'pv' => 3000, 'sprite' => ''],
            ['id' => 4, 'nom' => 'NOAH', 'degats' => 30000, 'pv' => 99999, 'sprite' => 'noah.png']
        ];
        foreach ($ennemis as $ennemi) {
            $ennemi_new = new Ennemi();
            $ennemi_new->setNom($ennemi['nom']);
            $ennemi_new->setDegats($ennemi['degats']);
            $ennemi_new->setPv($ennemi['pv']);
            $ennemi_new->setSprite($ennemi['sprite']);
            $manager->persist($ennemi_new);
            $manager->flush();
        }
    }

    private function loadPotions(ObjectManager $manager)
    {
        $potions = [
            ['id' => 1, 'nom' => 'Potion de rapidité', 'effet' => 'SPEED', 'valeur' => 50, 'rarete' => 3,'sprite'=> 'potionRapidite.png','prix'=>'45'],
            ['id' => 2, 'nom' => 'Potion de force', 'effet' => 'STRENGTH', 'valeur' => 50, 'rarete' => 3,'sprite'=> 'potionForce.png','prix'=>'85'],
            ['id' => 3, 'nom' => 'Potion de régénération', 'effet' => 'HP', 'valeur' => 30, 'rarete' => 3,'sprite'=> 'potion.png','prix'=>'60'],
            ['id' => 4, 'nom' => 'Potion de renforcement', 'effet' => 'HPMAX', 'valeur' => 5, 'rarete' => 3,'sprite'=> 'potionV.png','prix'=>'50']
        ];
        foreach ($potions as $potion) {
            $potion_new = new Potion();
            $potion_new->setNom($potion['nom']);
            $potion_new->setEffet($potion['effet']);
            $potion_new->setSprite($potion['sprite']);
            $potion_new->setValeur($potion['valeur']);
            $potion_new->setRarete($potion['rarete']);
            $potion_new->setPrix($potion['prix']);
            $manager->persist($potion_new);
            $manager->flush();
        }
    }


    public function loadUsers(ObjectManager $manager)
    {
        $equipementAdmin = new Equipement();
        $manager->persist($equipementAdmin);
        $admin = new User();
        $password = $this->cryptRSA('admin');
        $admin->setPassword($password);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setEmail('admin');
        $admin->setAttaque(10);
        $admin->setDefense(10);
        $admin->setArgent(1000);
        $admin->setPvMax(100);
        $admin->setPv(100);
        $admin->setNiveau(1);
        $admin->setExperience(0);
        $admin->setEquipement($equipementAdmin);
        $manager->persist($admin);

        $equipementUser = new Equipement();
        $manager->persist($equipementUser);
        $user1 = new User();
        $password = $this->cryptRSA('user');
        $user1->setPassword($password);
        $user1->setRoles(['ROLE_USER']);
        $user1->setUsername('user');
        $user1->setEmail('user');
        $user1->setAttaque(10);
        $user1->setDefense(10);
        $user1->setArgent(10000);
        $user1->setPvMax(100);
        $user1->setPv(100);
        $user1->setNiveau(1);
        $user1->setExperience(0);
        $user1->setEquipement($equipementUser);
        $manager->persist($user1);


        $manager->flush();
    }

    public function cryptRSA($arraypassword) {
        $array = str_split($arraypassword);
        $password = "";
        foreach($array as $char) {
            $password .= sprintf("%03d", ord($char));
        }
        $password = bcpowmod($password, $this->c, $this->n);
        return $password;
    }
}