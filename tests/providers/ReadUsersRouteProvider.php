<?php

namespace linkprofit\Tracker\tests\providers;

use linkprofit\Tracker\builder\ReadUsersBuilder;

class ReadUsersRouteProvider
{
    /**
     * @return \linkprofit\Tracker\request\ReadUsersRoute
     */
    public function get()
    {
        $builder = new ReadUsersBuilder();
        $builder->statuses(['a', 'p'])->fields(['apiKey', 'refId'])->limit(5);

        return $builder->createRoute();
    }

    public function getEmpty()
    {
        $builder = new ReadUsersBuilder();

        return $builder->createRoute();
    }
}
