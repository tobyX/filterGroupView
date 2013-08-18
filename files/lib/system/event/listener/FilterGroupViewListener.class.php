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
require_once (WBB_DIR . 'lib/util/FilterGroupView.class.php');

/**
 * Filter threadview for groups
 *
 * @author Toby
 * @package com.toby.wbb.filterguestview
 */
class FilterGroupViewListener implements EventListener
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

			$filtered = FilterGroupView :: filter($text);

			$eventObj->postList->posts[$id]->message = $filtered;
		}
	}
}
