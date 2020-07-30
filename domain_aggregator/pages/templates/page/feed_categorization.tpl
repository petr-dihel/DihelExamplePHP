{load_module type='page' name='feed_categorization'}

<div class="wrap-bar">
	<h1 class="wrap-bar__heading js-breadcrumb-pageTitle"><#feed_categorization|capitals#></h1>
</div>

{$module->messageReporting->getRenderMessages()}

<div class="wrap-bar">
	<canvas
			class="js-line-chart"
			data-chart-labels='{$module->getFeedProvidersNames()}'
			data-chart-values='{$module->getFeedProviderValueTranslateCount()}'
			data-chart-title='<#feed_provider_values_translate_count#>'>
	</canvas>
</div>

<script src="{$siteUrl}domain_common/scripts/frontend/Chart.bundle.min.js" async></script>
