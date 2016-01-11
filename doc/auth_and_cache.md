Auth & Cache strategies
=======================

In order to help you manage authentication or cache systems, this lib provides you with useful strategies managements.

> Since theses classes are register as event listener (it use the event dispatcher of Symfony), you can add multiple strategies of each feature.

The cache strategy
==================

These classes implements the [`CacheStrategyInterface`](https://github.com/Nekland/BaseApi/blob/master/lib/Nekland/BaseApi/Cache/CacheStrategyInterface.php).

You register them using the method `useCache` of the ApiFactory.


The authentication strategy
===========================

These classes implements the [`AuthStrategyInterface`](https://github.com/Nekland/BaseApi/blob/master/lib/Nekland/BaseApi/Http/Auth/AuthStrategyInterface.php).

You register them using the method `useAuthentication` of the ApiFactory.
