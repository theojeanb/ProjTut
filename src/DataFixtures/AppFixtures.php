<?php

namespace App\DataFixtures;

use App\Entity\Perso;
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
            ['id' => 3, 'nom' => 'Jambières'],
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
            ['id' => 1, 'nom' => 'Master Sword', 'degats' => 300, 'rarete' => 4],
            ['id' => 2, 'nom' => 'Masamune', 'degats' => 200, 'rarete' => 3],
            ['id' => 3, 'nom' => 'Buster Sword', 'degats' => 200, 'rarete' => 3],
            ['id' => 4, 'nom' => 'Monado', 'degats' => 100, 'rarete' => 2]
        ];
        foreach ($armes as $arme) {
            $arme_new = new Arme();
            $arme_new->setNom($arme['nom']);
            $arme_new->setDegats($arme['degats']);
            $arme_new->setRarete($arme['rarete']);
            $manager->persist($arme_new);
            $manager->flush();
        }
    }

    private function loadArmures(ObjectManager $manager)
    {
        $armures = [
            ['id' => 1, 'nom' => 'Thunder Helmet', 'defense' => 10, 'rarete' => 2, 'type' => 'Casque'],
            ['id' => 2, 'nom' => 'Magic Armor', 'defense' => 500, 'rarete' => 4, 'type' => 'Plastron'],
            ['id' => 3, 'nom' => 'SPEEEED', 'defense' => 50, 'rarete' => 3, 'type' => 'Jambières'],
            ['id' => 4, 'nom' => 'Crocs', 'defense' => 30, 'rarete' => 1, 'type' => 'Chaussures']
        ];
        foreach ($armures as $armure) {
            $armure_new = new Armure();
            $armure_new->setNom($armure['nom']);
            $armure_new->setDefense($armure['defense']);
            $armure_new->setRarete($armure['rarete']);
            $type = $manager->getRepository(Type::class)->findOneBy(["nom" => $armure['type']]);
            $armure_new->setType($type);
            $manager->persist($armure_new);
            $manager->flush();
        }
    }

    private function loadEnnemis(ObjectManager $manager)
    {
        $ennemis = [
            ['id' => 1, 'nom' => 'Gobelin', 'degats' => 10, 'pv' => 5],
            ['id' => 2, 'nom' => 'Koopa', 'degats' => 20, 'pv' => 10],
            ['id' => 3, 'nom' => 'Sephiroth', 'degats' => 100, 'pv' => 3000],
            ['id' => 4, 'nom' => 'NOAH', 'degats' => 30000, 'pv' => 99999]
        ];
        foreach ($ennemis as $ennemi) {
            $ennemi_new = new Ennemi();
            $ennemi_new->setNom($ennemi['nom']);
            $ennemi_new->setDegats($ennemi['degats']);
            $ennemi_new->setPv($ennemi['pv']);
            $manager->persist($ennemi_new);
            $manager->flush();
        }
    }

    private function loadPotions(ObjectManager $manager)
    {
        $potions = [
            ['id' => 1, 'nom' => 'Potion de rapidité', 'effet' => 'SPEED', 'valeur' => 50, 'rarete' => 2],
            ['id' => 2, 'nom' => 'Potion de force', 'effet' => 'STRENGTH', 'valeur' => 50, 'rarete' => 2],
            ['id' => 3, 'nom' => 'Potion de régénération', 'effet' => 'HP', 'valeur' => 30, 'rarete' => 1],
            ['id' => 4, 'nom' => 'Potion de renforcement', 'effet' => 'HPMAX', 'valeur' => 5, 'rarete' => 3]
        ];
        foreach ($potions as $potion) {
            $potion_new = new Potion();
            $potion_new->setNom($potion['nom']);
            $potion_new->setEffet($potion['effet']);
            $potion_new->setValeur($potion['valeur']);
            $potion_new->setRarete($potion['rarete']);
            $manager->persist($potion_new);
            $manager->flush();
        }
    }

// appeler la méthode loadUsers dans la méthode load

    public function loadUsers(ObjectManager $manager)
    {
        $admin = new User();
        $password = $this->passwordEncoder->encodePassword($admin, 'admin');
        $admin->setPassword($password);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setEmail('admin');
        $perso = new Perso();
        $perso->setAttaque(10);
        $perso->setDefense(10);
        $perso->setArgent(0);
        $perso->setPvMax(100);
        $perso->setPv(100);
        $perso->setNiveau(1);
        $perso->setExperience(0);
        $admin->setPerso($perso);
        $manager->persist($admin);


        $user1 = new User();
        $password = $this->passwordEncoder->encodePassword($user1, 'user');
        $user1->setPassword($password);
        $user1->setRoles(['ROLE_USER']);
        $user1->setUsername('user');
        $user1->setEmail('user');
        $perso2 = new Perso();
        $perso2->setAttaque(10);
        $perso2->setDefense(10);
        $perso2->setArgent(0);
        $perso2->setPvMax(100);
        $perso2->setPv(100);
        $perso2->setNiveau(1);
        $perso2->setExperience(0);
        $user1->setPerso($perso2);
        $manager->persist($user1);


        $manager->flush();
    }
}