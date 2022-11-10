<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;

class UserServiceTest extends TestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $this->createApplication();
    }

    public function testUserIsCreatedSuccessfully()
    {
        // Prepare
        $expectedUser = new User([
            'name' => 'John Doe',
            'email' => 'john.doe@email.com',
            'password' => 'secret'
        ]);

        $repositoryMock = \Mockery::mock(UserRepository::class);
        $repositoryMock->shouldReceive('createUser')
            ->andReturn($expectedUser);

        // Execute
        $service = new UserService($repositoryMock);
        $result = $service->registerUser('John Doe', 'john.doe@email.com', 'secret');

        // Assert
        $this->assertEquals($result, $expectedUser);
    }

    public function testRepositoryThrowsAnException()
    {
        $repositoryMock = \Mockery::mock(UserRepository::class);
        $repositoryMock->shouldReceive('createUser')
            ->andThrow(\PDOException::class);

//       // $this->expectException(\PDOException::class);
//       // $this->expectException(\Exception::class);

        $service = new UserService($repositoryMock);
        $result = $service->registerUser('John Doe', 'john.doe@email.com', 'secret');

        $this->assertNull($result);
    }
}
