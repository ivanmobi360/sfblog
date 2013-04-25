<?php

namespace Blogger\BlogBundle\DataFixtures\ORM;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

use Blogger\BlogBundle\Entity\User;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \Doctrine\Common\DataFixtures\AbstractFixture;

/**
 *
 * @author Ivan Rodriguez
 */
class UserFixtures extends AbstractFixture implements OrderedFixtureInterface {
    
    public function load(ObjectManager $manager) {
        
        $coder = new MessageDigestPasswordEncoder('sha1', true, 1); //srsly?

        $user = new User();
        $user->setUsername('admin');
        $user->setPassword( $coder->encodePassword('123456', $user->getSalt() ) );
        $user->setEmail('admin@blah.com');
        $user->setIsActive(true);
        $this->addReference('admin', $user);
        $manager->persist($user);
        
        $user = new User();
        $user->setUsername('maxime');
        $user->setPassword( $coder->encodePassword('123456', $user->getSalt() ) );
        $user->setEmail('maxime@blah.com');
        $user->setIsActive(false);
        $this->addReference('maxime', $user);
        $manager->persist($user);
        
        
        $manager->flush();
        
        
        
    }

    public function getOrder() {
        return 1;
    }
}