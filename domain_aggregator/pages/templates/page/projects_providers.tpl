{load_module type='page' name='projects_providers'}

<div class="wrap-bar">
	<h1 class="wrap-bar__heading"><#projects_providers|capitals#></h1>
</div>

{link page="project_provider_detail" template_name='project_provider_detail' id=0 class="in-icon svg svg-circle-plus" }
	<#add_new|capitals#>
{/link}

<div class="table-touch">
	<table class="table-main table-main--users">
		<thead class="table-grid">
		<tr class="table-grid__row">
			<th class="table-grid__cell table-col-5 text-center"><#project_name|capitals#></th>
			<th class="table-grid__cell table-col-5 text-center"><#feed_provider_name|capitals#></th>
			<th class="table-grid__cell table-col-5 text-center"><#language|capitals#></th>
			<th class="table-grid__cell table-col-5 text-center"><#is_enabled|capitals#></th>
			<th class="table-grid__cell table-col-5 text-center"><#version|capitals#></th>
			<th class="table-grid__cell table-col-5 text-center"><#last_update|capitals#></th>
			<th class="table-grid__cell table-col-5 text-center"><#edit|capitals#></th>
		</tr>
		</thead>
		<tbody>
		{foreach from=$module->getProjectFeedProviderEntities() item=projectFeedProvider}
			<tr class="table-grid__row">
				<td class="table-grid__cell text-center">
					{$projectFeedProvider->getProject()->getKlientName()}
				</td>
				<td class="table-grid__cell text-center">{$projectFeedProvider->getFeedProviderEntity()->getName()}</td>
				<td class="table-grid__cell text-center">
					{$projectFeedProvider->getLanguage()->getSignature()}
				</td>
				<td class="table-grid__cell text-center">
					{if $projectFeedProvider->getIsEnabled()}
						<#yes#>
					{else}
						<#no#>
					{/if}
				</td>
				<td class="table-grid__cell text-center">
					{$projectFeedProvider->getVersion()}
				</td>
				<td class="table-grid__cell text-center">
					{if $projectFeedProvider->getLastUpdate() > 0}
						{$projectFeedProvider->getLastUpdate()|date_format:'j. n. Y H:i:s'}
					{else}
						<#never|capitals#>
					{/if}
				</td>
				<td class="table-grid__cell text-center">
					{link page='project_provider_detail'
					id=$projectFeedProvider->getFeedProviderId()
					url_get_params="project_id=`$projectFeedProvider->getProjectId()`&language_id=`$projectFeedProvider->getLanguageId()`"
					class="in-icon svg svg-pencil"}
					{/link}
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
</div>
