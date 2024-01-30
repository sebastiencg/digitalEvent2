<?php

namespace App\Test\Controller;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/question/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Question::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Question index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'question[question]' => 'Testing',
            'question[explication]' => 'Testing',
            'question[level]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Question();
        $fixture->setQuestion('My Title');
        $fixture->setExplication('My Title');
        $fixture->setLevel('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Question');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Question();
        $fixture->setQuestion('Value');
        $fixture->setExplication('Value');
        $fixture->setLevel('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'question[question]' => 'Something New',
            'question[explication]' => 'Something New',
            'question[level]' => 'Something New',
        ]);

        self::assertResponseRedirects('/question/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getQuestion());
        self::assertSame('Something New', $fixture[0]->getExplication());
        self::assertSame('Something New', $fixture[0]->getLevel());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Question();
        $fixture->setQuestion('Value');
        $fixture->setExplication('Value');
        $fixture->setLevel('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/question/');
        self::assertSame(0, $this->repository->count([]));
    }
}
