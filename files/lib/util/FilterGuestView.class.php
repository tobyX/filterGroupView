<?php
/*
 * Copyright (c) 2013 Tobias Friebel
 * Authors: Tobias Friebel <TobyF@Web.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 *
 */

class FilterGuestView
{
	/**
	 * filter given data for guests
	 *
	 * @param string $text 			message with bbcodes
	 * @param string $textCache 	message already formatted in html
	 *
	 * @return array(text, $textCache)	array with first value text and second html
	 */
	public static function filter($text, $textCache = '')
	{
		$filterRules = array();
		$filterRulesHtml = array();

		if (MESSAGE_FILTER_GUEST_VIEW_CODE)
		{
			$filterRules[] = '[code]*[/code]';
			$filterRules[] = '[php]*[/php]';
			$filterRules[] = '[mysql]*[/mysql]';

			$filterRulesHtml[] = '<div class="*codeBox">*<div>*<table>*</table>*</div>*</div>';
		}

		if (MESSAGE_FILTER_GUEST_VIEW_QUOTES)
		{
			$filterRules[] = '[quote*[/quote]';

			$filterRulesHtml[] = '<blockquote class="quoteBox">*</blockquote>';
		}

		if (MESSAGE_FILTER_GUEST_VIEW_LINKS)
		{
			$filterRules[] = '[url*[/url]';
			$filterRules[] = '[email*[/email]';

			$filterRulesHtml[] = '<a*</a>';
		}

		if (MESSAGE_FILTER_GUEST_VIEW_IMAGES)
		{
			$filterRules[] = '[img]*[/img]';


			$filterRulesHtml[] = '<img*>';
		}

		if (MESSAGE_FILTER_GUEST_VIEW_OBJECTS)
		{
			$filterRules[] = '[youtube]*[/youtube]';
			$filterRules[] = '[myvideo]*[/myvideo]';
			$filterRules[] = '[myspace]*[/myspace]';
			$filterRules[] = '[googlevideo]*[/googlevideo]';
			$filterRules[] = '[clipfish]*[/clipfish]';
			$filterRules[] = '[sevenload]*[/sevenload]';

			$filterRulesHtml[] = '<object*</object>';
		}

		$filterRulesOwn = explode("\n", preg_replace("/\r+/", '', MESSAGE_FILTER_GUEST_VIEW));
		$filterRules = $filterRules + ArrayUtil :: trim($filterRulesOwn);

		$filterRulesOwn = explode("\n", preg_replace("/\r+/", '', MESSAGE_FILTER_GUEST_VIEW_HTML));
		$filterRulesHtml = $filterRulesHtml + ArrayUtil :: trim($filterRulesOwn);

		foreach ($filterRules as $filterRule)
		{
			$filterRule = preg_quote($filterRule, '/');
			$filterRule = str_replace('\*', '.*', $filterRule);
			$filterRule = '/'.$filterRule.'/isU';

			$text = preg_replace($filterRule,
				WCF::getLanguage()->get('wbb.thread.filterguestmessage', array('PAGE_URL' => PAGE_URL)) , $text);
		}

		if (!empty($textCache))
		{
			foreach ($filterRulesHtml as $filterRule)
			{
				$filterRule = preg_quote($filterRule, '/');
				$filterRule = str_replace('\*', '.*', $filterRule);
				$filterRule = '/'.$filterRule.'/isU';

				$textCache = preg_replace($filterRule,
					WCF::getLanguage()->get('wbb.thread.filterguestmessage.html', array('PAGE_URL' => PAGE_URL)) , $textCache);
			}
		}

		return array($text, $textCache);
	}
}
