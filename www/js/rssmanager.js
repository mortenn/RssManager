var rssManager = angular.module('rssManager', ['ui.router']);

rssManager.run(
[
	'$rootScope',
	function($rootScope)
	{
		var err = {
				add: function(message) { err.messages.push(message); },
				messages: []
		};
		rssManager.showError = function(message) { err.add(message); };
		$rootScope.errors = err;
		$rootScope.$on(
			'$stateChangeError',
			function(event, toState, toParams, fromState, fromParams, rejection)
			{
				console.log(event, toState, toParams, fromState, fromParams, rejection);
				err.add(event);
			}
		);
	}
]);

rssManager.factory(
	'$exceptionHandler',
	function()
	{
		return function(exception, cause)
		{
			console.log(exception, cause);
			rssManager.showError('Exception logged, see console for details.');
		}
	}
);

rssManager.controller(
	'Feeds',
	[
		function()
		{
		}
	]
);

rssManager.controller(
	'NewFeed',
	[
		function()
		{
		}
	]
);

rssManager.controller(
	'Inbox',
	[
		function()
		{
		}
	]
);

rssManager.controller(
	'NewTorrent',
	[
		function()
		{
		}
	]
);

rssManager.controller(
	'Restart',
	[
		function()
		{
		}
	]
);

rssManager.controller(
	'WatchList',
	[
		function()
		{
		}
	]
);

rssManager.controller(
	'ShowList',
	[
		function()
		{
		}
	]
);

rssManager.config(
[
	'$stateProvider',
	function($stateProvider)
	{
		$stateProvider
			.state('feeds', { url: '/feeds', templateUrl: 'partial/feeds.html', controller: 'Feeds as ctrl' })
			.state('newfeed', { url: '/new', templateUrl: 'partial/newfeed.html', controller: 'NewFeed as ctrl' })
			.state('inbox', { url: '/inbox', templateUrl: 'partial/inbox.html', controller: 'Inbox as ctrl' })
			.state('newtorrent', { url: '/search', templateUrl: 'partial/newtorrent.html', controller: 'NewTorrent as ctrl' })
			.state('restart', { url: '/restart', templateUrl: 'partial/restart.html', controller: 'Restart as ctrl' })
			.state('watch', { url: '/watch', templateUrl: 'partial/watchlist.html', controller: 'WatchList as ctrl' })
			.state('shows', { url: '/shows', templateUrl: 'partial/showlist.html', controller: 'ShowList as ctrl' })
		;
	}
]);
