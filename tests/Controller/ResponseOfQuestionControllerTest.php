<?php

namespace App\Test\Controller;

use App\Entity\ResponseOfQuestion;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResponseOfQuestionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/response/of/question/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(ResponseOfQuestion::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ResponseOfQuestion index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'response_of_question[isTrue]' => 'Testing',
            'response_of_question[response]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ResponseOfQuestion();
        $fixture->setIsTrue('My Title');
        $fixture->setResponse('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ResponseOfQuestion');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ResponseOfQuestion();
        $fixture->setIsTrue('Value');
        $fixture->setResponse('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'response_of_question[isTrue]' => 'Something New',
            'response_of_question[response]' => 'Something New',
        ]);

        self::assertResponseRedirects('/response/of/question/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIsTrue());
        self::assertSame('Something New', $fixture[0]->getResponse());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new ResponseOfQuestion();
        $fixture->setIsTrue('Value');
        $fixture->setResponse('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/response/of/question/');
        self::assertSame(0, $this->repository->count([]));
    }
}
