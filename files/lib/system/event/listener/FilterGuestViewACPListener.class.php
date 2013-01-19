<?php
/*
 * Copyright (c) 2009 Tobias Friebel
 * Authors: Tobias Friebel <TobyF@Web.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 *
 * $Id: LimitGuestViewACPListener.class.php 166 2009-05-17 14:53:56Z toby $
 */

require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

class FilterGuestViewACPListener implements EventListener
{
	private $enableFilterGuestView = 0;
	private $isSave = false;

	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		switch ($eventName)
		{
			case 'readFormParameters':
				if (isset($_POST['enableFilterGuestView'])) $this->enableFilterGuestView = abs(intval($_POST['enableFilterGuestView']));
			break;

			case 'save':
				$eventObj->additionalFields['enableFilterGuestView'] = $this->enableFilterGuestView;
				$this->isSave = true;
			break;

			case 'assignVariables':
				if (is_object($eventObj->board) && !$this->isSave)
				{
					WCF::getTPL()->assign(array(
						'enableFilterGuestView' => $eventObj->board->enableFilterGuestView,
					));
				}
				else
				{
					WCF::getTPL()->assign(array(
						'enableFilterGuestView' => $this->enableFilterGuestView,
					));
				}

				WCF::getTPL()->append('additionalSettings', WCF::getTPL()->fetch('filterGuestView'));
			break;
		}
	}
}
?>