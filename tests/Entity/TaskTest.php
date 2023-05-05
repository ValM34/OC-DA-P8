<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskTest extends TestCase
{
  private ValidatorInterface $validator;

  protected function setUp(): void
  {
    $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
  }

  public function testTaskAssertLength(): void
  {
    $task = new Task();
    $toShortTitle = '12';
    $toShortContent = '12';
    $goodTitle = 'Nouvelle tâche';
    $goodContent = 'Ce contenu est correct';

    $task
      ->setTitle($toShortTitle)
      ->setContent($toShortContent)
    ;
    $violations = $this->validator->validate($task);
    $this->assertCount(2, $violations);

    $task
      ->setTitle($goodTitle)
      ->setContent($goodContent)
    ;
    $violations = $this->validator->validate($task);
    $this->assertCount(0, $violations);
  }
}
