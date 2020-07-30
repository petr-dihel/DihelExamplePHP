{load_module type='page' name='feed_providers'}

<div class="wrap-bar">
    <h1 class="wrap-bar__heading"><#feed_providers|capitals#></h1>
</div>

{link page="feed_provider_detail" template_name='feed_provider_detail' id=0 class="in-icon svg svg-circle-plus" }
    <#add_new|capitals#>
{/link}

<div class="table-touch">
    <table class="table-main table-main--users">
        <thead class="table-grid">
        <tr class="table-grid__row">
            <th class="table-grid__cell table-col-5 text-center"><#id#></th>
            <th class="table-grid__cell table-col-5 text-center"><#name|capitals#></th>
            <th class="table-grid__cell table-col-5 text-center"><#language|capitals#></th>
            <th class="table-grid__cell table-col-20 text-center"><#url|capitals#></th>
            <th class="table-grid__cell table-col-5 text-center"><#last_update|capitals#></th>
            <th class="table-grid__cell table-col-5 text-center"><#is_enabled|capitals#></th>
            <th class="table-grid__cell table-col-5 text-center"><#edit|capitals#></th>
            <th class="table-grid__cell table-col-5 text-center"><#run|capitals#></th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$module->getFeedProvidersLanguages() item=feedProviderLanguage}
            <tr class="table-grid__row">
                <td class="table-grid__cell text-center">{$feedProviderLanguage->getFeedProviderId()}</td>
                <td class="table-grid__cell text-center">
                    {$feedProviderLanguage->getFeedProviderEntity()->getName()}
                </td>
                <td class="table-grid__cell text-center">{$feedProviderLanguage->getLanguage()->getSignature()}</td>
                <td class="table-grid__cell text-center">
                   <a href="{$feedProviderLanguage->getUrl()}">{$feedProviderLanguage->getUrl()}</a>
                </td>
                <td class="table-grid__cell text-center">
                    {if $feedProviderLanguage->getLastUpdate() > 0}
                        {$feedProviderLanguage->getLastUpdate()|date_format:'j. n. Y H:i:s'}
                    {else}
                        <#never|capitals#>
                    {/if}
                </td>
                <td class="table-grid__cell text-center">
                    {if $feedProviderLanguage->getIsEnabled()}
                        <#yes#>
                    {else}
                        <#no#>
                    {/if}
                </td>
                <td class="table-grid__cell text-center">
                    {link page='feed_provider_detail'
                        id=$feedProviderLanguage->getFeedProviderId()
                        url_get_params="language_id=`$feedProviderLanguage->getLanguageId()`"
                        class="in-icon svg svg-pencil"}
                    {/link}
                </td>
                <td class="table-grid__cell text-center">
                    <a href="{$module->getServiceUrlByProviderLanguageEntity($feedProviderLanguage)}" target="_newtab">
                        <div class="in-icon svg svg-download"></div>
                    </a>

                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
