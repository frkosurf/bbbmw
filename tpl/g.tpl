<html>
<head>
<title>Web Conferencing</title>
<style type="text/css">
        @import url('s/gadget.css');
</style>
</head>
<body>
	<div id="gadget">
	{if $notification != NULL}
	<div class="notification">{$notification}</div>
	{/if}
	
	{if $groupContext == NULL}
		<strong><em>No Group Context!</em></strong> 
	{else if !array_key_exists($groupContext, $userGroups)}
			<strong><em>Invalid Group Context!</em></strong>
	{else}
		<h2>Conferences for group {$userGroups[$groupContext]}</h2>
		{if empty($conferences)}
			<p><strong>No conferences have been scheduled</strong></p>
		{else}	
		<ul>
			{foreach $conferences as $confId => $confInfo}
				<li>
				<a target="_blank" href="?action=join&id={$confId}">{$confInfo['name']}{if $confInfo['moderator'] === $userId}*{/if}
					{if $confInfo['participantCount'] == 1}
						(1 participant) 
					{else}
						({$confInfo['participantCount']} participants) 
					{/if}
				</a>
				</li> 
			{/foreach}
		</ul>
		<p>
			<small>* conferences you are moderating</small>
		</p>	
		{/if}	
	
		<form method="post">
			<fieldset>
				<legend>Create New Conference</legend>
				<label>Name <input type="text" name="name" value="My Conference"></label>
				<input type="submit" value="Create"> <input type="hidden"
					name="action" value="create"> <input type="hidden" name="welcome"
					value='Welcome to the conference "%%CONFNAME%%"!'> <input
					type="hidden" name="groups[]" value="{$groupContext}">
			</fieldset>
		</form>	
	{/if}
	</div>
</body>
</html>
