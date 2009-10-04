<?php
/*
 * Copyright (c) 2009 Tobias Friebel
 * Authors: Tobias Friebel <TobyF@Web.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 *
 * $Id$
 */

require_once (WCF_DIR . 'lib/system/event/EventListener.class.php');

/**
 * Filter threadview for guests
 *
 * @author Toby
 * @package	com.toby.wbb.filterguestview
 */
class FilterGuestViewListener implements EventListener
{
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		if ((WCF :: getUser()->userID != 0 && !WCF :: getUser()->activationCode) || 
			!MESSAGE_FILTER_GUEST_VIEW_ENABLED || $eventObj->board->enableFilterGuestView == 0)
			return;

		$filterRules = explode("\n", preg_replace("/\r+/", '', MESSAGE_FILTER_GUEST_VIEW));
		$filterRules = ArrayUtil :: trim($filterRules);

		$c = count($eventObj->postList->posts);
		for ($i = 0; $i < $c; $i++)
		{
			$textCache = $eventObj->postList->posts[$i]->messageCache;
			$text = $eventObj->postList->posts[$i]->message;

			foreach ($filterRules as $filterRule)
			{
				$filterRule = preg_quote($filterRule, '/');
				$filterRule = str_replace('\*', '.*', $filterRule);
				$filterRule = '/'.$filterRule.'/isU';

				$textCache = preg_replace($filterRule, WCF::getLanguage()->get('wbb.thread.filterguestmessage.html', array('PAGE_URL' => PAGE_URL)) , $textCache);
				$text = preg_replace($filterRule, WCF::getLanguage()->get('wbb.thread.filterguestmessage', array('PAGE_URL' => PAGE_URL)) , $text);
			}

			$eventObj->postList->posts[$i]->messageCache = $textCache;
			$eventObj->postList->posts[$i]->message = $text;
		}
	}
}
?>