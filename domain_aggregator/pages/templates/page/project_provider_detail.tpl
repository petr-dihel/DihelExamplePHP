{load_module type='page' name='project_provider_detail'}

<div class="wrap-bar">
	<h1 class="wrap-bar__heading"><#projects_providers|capitals#></h1>
</div>

{link template_name="projects_providers" class="in-icon svg svg-arrow-back"}
	<#back_to_list|capitals#>
{/link}

{$module->messageReporting->getRenderMessages()}

{form_start name='project_provider_detail' method='POST'}

{if $module->getProjectFeedProviderEntity()->getFeedProviderId() <= 0}
	{form_hidden name='is_new' value=1}
	{form_hidden name='selectedLanguageId' value=0}
{else}
	{form_hidden name='selectedLanguageId' value=$module->getProjectFeedProviderEntity()->getLanguageId()}
{/if}

<div class="wrap-border">
	<div class="form-group">
		<div class="form-group__title"><#project_provider|capitals#></div>
	</div>

	<div class="form-line">
		<label class="form-line__label" for="project"><#project|capitals#>:</label>
		<div class="form-line__side">
			<div class="form-line__item">
				{formSelectEntities
				entities=$module->findProjects()
				getterName='getKlientName'
				value= $module->getProjectFeedProviderEntity()->getProjectId()
				name='project_id'
				disabledIfSelected=true
				class='input'
				}
			</div>
		</div>
	</div>

	<div class="form-line">
		<label class="form-line__label" for="feed_provider_id"><#feed_provider|capitals#>:</label>
		<div class="form-line__side">
			<div class="form-line__item">
				{formSelectEntities
				entities=$module->findFeedProviders()
				value=$module->getProjectFeedProviderEntity()->getFeedProviderId()
				name='feed_provider_id'
				disabledIfSelected=true
				class='input js-feed-provider-select'
				}
			</div>
		</div>
	</div>

	<div class="wrapper-language">
		<div class="form-line">
			<label class="form-line__label" for="language_id"><#language|capitals#>:</label>
			<div class="form-line__side">
				<div class="in-overlay__spinner__icon js-feed-provider-languages-loader display-none"></div>
				<div class="form-line__item js-select-provider-warning">
					<#please_select_feed_provider#>
				</div>
				<div class="js-feed-provider-languages-version-wrapper">
				</div>
			</div>
		</div>
	</div>

	<div class="form-line">
		<label class="form-line__label" for="last_update"><#is_enabled|capitals#>:</label>
		<div class="form-line__side">
			{form_checkbox name="is_enabled" class="input_checkbox" id="is_enabled"
			checked_value=$module->getProjectFeedProviderEntity()->getIsEnabled()}
		</div>
	</div>

	<div class="form-line">
		<label class="form-line__label" for="version"><#version|capitals#>:</label>
		<div class="form-line__side">
			{form_number name="version" class="input" id="version" min=1
			value=$module->getProjectFeedProviderEntity()->getVersion()}
		</div>
	</div>
	<div class="form-line">
		<label class="form-line__label" for="version"><#hash|capitals#>:</label>
		<div class="form-line__side">
			{form_password name="hash" class="input js-input-hash" id="hash" min=1
			value=$module->getProjectFeedProviderEntity()->getHash()}
			<div class="btn js-show-hash">
				<#show|capitals#>/ <#hide|capitals#>
			</div>
			<div class="btn js-copy-hash"><#copy|capitals#></div>
			<div class="btn js-generate-hash"><#generate|capitals></div>
		</div>
	</div>

	<div class="form-line">
		<label class="form-line__label" for="last_update"><#last_update|capitals#>:</label>
		<div class="form-line__side">
			{form_text name="last_update" readonly="readonly" id="last_update"
			class='input form-input-disabled'
			value=$module->getProjectFeedProviderEntity()->getLastUpdate()}
		</div>
	</div>

	<div class="window-fixed-bar">
		<div class="window-fixed-bar__in">
			<div class="window-fixed-bar__item">
				<div class="window-fixed-bar__item__cell">
					{form_submit name='save' class='btn' value='<#save_data|capitals#>'}
				</div>
			</div>
		</div>
	</div>

</div>

{form_end}
