Auth & Cache strategies
=======================

In order to help you manage authentication or cache systems, this lib provides you useful strategies managements.

> Since theses classes are register as event listener (it use the event dispatcher of Symfony), you can add multiple strategies of each feature.

The cache strategy
==================

This are classes that implements the `CacheStrategyInterface`.

You register them using the method `useCache` of the ApiFactory.


The authentication strategy
===========================

This are classes implementing the `AuthenticationStrategyInterface`.

You register them using the method `useAuthentication` of the ApiFactory
