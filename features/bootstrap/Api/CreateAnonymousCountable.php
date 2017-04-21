<?php

namespace Test\Behavior\Context\Api;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;

class CreateAnonymousCountable implements Context
{
    /**
     * @Given I have a unique name for a quantity I want to count, a countable
     */
    public function iHaveAUniqueNameForAQuantityIWantToCountACountable()
    {
        throw new PendingException();
    }

    /**
     * @When I create the countable
     */
    public function iCreateTheCountable()
    {
        throw new PendingException();
    }

    /**
     * @Then I should be able to get that countable
     */
    public function iShouldBeAbleToGetThatCountable()
    {
        throw new PendingException();
    }

    /**
     * @Then I should see that the value is :arg1
     */
    public function iShouldSeeThatTheValueIs($arg1)
    {
        throw new PendingException();
    }
}
