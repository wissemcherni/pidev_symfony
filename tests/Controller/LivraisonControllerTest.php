<?php

namespace App\Test\Controller;

use App\Entity\Livraison;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LivraisonControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/livraison/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Livraison::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Livraison index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'livraison[nomLivreur]' => 'Testing',
            'livraison[dateLivraison]' => 'Testing',
            'livraison[numCommande]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Livraison();
        $fixture->setNomLivreur('My Title');
        $fixture->setDateLivraison('My Title');
        $fixture->setNumCommande('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Livraison');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Livraison();
        $fixture->setNomLivreur('Value');
        $fixture->setDateLivraison('Value');
        $fixture->setNumCommande('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'livraison[nomLivreur]' => 'Something New',
            'livraison[dateLivraison]' => 'Something New',
            'livraison[numCommande]' => 'Something New',
        ]);

        self::assertResponseRedirects('/livraison/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomLivreur());
        self::assertSame('Something New', $fixture[0]->getDateLivraison());
        self::assertSame('Something New', $fixture[0]->getNumCommande());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Livraison();
        $fixture->setNomLivreur('Value');
        $fixture->setDateLivraison('Value');
        $fixture->setNumCommande('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/livraison/');
        self::assertSame(0, $this->repository->count([]));
    }
}
