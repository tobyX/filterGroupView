<?php
/**
 * Copyright (c) 2013 Tobias Friebel
 * Authors: Tobias Friebel <auftrag@tobyf.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung
 * http://creativecommons.org/licenses/by-nc-nd/3.0/de/
 */
require_once (WCF_DIR . 'lib/system/event/EventListener.class.php');
require_once (WBB_DIR . 'lib/system/event/listener/FilterGroupViewListener.class.php');

class FilterThreadViewThreadsFeedListener implements EventListener
{
	/**
	 *
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		if (!MODULE_FILTER_CONTENT || !MODULE_FILTER_FEEDS)
			return;

		foreach ($eventObj->threads as $id => $threadObj)
		{
			if ($threadObj->post)
				$text = $threadObj->post->message;
			else
				continue;

			$filtered = FilterThreadViewListener :: filter($text);

			$eventObj->threads[$id]->post->message = $filtered;
		}
	}
}
