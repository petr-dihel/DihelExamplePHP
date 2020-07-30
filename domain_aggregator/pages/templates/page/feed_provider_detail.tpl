{load_module type='page' name='feed_provider_detail'}

<div class="wrap-bar">
	<h1 class="wrap-bar__heading js-breadcrumb-pageTitle"><#feed_provider|capitals#></h1>
</div>

{link template_name="feed_providers" class="in-icon svg svg-arrow-back"}
	<#back_to_list|capitals#>
{/link}

{$module->messageReporting->getRenderMessages()}

{form_start name='feed_provider' method='POST'}

<div class="wrap-border">
	<div class="form-group">
		<div class="form-group__title"><#feed_provider|capitals#></div>
	</div>

	<div class="form-line">
		<label class="form-line__label" for="id"><#feed|capitals#>:</label>
		<div class="form-line__side">
			<div class="form-line__item">
				{form_text name='id_text' class='input' disabled="disabled" id="id"
					value=$module->getProviderLanguageEntity()->getFeedProviderId()}
			</div>
		</div>
	</div>

	<div class="form-line">
		<label class="form-line__label" for="name"><#feed_provider_name|capitals#>:</label>
		<div class="form-line__side">
			<div class="form-line__item">
				{if $module->getProviderLanguageEntity()->getFeedProviderId() > 0}
					{form_text name='name' class='input form-input-disabled' readonly="readonly"
						value=$module->getProviderLanguageEntity()->getFeedProviderEntity()->getName()}
					{form_hidden name='feed_provider_id'
						value=$module->getProviderLanguageEntity()->getFeedProviderid()}
				{else}
					<select name="feed_provider_id" class="input js-feed-provider-select" id="name">
						<option value="0"><#new#></option>
						{foreach from=$module->findProviderEntity() item=$providerEntity}
							<option value="{$providerEntity->getId()}">{$providerEntity->getName()}</option>
						{/foreach}
					</select>
					{form_text name='name' class='input js-feed-provider-name' value=''}
					<div class="in-message--warning input js-feed-provider-name"><#need_to_implement_new_parser#></div>
				{/if}
			</div>
		</div>
	</div>

	<div class="form-line">
		<label class="form-line__label" for="language"><#language|capitals#>:</label>
		<div class="form-line__side">
			{formSelectEntities
				entities=$module->findLanguagesEntity()
				value=$module->getSelectedLanguageId()
				name='language_id'
				disabledIfSelected=true
				getterId='getId'
				getterName='getSignature'
				class='input'
				id='language_id'
			}
			{if $module->getProviderLanguageEntity()->getFeedProviderId() <= 0}
				{form_hidden name="is_new_language" value='1'}
			{/if}
		</div>
	</div>

	<div class="form-line">
		<label class="form-line__label" for="url"><#url|capitals#>:</label>
		<div class="form-line__side">
			{form_text name="url" class="input" id="url"
			value=$module->getProviderLanguageEntity()->getUrl()}
		</div>
	</div>

	{if $module->getProviderLanguageEntity()->getFeedProviderId() > 0}
		<div class="form-line">
			<label class="form-line__label" for="last_update"><#last_update|capitals#>:</label>
			<div class="form-line__side">
				{form_text name="last_update" class="input" id="last_update" disabled="disabled"
					value=$module->getProviderLanguageEntity()->getLastUpdate()|date_format:'j. n. Y H:i:s' }
			</div>
		</div>
	{/if}

	<div class="form-line">
		<label class="form-line__label" for="last_update"><#is_enabled|capitals#>:</label>
		<div class="form-line__side">
			{form_checkbox name="is_enabled" class="input_checkbox" id="is_enabled"
				checked_value=$module->getProviderLanguageEntity()->getIsEnabled()}
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
