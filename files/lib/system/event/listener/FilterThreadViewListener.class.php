<?php
/**
 * Copyright (c) 2013 Tobias Friebel
 *
 * Authors: Tobias Friebel <auftrag@tobyf.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung
 * http://creativecommons.org/licenses/by-nc-nd/3.0/de/
 */

require_once (WCF_DIR . 'lib/system/event/EventListener.class.php');

/**
 * Filter threadview for groups
 *
 * @author Toby
 * @package com.toby.wbb.filterguestview
 */
class FilterThreadViewListener implements EventListener
{
	/**
	 *
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		if (!MODULE_FILTER_CONTENT ||
			$eventObj->board->getPermission('canViewFilteredContent'))
			return;

		foreach ($eventObj->postList->posts as $id => $postObj)
		{
			// disable message cache, as we just want BBCodes...
			$eventObj->postList->posts[$id]->messageCache = '';
			$text = $postObj->message;

			$filtered =  FilterThreadViewListener :: filter($text);

			$eventObj->postList->posts[$id]->message = $filtered;
		}
	}

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

		if (MESSAGE_FILTER_THREAD_VIEW_CODE)
		{
			$filterRules[] = '[code]*[/code]';
			$filterRules[] = '[php]*[/php]';
			$filterRules[] = '[mysql]*[/mysql]';
		}

		if (MESSAGE_FILTER_THREAD_VIEW_QUOTES)
		{
			$filterRules[] = '[quote*[/quote]';
		}

		if (MESSAGE_FILTER_THREAD_VIEW_LINKS)
		{
			$filterRules[] = '[url*[/url]';
			$filterRules[] = '[email*[/email]';
		}

		if (MESSAGE_FILTER_THREAD_VIEW_IMAGES)
		{
			$filterRules[] = '[img]*[/img]';
		}

		if (MESSAGE_FILTER_THREAD_VIEW_OBJECTS)
		{
			$filterRules[] = '[youtube]*[/youtube]';
			$filterRules[] = '[myvideo]*[/myvideo]';
			$filterRules[] = '[myspace]*[/myspace]';
			$filterRules[] = '[googlevideo]*[/googlevideo]';
			$filterRules[] = '[clipfish]*[/clipfish]';
			$filterRules[] = '[sevenload]*[/sevenload]';
		}

		if (MESSAGE_FILTER_THREAD_VIEW_SHORTEN != -1)
		{
			$text = self :: truncate($text,
					MESSAGE_FILTER_THREAD_VIEW_SHORTEN);
		}

		$filterRulesOwn = explode("\n",
				preg_replace("/\r+/", '',
						MESSAGE_FILTER_THREAD_VIEW));
		$filterRules = $filterRules + ArrayUtil :: trim($filterRulesOwn);


		foreach ($filterRules as $filterRule)
		{
			$filterRule = preg_quote($filterRule, '/');
			$filterRule = str_replace('\*', '.*', $filterRule);
			$filterRule = '/' . $filterRule . '/isU';

			$text = preg_replace($filterRule,
					WCF :: getLanguage()->get(
							'wbb.thread.filterthreadmessage',
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
		$truncate .= ' ' . WCF :: getLanguage()->get('wbb.thread.filterthreadtruncatedmessage',
				array (
						'PAGE_URL' => PAGE_URL
				));

		return $truncate;
	}
}
