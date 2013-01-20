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
require_once (WBB_DIR . 'lib/util/FilterGuestView.class.php');

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

		foreach ($eventObj->postList->posts as $id => $postObj)
		{
			$textCache = $postObj->messageCache;
			$text = $postObj->message;

			$filtered = FilterGuestView :: filter($text, $textCache);

			$eventObj->postList->posts[$id]->message = $filtered[0];
			$eventObj->postList->posts[$id]->messageCache = $filtered[1];
		}
	}
}
