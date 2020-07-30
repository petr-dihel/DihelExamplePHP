{load_module type='ajax' name='feed_provider_languages_versions'}

{if count($module->findProviderLanguageEntity()) > 0}
	{formSelectEntities
		entities=$module->findProviderLanguageEntity()
		value=$module->getSelectedLanguageId()
		name='language_id'
		disabledIfSelected=true
		getterId='getId'
		getterName='getSignature'
		class='input'
		id='language_id'
	}
{else}
	<#no_available_found#>
{/if}


