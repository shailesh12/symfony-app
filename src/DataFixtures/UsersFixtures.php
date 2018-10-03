<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Users;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture {

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager) {
        // $product = new Product();
        // $manager->persist($product);
        $user = new Users();
        $user->setUsername('admin');
        $user->setPassword(
                $this->encoder->encodePassword($user, 'password')
        );
        $user->setEmail('admin@yopmail.com');
        $manager->persist($user);
        $manager->flush();
    }

}
