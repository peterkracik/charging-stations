<?php

namespace App\DataFixtures;

use App\Entity\ChargingStation;
use App\Entity\Schedule;
use App\Entity\StationScheduleException;
use App\Entity\Store;
use App\Entity\StoreScheduleException;
use App\Entity\Tenant;
use App\Entity\TenantScheduleException;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ChargingStationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tenant1 = new Tenant();
        $tenant1->setName('Lidl');
        $manager->persist($tenant1);

        $tenant2 = new Tenant();
        $tenant2->setName('Kaufland');

        $exception = new TenantScheduleException();
        $exception->setStart(new DateTime("2020-09-01 00:00"));
        $exception->setEnd(new DateTime("2020-09-15 00:00"));
        $exception->setOpen(false);
        $manager->persist($exception);
        $tenant2->addScheduleException($exception);
        $manager->persist($tenant2);

        /**
         * stores for tenant 1
         */
        $store1 = new Store();
        $store1->setName('Lidl Salzburg');
        $store1->setTenant($tenant1);
        $schedule = new Schedule();
        $schedule->setMonday('09:00-12:00;13:00-18:00');
        $schedule->setTuesday('09:00-12:00;13:00-18:00');
        $schedule->setWednesday('09:00-12:00;13:00-18:00');
        $schedule->setThursday('09:00-12:00;13:00-18:00');
        $schedule->setFriday('09:00-12:00;13:00-18:00');
        $schedule->setSaturday('09:00-16:00');
        $schedule->setSunday('09:00-12:30');
        $store1->setSchedule($schedule);
        $manager->persist($store1);

        $store2 = new Store();
        $store2->setName('Lidl Radstadt');
        $store2->setTenant($tenant1);
        $schedule = new Schedule();
        $schedule->setMonday('07:00-12:30;13:30-19:00');
        $schedule->setTuesday('07:00-12:30;13:30-19:00');
        $schedule->setWednesday('07:00-12:30;13:30-19:00');
        $schedule->setThursday('07:00-12:30;13:30-19:00');
        $schedule->setFriday('07:00-12:30;13:30-19:00');
        $schedule->setSaturday('08:00-16:00');
        $schedule->setSunday('09:00-12:30');
        $store2->setSchedule($schedule);

        $exception2 = new StoreScheduleException();
        $exception2->setStart(new DateTime("2020-09-01 00:00"));
        $exception2->setEnd(new DateTime("2020-09-09 00:00"));
        $exception2->setOpen(false);
        $manager->persist($exception2);
        $store2->addScheduleException($exception2);
        $manager->persist($store2);

        /**
         * stores for tenant 2
         */
        $store3 = new Store();
        $store3->setName('Kaufland Salzburg');
        $store3->setTenant($tenant2);
        $schedule = new Schedule();
        $schedule->setMonday('09:00-12:00;13:00-18:00');
        $schedule->setTuesday('09:00-12:00;13:00-18:00');
        $schedule->setWednesday('09:00-12:00;13:00-18:00');
        $schedule->setThursday('09:00-12:00;13:00-18:00');
        $schedule->setFriday('09:00-12:00;13:00-18:00');
        $schedule->setSaturday('09:00-16:00');
        $schedule->setSunday('09:00-12:30');
        $store3->setSchedule($schedule);
        $manager->persist($store3);

        $store4 = new Store();
        $store4->setName('Kaufland Radstadt');
        $store4->setTenant($tenant2);
        $schedule = new Schedule();
        $schedule->setMonday('07:00-12:30;13:30-19:00');
        $schedule->setTuesday('07:00-12:30;13:30-19:00');
        $schedule->setWednesday('07:00-12:30;13:30-19:00');
        $schedule->setThursday('07:00-12:30;13:30-19:00');
        $schedule->setFriday('07:00-12:30;13:30-19:00');
        $schedule->setSaturday('08:00-16:00');
        $schedule->setSunday('09:00-12:30');
        $store4->setSchedule($schedule);
        $manager->persist($store4);

        /**
         * charging stations for store 1
         */
        $station1 = new ChargingStation();
        $station1->setName("Lidl Salzburg - Charging station for clients");
        $station1->setStore($store1);
        // default schedule
        $exception3 = new StationScheduleException();
        $exception3->setStart(new DateTime("2020-09-07 10:00"));
        $exception3->setEnd(new DateTime("2020-09-07 19:00"));
        $exception3->setOpen(false);
        $manager->persist($exception3);
        $station1->addScheduleException($exception3);
        $manager->persist($station1);

        $station2 = new ChargingStation();
        $station2->setName("Lidl Salzburg - Charging station for employees");
        $station2->setStore($store1);
        $schedule = new Schedule();
        $schedule->setMonday('07:00-12:30;13:30-19:00');
        $schedule->setTuesday('07:00-12:30;13:30-19:00');
        $schedule->setWednesday('07:00-12:30;13:30-19:00');
        $schedule->setThursday('07:00-12:30;13:30-19:00');
        $schedule->setFriday('07:00-12:30;13:30-19:00');
        $schedule->setSaturday('08:00-16:00');
        $schedule->setSunday('09:00-12:30');
        $station2->setSchedule($schedule);
        $manager->persist($station2);

        /**
         * charging stations for store 2
         */
        $station3 = new ChargingStation();
        $station3->setName("Lidl Radstadt - Charging station for clients");
        $station3->setStore($store2);
        $schedule = new Schedule();
        $schedule->setOpenWednesday(false);
        $schedule->setSaturday('06:00-18:00');
        $schedule->setSunday('06:00-18:00');
        $station3->setSchedule($schedule);
        $manager->persist($station3);

        $station4 = new ChargingStation();
        $station4->setName("Lidl Radstadt - Charging station for employees");
        $station4->setStore($store2);
        $schedule = new Schedule();
        $schedule->setMonday('06:00-22:00');
        $schedule->setTuesday('06:00-22:00');
        $schedule->setWednesday('06:00-22:00');
        $schedule->setThursday('06:00-22:00');
        $schedule->setFriday('06:00-22:00');
        $schedule->setSaturday('08:00-16:00');
        $schedule->setSunday('09:00-19:30');
        $station4->setSchedule($schedule);
        $manager->persist($station4);


        /**
         * charging stations for store 3
         */
        $station5 = new ChargingStation();
        $station5->setName("Kaufland Salzburg - Charging station for clients");
        $station5->setStore($store3);
        // default schedule
        $manager->persist($station5);

        $station6 = new ChargingStation();
        $station6->setName("Kaufland Salzburg - Charging station for employees");
        $station6->setStore($store3);
        $schedule = new Schedule();
        $schedule->setMonday('07:00-12:30;13:30-19:00');
        $schedule->setTuesday('07:00-12:30;13:30-19:00');
        $schedule->setWednesday('07:00-12:30;13:30-19:00');
        $schedule->setThursday('07:00-12:30;13:30-19:00');
        $schedule->setFriday('07:00-12:30;13:30-19:00');
        $schedule->setSaturday('08:00-16:00');
        $schedule->setSunday('09:00-12:30');
        $station6->setSchedule($schedule);
        $manager->persist($station6);

        /**
         * charging stations for store 4
         */
        $station7 = new ChargingStation();
        $station7->setName("Kaufland Radstadt - Charging station for clients");
        $station7->setStore($store4);
        $schedule = new Schedule();
        $schedule->setOpenWednesday(false);
        $schedule->setSaturday('06:00-18:00');
        $schedule->setSunday('06:00-18:00');
        $station7->setSchedule($schedule);
        $manager->persist($station7);

        $station8 = new ChargingStation();
        $station8->setName("Kaufland Radstadt - Charging station for employees");
        $station8->setStore($store4);
        $schedule = new Schedule();
        $schedule->setMonday('06:00-22:00');
        $schedule->setTuesday('06:00-22:00');
        $schedule->setWednesday('06:00-22:00');
        $schedule->setThursday('06:00-22:00');
        $schedule->setFriday('06:00-22:00');
        $schedule->setSaturday('08:00-16:00');
        $schedule->setSunday('09:00-19:30');
        $station8->setSchedule($schedule);
        $manager->persist($station8);


        $manager->flush();
    }
}
