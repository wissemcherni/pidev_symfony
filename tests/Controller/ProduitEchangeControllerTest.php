<?php

namespace App\Test\Controller;

use App\Entity\ProduitEchange;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProduitEchangeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/produit/echange/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(ProduitEchange::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ProduitEchange index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'produit_echange[idProduit]' => 'Testing',
            'produit_echange[type]' => 'Testing',
            'produit_echange[idCommande]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ProduitEchange();
        $fixture->setIdProduit('My Title');
        $fixture->setType('My Title');
        $fixture->setIdCommande('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ProduitEchange');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ProduitEchange();
        $fixture->setIdProduit('Value');
        $fixture->setType('Value');
        $fixture->setIdCommande('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'produit_echange[idProduit]' => 'Something New',
            'produit_echange[type]' => 'Something New',
            'produit_echange[idCommande]' => 'Something New',
        ]);

        self::assertResponseRedirects('/produit/echange/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIdProduit());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getIdCommande());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new ProduitEchange();
        $fixture->setIdProduit('Value');
        $fixture->setType('Value');
        $fixture->setIdCommande('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/produit/echange/');
        self::assertSame(0, $this->repository->count([]));
    }
}
