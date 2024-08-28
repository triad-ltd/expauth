<?php

use PHPUnit\Framework\TestCase;

class ExpressionEngineHasherTest extends TestCase
{
    public function testHashing()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $value = $hasher->make('password');
        $this->assertNotSame('password', $value);
        $this->assertTrue($hasher->check('password', $value));
        $this->assertTrue(!$hasher->needsRehash($value));
        $this->assertTrue($hasher->needsRehash($value, ['rounds' => 1]));
    }

    public function testMakeEeSha512Hash()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $plain = 'password';
        $hashed = $hasher->make($plain, ['byte_size' => 128, 'salt' => '']);
        $this->assertTrue($hasher->check($plain, $hashed));
    }

    public function testMakeEeSha256Hash()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $plain = 'password';
        $hashed = $hasher->make($plain, ['byte_size' => 64, 'salt' => '']);
        $this->assertTrue($hasher->check($plain, $hashed));
    }

    public function testMakeEeSha1Hash()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $plain = 'password';
        $hashed = $hasher->make($plain, ['byte_size' => 40, 'salt' => '']);
        $this->assertTrue($hasher->check($plain, $hashed));
    }

    public function testMakeEeMd5Hash()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $plain = 'password';
        $hashed = $hasher->make($plain, ['byte_size' => 32, 'salt' => '']);
        $this->assertTrue($hasher->check($plain, $hashed));
    }

    public function testMakeBcryptHash()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $plain = 'password';
        $hashed = $hasher->make($plain);
        $this->assertTrue($hasher->check($plain, $hashed));
    }

    /**
     * @expectedException Exception
     */
    public function testPreventsAgainstMd5Collisions()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;

        $this->expectExceptionObject(new Exception('Hash length exceeds operable length.'));

        $hasher->make('6l4QzmysmLR4o6sRMODW0jhe54ogIAVHZ7sQVvIvh7hzGurXA5KytS3bwM7ayn22KfkZciNkyE3pM315b1hyVOjCN8p474JR2EaJBZu9BR3Yz7T3AKrNBobDVMtvBvhIe7FWO2TsAKkwwCsx1cLM7wGGJzeBUXpchPBThJhZDcOlw4UzDLNoMjHekn6cq57nb2E80y9yhjzKfu6Ktk3nuOqjvRQw5kqM8q1xMjZEuNEfjkxVgOfTC8c1JCw');
    }

    /**
     * @expectedException Exception
     */
    public function testMakingInvalidHashThrowsException()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $plain = 'password';

        $this->expectExceptionObject(new Exception('No matching hash algorithm.'));

        $hasher->make($plain, ['byte_size' => 1, 'salt' => '']);
    }

    public function testMakesHashWithoutSalt()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $plain = 'password';
        $hashed = $hasher->make($plain);
        $this->assertTrue($hasher->check($plain, $hashed));
    }

    public function testCanSetRounds()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $hasher->setRounds(1);
        $this->assertEquals(1, $hasher->getRounds());
    }

    public function testBcryptHashNeedsRehash()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $plain = 'password';
        $hashed = $hasher->make($plain);
        $this->assertTrue($hasher->needsRehash($hashed, ['rounds' => 1]));
    }

    public function testEeHashNeedsRehash()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $plain = 'password';
        $hashed = $hasher->make($plain, ['byte_size' => '128', 'salt' => 'somesalt']);
        $this->assertTrue($hasher->needsRehash($hashed));
    }


    public function testGeneratesNewSalt()
    {
        $hasher = new TriadLtd\ExpAuth\ExpressionEngineHasher;
        $hashed = $hasher->make('password', ['byte_size' => 128, 'salt' => false]);
        $this->assertNotSame('password', $hashed);
    }
}
