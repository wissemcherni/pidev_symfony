<?php

namespace App\Test\Controller;

use App\Entity\ProfilLivreur;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfilLivreurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/profil/livreur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(ProfilLivreur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ProfilLivreur index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'profil_livreur[nomLivreur]' => 'Testing',
            'profil_livreur[secteur]' => 'Testing',
            'profil_livreur[moyLivraison]' => 'Testing',
            'profil_livreur[volume]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ProfilLivreur();
        $fixture->setNomLivreur('My Title');
        $fixture->setSecteur('My Title');
        $fixture->setMoyLivraison('My Title');
        $fixture->setVolume('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ProfilLivreur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ProfilLivreur();
        $fixture->setNomLivreur('Value');
        $fixture->setSecteur('Value');
        $fixture->setMoyLivraison('Value');
        $fixture->setVolume('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'profil_livreur[nomLivreur]' => 'Something New',
            'profil_livreur[secteur]' => 'Something New',
            'profil_livreur[moyLivraison]' => 'Something New',
            'profil_livreur[volume]' => 'Something New',
        ]);

        self::assertResponseRedirects('/profil/livreur/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomLivreur());
        self::assertSame('Something New', $fixture[0]->getSecteur());
        self::assertSame('Something New', $fixture[0]->getMoyLivraison());
        self::assertSame('Something New', $fixture[0]->getVolume());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new ProfilLivreur();
        $fixture->setNomLivreur('Value');
        $fixture->setSecteur('Value');
        $fixture->setMoyLivraison('Value');
        $fixture->setVolume('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/profil/livreur/');
        self::assertSame(0, $this->repository->count([]));
    }
}
