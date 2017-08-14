
# ElasticExportKuponaDE plugin user guide

<div class="container-toc"></div>

## 1 Registering with Kupona.de

Kupona.de is an agency for online performance marketing. It is active in the fields of display performance advertising, retargeting, affiliate marketing and product data marketing.

## 2 Setting up the data format KuponaDE-Plugin in plentymarkets

The plugin Elastic Export is required to use this format.

Refer to the [Exporting data formats for price search engines](https://knowledge.plentymarkets.com/en/basics/data-exchange/exporting-data#30) page of the manual for further details about the individual format settings.

The following table lists details for settings, format settings and recommended item filters for the format **KuponaDE-Plugin**.
<table>
    <tr>
        <th>
            Settings
        </th>
        <th>
            Explanation
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Settings
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            Choose <b>KuponaDE-Plugin</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Provisioning
        </td>
        <td>
            Choose <b>URL</b>.
        </td>        
    </tr>
    <tr>
        <td>
            File name
        </td>
        <td>
            The file name must have the ending <b>.csv</b> or <b>.txt</b> for Twenga.com to be able to import the file successfully.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Item filter
        </td>
    </tr>
    <tr>
        <td>
            Active
        </td>
        <td>
            Choose <b>active</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Markets
        </td>
        <td>
            Choose one or multiple order referrers. The chosen order referrer has to be active at the variation for the item to be exported.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Format settings
        </td>
    </tr>
    <tr>
        <td>
            Order referrer
        </td>
        <td>
            Choose the order referrer that should be assigned during the order import.
        </td>        
    </tr>
    <tr>
        <td>
            Offer price
        </td>
        <td>
            This option is not relevant for this format.
        </td>        
    </tr>
    <tr>
        <td>
            VAT note
        </td>
        <td>
            This option is not relevant for this format.
        </td>        
    </tr>
</table>

## 3 Overview of available columns

<table>
    <tr>
		<th>
			Column name
		</th>
		<th>
			Explanation
		</th>
	</tr>
    <tr>
        <td>
            prod_number
        </td>
        <td>
            <b>Content:</b> The <b>variation ID</b> of the variation.
        </td>        
    </tr>
    <tr>
		<td>
			prod_name
		</td>
		<td>
			<b>Content:</b> According to the format setting <b>item name</b>.
		</td>        
	</tr>
	<tr>
		<td>
			prod_price
		</td>
		<td>
			<b>Content:</b> The <b>sales price</b> of the variation.
		</td>        
	</tr>
	<tr>
		<td>
			prod_price_old
		</td>
		<td>
			<b>Content:</b> If the <b>RRP</b> is activated in the format setting and is higher than the <b>sales price</b>, the <b>RRP</b> will be exported.
		</td>        
	</tr>
	<tr>
		<td>
			currency_symbol
		</td>
		<td>
			<b>Content:</b> The ISO3 <b>currency code</b> of the price.
		</td>        
	</tr>
	<tr>
		<td>
			prod_url
		</td>
		<td>
			<b>Content:</b> The <b>URL path</b> of the item, depending on the chosen <b>client</b> in the format settings.
		</td>        
	</tr>
    <tr>
		<td>
			category
		</td>
		<td>
			<b>Content:</b> The names of the categories that are linked to the variation separeted with >.
		</td>        
	</tr>
	<tr>
		<td>
			category_url
		</td>
		<td>
			<b>Content:</b> Empty
		</td>        
	</tr>
	<tr>
		<td>
			valid_from_date
		</td>
		<td>
			<b>Content:</b> Empty
		</td>        
	</tr>
	<tr>
		<td>
			valid_to_date
		</td>
		<td>
			<b>Content:</b> Empty
		</td>        
	</tr>
	<tr>
		<td>
			prod_description
		</td>
		<td>
			<b>Content:</b> According to the format setting <b>Preview text</b>.
		</td>        
	</tr>
	<tr>
		<td>
			prod_description_long
		</td>
		<td>
			<b>Content:</b> According to the format setting <b>Description</b>.
		</td>        
	</tr>
	<tr>
		<td>
			img_small
		</td>
		<td>
			<b>Content:</b> The preview image url. Variation images are prioritizied over item images.
		</td>        
	</tr>
	<tr>
		<td>
			img_medium
		</td>
		<td>
			<b>Content:</b> The middle image url. Variation images are prioritizied over item images.
		</td>        
	</tr>
	<tr>
		<td>
			img_large
		</td>
		<td>
			<b>Content:</b> The image url. Variation images are prioritizied over item images.
		</td>        
	</tr>
	<tr>
		<td>
			ean_code
		</td>
		<td>
			<b>Content:</b> According to the format setting <b>Barcode</b>.
		</td>        
	</tr>
	<tr>
		<td>
			versandkosten
		</td>
		<td>
			<b>Content:</b> According to the format setting <b>Shipping costs</b>.
		</td>        
	</tr>
	<tr>
		<td>
			lieferzeit
		</td>
		<td>
			<b>Content:</b>The <b>name of the item availability</b> under <b>Settings » Item » Item availability</b> or the translation according to the format setting <b>Item availability</b>.
		</td>        
	</tr>
	<tr>
		<td>
			platform
		</td>
		<td>
			<b>Content:</b> Empty
		</td>        
	</tr>
	 <tr>
		<td>
			grundpreis
		</td>
		<td>
			<b>Content:</b> The <b>base price information</b>. The format is "price / unit". (Example: 10,00 EUR / kilogram)
		</td>        
	</tr>
</table>

## License

This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-rakuten-de/blob/master/LICENSE.md).
