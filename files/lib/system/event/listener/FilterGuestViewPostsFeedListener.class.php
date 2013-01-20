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
class FilterGuestViewPostsFeedListener implements EventListener
{
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		if ((WCF :: getUser()->userID != 0 && !WCF :: getUser()->activationCode) || !MESSAGE_FILTER_GUEST_VIEW_ENABLED)
			return;

		$c = count($eventObj->posts);
		for ($i = 0; $i < $c; $i++)
		{
			$text = $eventObj->posts[$i]->message;

			$filtered = FilterGuestView :: filter($text);

			$eventObj->posts[$i]->message = $filtered[0];
		}
	}
}
