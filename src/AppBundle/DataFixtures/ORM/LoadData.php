<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');
        $users = [];
        $admin = new User();
        $pwd = $encoder->encodePassword($admin, 'admin');
        $admin->setPassword($pwd);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('Admin');
        $users[] = $admin;

        $manager->persist($admin);

        $faker = FakerFactory::create($this->container->getParameter('kernel.default_locale'));

        for ($i = 0; $i < $faker->numberBetween(3, 7); $i++) {
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setPassword($pwd);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $users[] = $user;
        }

            for ($j = 0; $j < $faker->numberBetween(7, 15); $j++) {
                $post = new Post();
                $post->setContent($faker->text(75));
                $post->setUser($faker->randomElement($users));
                $manager->persist($post);
            }
       
        $manager->flush();
    }
}
