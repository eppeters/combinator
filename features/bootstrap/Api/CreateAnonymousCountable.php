<?php

namespace Test\Behavior\Context\Api;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Combinator\Exception\UndefinedEnvironmentVariable;
use Exception;
use GuzzleHttp\Client;

/**
 * @property \Psr\Http\Message\ResponseInterface getResponse
 */
class CreateAnonymousCountable implements Context
{

    private $client;
    private $countableName;
    private $getResponse;

    public function __construct()
    {
        $base_uri = getenv('COMBINATOR_API_BASE_URL_HTTP');
        if (!$base_uri) {
            throw new UndefinedEnvironmentVariable('COMBINATOR_API_BASE_URL_HTTP');
        }

        echo $base_uri;

        $this->client = new Client([
           'base_uri' => $base_uri,
           'timeout' => 2
       ]);
    }

    /**
     * @Given I have a unique name for a quantity I want to count, a countable
     */
    public function iHaveAUniqueNameForAQuantityIWantToCountACountable()
    {
        $this->countableName = 'test_uniqueCountable_' . strftime('%Y-%m-%d', time());
    }

    /**
     * @When I create the countable
     */
    public function iCreateTheCountable()
    {
        $this->client->post('countable', [
            'name' => $this->countableName
        ]);
    }

    /**
     * @Then I should be able to get that countable
     */
    public function iShouldBeAbleToGetThatCountable()
    {
        $this->getResponse = $this->client->get("/countable/$this->countableName");

        assert($this->getResponse->getStatusCode() === 200);
    }

    /**
     * @Then I should see that the value is 0
     */
    public function iShouldSeeThatTheValueIs()
    {
        $responseBody = json_decode($this->getResponse->getBody());
        assert($responseBody->value === 0);
    }
}
