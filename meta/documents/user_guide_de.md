
# User Guide für das ElasticExportKuponaDE Plugin

<div class="container-toc"></div>

## 1 Bei Kupona.de registrieren

Kupona.de ist eine Agentur für Online Performance Marketing mit den Geschäftsfeldern Display Performance Advertising, Retargeting, Affiliate Marketing und Produktdatenmarketing.

## 2 Das Format KuponaDE-Plugin in plentymarkets einrichten

Um dieses Format nutzen zu können, benötigen Sie das Plugin Elastic Export.

Auf der Handbuchseite [Daten exportieren](https://www.plentymarkets.eu/handbuch/datenaustausch/daten-exportieren/#4) werden die einzelnen Formateinstellungen beschrieben.

In der folgenden Tabelle finden Sie Hinweise zu den Einstellungen, Formateinstellungen und empfohlenen Artikelfiltern für das Format **KuponaDE-Plugin**.
<table>
    <tr>
        <th>
            Einstellung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Einstellungen
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            <b>KuponaDE-Plugin</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Bereitstellung
        </td>
        <td>
            <b>URL</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Dateiname
        </td>
        <td>
            Der Dateiname muss auf <b>.csv</b> oder <b>.txt</b> enden, damit MyBestBrands.de die Datei erfolgreich importieren kann.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Artikelfilter
        </td>
    </tr>
    <tr>
        <td>
            Aktiv
        </td>
        <td>
            <b>Aktiv</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Märkte
        </td>
        <td>
            Eine oder mehrere Auftragsherkünfte wählen. Die gewählten Auftragsherkünfte müssen an der Variante aktiviert sein, damit der Artikel exportiert wird.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Formateinstellungen
        </td>
    </tr>
    <tr>
        <td>
            Auftragsherkunft
        </td>
        <td>
            Die Auftragsherkunft wählen, die beim Auftragsimport zugeordnet werden soll.
        </td>        
    </tr>
    <tr>
        <td>
            Angebotspreis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
    <tr>
        <td>
            MwSt.-Hinweis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
</table>


## 3 Übersicht der verfügbaren Spalten

<table>
    <tr>
        <th>
            Spaltenbezeichnung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td>
            prod_number
        </td>
        <td>
            <b>Inhalt:</b> Die <b>Varianten-ID</b> der Variante.
        </td>        
    </tr>
    <tr>
		<td>
			prod_name
		</td>
		<td>
			<b>Inhalt:</b> Entsprechend der Formateinstellung <b>Artikelname</b>.
		</td>        
	</tr>
	<tr>
		<td>
			prod_price
		</td>
		<td>
			<b>Ausgabe:</b> Hier steht der <b>Verkaufspreis</b>.
		</td>        
	</tr>
	<tr>
		<td>
			prod_price_old
		</td>
		<td>
			<b>Ausgabe:</b> Der <b>Verkaufspreis</b> der Variante. Wenn der <b>UVP</b> in den Formateinstellungen aktiviert wurde und höher ist als der Verkaufspreis, wird dieser hier eingetragen. 
		</td>        
	</tr>
	<tr>
		<td>
			currency_symbol
		</td>
		<td>
			<b>Ausgabe:</b> Der ISO3 <b>Währungscode</b> der Preise.
		</td>        
	</tr>
	<tr>
		<td>
			prod_url
		</td>
		<td>
			<b>Inhalt:</b> Der <b>URL-Pfad</b> des Artikels abhängig vom gewählten <b>Mandanten</b> in den Formateinstellungen.
		</td>        
	</tr>
    <tr>
		<td>
			category
		</td>
		<td>
			<b>Inhalt:</b> Die Namen der Kategorien getrennt durch >, die mit der Variante verknüpft sind.
		</td>        
	</tr>
	<tr>
		<td>
			category_url
		</td>
		<td>
			<b>Inhalt:</b> Leer.
		</td>        
	</tr>
	<tr>
		<td>
			valid_from_date
		</td>
		<td>
			<b>Inhalt:</b> Leer.
		</td>        
	</tr>
	<tr>
		<td>
			valid_to_date
		</td>
		<td>
			<b>Inhalt:</b> Leer.
		</td>        
	</tr>
	<tr>
		<td>
			prod_description
		</td>
		<td>
			<b>Inhalt:</b> Entsprechend der Formateinstellung <b>Vorschautext</b>.
		</td>        
	</tr>
	<tr>
		<td>
			prod_description_long
		</td>
		<td>
			<b>Inhalt:</b> Entsprechend der Formateinstellung <b>Beschreibung</b>.
		</td>        
	</tr>
	<tr>
		<td>
			img_small
		</td>
		<td>
			<b>Inhalt:</b> Preview-URL des Bildes. Variantenbilder werden vor Artikelbildern priorisiert.
		</td>        
	</tr>
	<tr>
		<td>
			img_medium
		</td>
		<td>
			<b>Inhalt:</b> Middle-URL des Bildes. Variantenbilder werden vor Artikelbildern priorisiert.
		</td>        
	</tr>
	<tr>
		<td>
			img_large
		</td>
		<td>
			<b>Inhalt:</b> URL des Bildes. Variantenbilder werden vor Artikelbildern priorisiert.
		</td>        
	</tr>
	<tr>
		<td>
			ean_code
		</td>
		<td>
			<b>Inhalt:</b> Entsprechend der Formateinstellung <b>Barcode</b>.
		</td>        
	</tr>
	<tr>
		<td>
			versandkosten
		</td>
		<td>
			<b>Inhalt:</b> Entsprechend der Formateinstellung <b>Versandkosten</b>.
		</td>        
	</tr>
	<tr>
		<td>
			lieferzeit
		</td>
		<td>
			<b>Inhalt:</b> Der <b>Name der Artikelverfügbarkeit</b> unter <b>Einstellungen » Artikel » Artikelverfügbarkeit</b> oder die Übersetzung gemäß der Formateinstellung <b>Artikelverfügbarkeit überschreiben</b>.
		</td>        
	</tr>
	<tr>
		<td>
			platform
		</td>
		<td>
			<b>Inhalt:</b> Leer.
		</td>        
	</tr>
	 <tr>
		<td>
			grundpreis
		</td>
		<td>
			<b>Inhalt:</b> Die <b>Grundpreisinformation</b> im Format "Preis / Einheit". (Beispiel: 10,00 EUR / Kilogramm)
		</td>        
	</tr>
</table>

## 4 Lizenz

Das gesamte Projekt unterliegt der GNU AFFERO GENERAL PUBLIC LICENSE – weitere Informationen finden Sie in der [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-rakuten-de/blob/master/LICENSE.md).
