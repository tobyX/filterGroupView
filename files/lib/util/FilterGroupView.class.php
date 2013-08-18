<?php
/**
 * Copyright (c) 2013 Tobias Friebel
 *
 * Authors: Tobias Friebel <auftrag@tobyf.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung
 * http://creativecommons.org/licenses/by-nc-nd/3.0/de/
 */
class FilterGroupView
{
	/**
	 * filter given data for groups
	 *
	 * @param string $text message with bbcodes
	 *
	 * @return string	filtered content
	 */
	public static function filter($text)
	{
		$filterRules = array ();
		$filterRulesHtml = array ();

		if (MESSAGE_FILTER_GROUP_VIEW_CODE)
		{
			$filterRules[] = '[code]*[/code]';
			$filterRules[] = '[php]*[/php]';
			$filterRules[] = '[mysql]*[/mysql]';
		}

		if (MESSAGE_FILTER_GROUP_VIEW_QUOTES)
		{
			$filterRules[] = '[quote*[/quote]';
		}

		if (MESSAGE_FILTER_GROUP_VIEW_LINKS)
		{
			$filterRules[] = '[url*[/url]';
			$filterRules[] = '[email*[/email]';
		}

		if (MESSAGE_FILTER_GROUP_VIEW_IMAGES)
		{
			$filterRules[] = '[img]*[/img]';
		}

		if (MESSAGE_FILTER_GROUP_VIEW_OBJECTS)
		{
			$filterRules[] = '[youtube]*[/youtube]';
			$filterRules[] = '[myvideo]*[/myvideo]';
			$filterRules[] = '[myspace]*[/myspace]';
			$filterRules[] = '[googlevideo]*[/googlevideo]';
			$filterRules[] = '[clipfish]*[/clipfish]';
			$filterRules[] = '[sevenload]*[/sevenload]';
		}

		if (MESSAGE_FILTER_GROUP_VIEW_SHORTEN != -1)
		{
			$text = self :: truncate($text,
										MESSAGE_FILTER_GROUP_VIEW_SHORTEN);
		}

		$filterRulesOwn = explode("\n",
								preg_replace("/\r+/", '',
											MESSAGE_FILTER_GROUP_VIEW));
		$filterRules = $filterRules + ArrayUtil :: trim($filterRulesOwn);


		foreach ($filterRules as $filterRule)
		{
			$filterRule = preg_quote($filterRule, '/');
			$filterRule = str_replace('\*', '.*', $filterRule);
			$filterRule = '/' . $filterRule . '/isU';

			$text = preg_replace($filterRule,
								WCF :: getLanguage()->get(
														'wbb.thread.filtergroupmessage',
														array (
																'PAGE_URL' => PAGE_URL
														)), $text);
		}

		return $text;
	}

	/**
	 * truncate can truncate a string up to a number of characters while
	 * preserving whole words
	 *
	 * @param string $text String to truncate.
	 * @param integer $length Length of returned string, including ellipsis.
	 *
	 * @return string Trimmed string.
	 */
	protected static function truncate($text, $length = 100)
	{
		if (strlen($text) <= $length)
		{
			return $text;
		}
		else
		{
			$truncate = substr($text, 0, $length);
		}

		// ...search the last occurance of a space...
		$spacepos = strrpos($truncate, ' ');
		if (isset($spacepos))
		{
			// ...and cut the text in this position
			$truncate = substr($truncate, 0, $spacepos);
		}

		// add the defined ending to the text
		$truncate .= ' ' . WCF :: getLanguage()->get('wbb.thread.filtergrouptruncatedmessage',
												array (
													'PAGE_URL' => PAGE_URL
												));

		return $truncate;
	}
}
