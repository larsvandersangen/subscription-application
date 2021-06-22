<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Email;
use App\Entity\PaymentInfo;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    private ObjectManager $objectManager;

    /**
     * AppFixtures constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->objectManager = $manager;

        $numberOfUsersToCreate = random_int(0,100);
        $numberOfUsersCreated = 0;

        while($numberOfUsersCreated <= $numberOfUsersToCreate) {

            $email = $this->createEmail();
            $password = $this->createPassword();
            $subscriptionCollection = $this->createSubscriptionCollection();
            $paymentInfo = $this->createPaymentInfo();

            $user = new User();
            $user->setPaymentInfo($paymentInfo)
                ->setEmail($email)
                ->addSubscriptionCollection($subscriptionCollection)
                ->setPassword($password);

            $this->objectManager->persist($user);

            $numberOfUsersCreated++;
        }

        $this->objectManager->flush();
    }

    /**
     * @return Email
     */
    private function createEmail() : Email
    {
        $email = new Email();

        $emailAddress = $this->faker->unique()->email();
        $email->setEmail($emailAddress);

        $this->objectManager->persist($email);

        return $email;
    }

    /**
     * @return string
     */
    private function createPassword() : string
    {
        return password_hash($this->faker->password(), PASSWORD_BCRYPT);
    }

    private function createSubscriptionCollection(): ArrayCollection
    {
        $numberOfSubscriptionsToCreate = random_int(0,5);
        $numberOfSubscriptionsCreated = 0;

        $subscriptionCollection = new ArrayCollection();
        while($numberOfSubscriptionsCreated <= $numberOfSubscriptionsToCreate) {

            $address = $this->createAddress();

            $subscription = new Subscription();

            $subscription->setEmail($this->createEmail())
                ->setFirstname($this->faker->firstName())
                ->setLastname($this->faker->lastName())
                ->setPhonenumber($this->faker->phoneNumber())
                ->setAddress($address);

            $this->objectManager->persist($subscription);

            $subscriptionCollection->add($subscription);
            $numberOfSubscriptionsCreated++;

        }

        return $subscriptionCollection;
    }

    private function createAddress() : Address
    {
        $address = new Address();
        $address->setCity($this->faker->city())
            ->setHousenumber($this->faker->numberBetween(0, 100))
            ->setStreet($this->faker->streetName())
            ->setPostalcode($this->faker->postcode());

        $this->objectManager->persist($address);

        return $address;
    }

    private function createPaymentInfo() : PaymentInfo
    {
        $paymentInfo = new PaymentInfo();
        $paymentInfo->setIban($this->faker->iban('nl'));

        $this->objectManager->persist($paymentInfo);

        return $paymentInfo;
    }
}
