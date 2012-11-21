<?php

/**
 * Google Analytics code generation widget
 *
 * @copyright © Digitick <www.digitick.net> 2012
 * @license GNU Lesser General Public License v3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Lesser Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 * 
 */

/**
 * Google Analytics widget class.
 *
 * @author Ianaré Sévi
 */
class EGoogleAnalytics extends CApplicationComponent
{
	/**
	 * @var string The full web property ID (e.g. UA-65432-1) for the tracker object.
	 */
	public $account;

	/**
	 * @var boolean linker functionality flag as part of enabling cross-domain
	 * user tracking. 
	 */
	public $allowLinker = true;

	/**
	 * @var string the new cookie path for your site. By default, Google Analytics
	 * sets the cookie path to the root level (/).
	 */
	public $cookiePath;

	/**
	 * @var string the domain name for the GATC cookies. Values: 'auto', 'none', [domain].
	 * [domain] is a specific domain, i.e. 'example.com'.
	 * 'auto' by default.
	 */
	public $domainName = 'auto';

	/**
	 * @var array strings of ignored term(s) for Keywords reports.
	 * 
	 * array('keyword1', 'keyword2')
	 */
	public $ignoredOrganics = array();

	/**
	 * @var array Excludes a source as a referring site.
	 * 
	 * array('referrer1', 'referrer2')
	 */
	public $ignoredRefs = array();

	/**
	 * @var array Adds a search engine to be included as a potential search
	 * engine traffic source.
	 * 
	 * array('engine1' => 'keyword2', 'engine2' => 'keyword2')
	 */
	public $organics = array();

	/**
	 * @var boolean the browser tracking module flag.
	 */
	public $clientInfo = true;

	/**
	 *
	 * @var boolean the Flash detection flag.
	 */
	public $detectFlash = true;

	/**
	 *
	 * @var boolean the title detection flag.
	 */
	public $detectTitle = true;

	/**
	 * @var array items purchased, multidimensional.
	 * 
	 * array(
	 * 		array(
	 * 			'orderId' => '1234',
	 * 			'sku' => 'DD44',
	 * 			'name' => 'T-Shirt',
	 * 			'category' => 'Olive Medium',
	 * 			'price' => '11.99',
	 * 			'quantity' => '1'
	 * 		),
	 * )
	 */
	public $items = array();

	/**
	 * @var array commercial transactions, multidimensional.
	 * 
	 * array(
	 * 		array(
	 * 			'orderId' => '1234',
	 * 			'affiliation' => 'Womens Apparel',
	 * 			'total' => '28.28',
	 * 			'tax' => '1.29',
	 * 			'shipping' => '15.00',
	 * 			'city' => 'San Jose',
	 * 			'state' => 'California',
	 * 			'country' => 'USA'
	 * 		),
	 * )
	 */
	public $transactions = array();

	/**
	 * @var string CClientScript position. 
	 */
	public $position = CClientScript::POS_HEAD;

	public function run()
	{
		if (!$this->account)
			throw new CException('Google analytics account ID must be set.');

		$ignoredOrganics = '';
		foreach ($this->ignoredOrganics as $keyword) {
			$ignoredOrganics .= "_gaq.push(['_addIgnoredOrganic', '$keyword']);\n";
		}
		$ignoredRefs = '';
		foreach ($this->ignoredRefs as $referrer) {
			$ignoredRefs .= "_gaq.push(['_addIgnoredRef', '$referrer']);\n";
		}
		$organics = '';
		foreach ($this->organics as $engine => $keyword) {
			$organics .= "_gaq.push(['_addOrganic','$engine', '$keyword']);\n";
		}
		$items = '';
		foreach ($this->items as $item) {
			$items .= "_gaq.push(['_addItem', '{$item['orderId']}', '{$item['sku']}', '{$item['name']}', '{$item['category']}', '{$item['price']}', '{$item['quantity']}']);\n";
		}
		$transactions = '';
		foreach ($this->transactions as $trans) {
			$transactions .= "_gaq.push(['_addTrans', '{$trans['orderId']}', '{$trans['affiliation']}', '{$trans['total']}', '{$trans['tax']}', '{$trans['shipping']}', '{$trans['city']}', '{$trans['state']}', '{$trans['country']}']);\n";
		}
		$trackTrans = '';
		if (!empty($items) || !empty($transactions))
			$trackTrans = "_gaq.push(['_trackTrans']);\n";

		$script = "var _gaq = _gaq || [];\n";
		$script .= "_gaq.push(['_setAccount', '{$this->account}']);\n";
		$script .= $ignoredOrganics . $ignoredRefs . $organics;
		$script .= "_gaq.push(['_setDomainName', '{$this->domainName}']);\n";
		if ($this->cookiePath)
			$script .= "_gaq.push(['_setCookiePath', '{$this->cookiePath}']);\n";
		$script .= "_gaq.push(['_setAllowLinker', " . (($this->allowLinker) ? 'true' : 'false') . "]);\n";
		if (!$this->clientInfo)
			$script .= "_gaq.push(['_setClientInfo', false]);\n";
		if (!$this->detectFlash)
			$script .= "_gaq.push(['_setDetectFlash', false]);\n";
		if (!$this->detectTitle)
			$script .= "_gaq.push(['_setDetectTitle', false]);\n";
		$script .= "_gaq.push(['_trackPageview']);\n";
		$script .= $items . $transactions . $trackTrans;
		$script .= "(function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();";

		Yii::app()->getClientScript()->registerScript('google-analytics', $script, $this->position);
	}

}

