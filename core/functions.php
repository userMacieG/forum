<?php
	function alert($type, $text) {
		echo "<div class='alert alert-{$type}' role='alert'>{$text}</div>";
	}

	function statistics($database, $table) {
		$table_query = $database->prepare("SELECT * FROM {$table};");
		$table_query->execute();
		$result = $table_query->rowCount();
		return $result;
	}

	function forum_statistics($database, $table, $forum_id, $category_id) {
		$table_query = $database->prepare("SELECT * FROM {$table} WHERE forum_id = ? AND category_id = ?;");
		$table_query->execute(array($forum_id, $category_id));
		$result = $table_query->rowCount();
		return $result;
	}

	# Credits: Michael2318
	# Source: http://forum.php.pl/funkcja_data_przyjazna_uzytkownikom_t212265.html
	function formatDate($date) {
		$timestamp = strtotime($date);

		$lang['minute_ago'] = 'Minutę temu';
		$lang['minutes_ago_2_4'] = '%s minuty temu';
		$lang['minutes_ago_5_59'] = '%s minut temu';
		$lang['today'] = 'Dzisiaj, %s';
		$lang['yesterday'] = 'Wczoraj, %s';
		$lang['mon'] = 'Poniedziałek, %s';
		$lang['tue'] = 'Wtorek, %s';
		$lang['wed'] = 'Środa, %s';
		$lang['thu'] = 'Czwartek, %s';
		$lang['fri'] = 'Piątek, %s';
		$lang['sat'] = 'Sobota, %s';
		$lang['sun'] = 'Niedziela, %s';
		$lang['for_minute'] = 'Za minutę';
		$lang['for_minutes_2_4'] = 'Za %s minuty';
		$lang['for_minutes_5_59'] = 'Za %s minut';
		$lang['tomorow'] = 'Jutro, %s';
	   	$lang['now'] = 'Teraz';

		$timestamp = intval($timestamp);
		$now = time();
		$day_time = floor($timestamp/86400);
		$timedate = date("H:i", $timestamp);
		$day_now = floor($now/86400);
		$same_day = ($day_time == $day_now) ? TRUE : FALSE;

		if ($timestamp < 1) {
			return FALSE;
		}

		$past_or_future = ($now > $timestamp) ? TRUE : FALSE;
		if ($now == $timestamp) {
			return $lang['now'];
		} else if ($past_or_future) {
			$maths = $now - $timestamp;
			$day_before = $day_now-$day_time;

			if ($same_day && $maths <= 60) {
				return $lang['minute_ago'];
			} else if ($same_day && $maths > 60 && $maths <= 240) {
				$ret = ceil($maths / 60);
				return sprintf($lang['minutes_ago_2_4'], $ret);
			} else if ($same_day && $maths > 240 && $maths <= 3540) {
				$ret = ceil($maths / 60);
				if (substr($ret, 0, 1) > 1 && substr($ret, 1, 1) > 1 && substr($ret, 1, 1) < 5) {
					return sprintf($lang['minutes_ago_2_4'], $ret);
				} else {
					return sprintf($lang['minutes_ago_5_59'], $ret);
				}
			} else if ($same_day && $maths > 3540) {
				return sprintf($lang['today'], $timedate);
			} else if (!$same_day && $day_before == 1) {
				return sprintf($lang['yesterday'], $timedate);
			} else if (!$same_day && $day_before > 1 && $day_before < 7) {
				if ($day_before == 2) {
					return sprintf($lang[strtolower(date("D", ($now-172800)))], $timedate);
				} else if ($day_before == 3) {
					return sprintf($lang[strtolower(date("D", ($now-259200)))], $timedate);
				} else if ($day_before == 4) {
					return sprintf($lang[strtolower(date("D", ($now-345600)))], $timedate);
				} else if ($day_before == 5) {
					return sprintf($lang[strtolower(date("D", ($now-432000)))], $timedate);
				} else if ($day_before == 6) {
					return sprintf($lang[strtolower(date("D", ($now-518400)))], $timedate);
				}
			} else {
				return date("Y-m-d, H:i", $timestamp);
			}
		} else {
			$maths = $timestamp - $now;
			$day_after = $day_time-$day_now;

			if ($same_day && $maths <= 60) {
				return $lang['for_minute'];
			} else if ($same_day && $maths > 60 && $maths <= 240) {
				$ret = ceil($maths/60);
				return sprintf($lang['for_minutes_2_4'], $ret);
			} else if ($same_day && $maths > 240 && $maths <= 3540) {
				$ret = ceil($maths/60);
				if (substr($ret, 0, 1) > 1 && substr($ret, 1, 1) > 1 && substr($ret, 1, 1) < 5) {
					return sprintf($lang['for_minutes_2_4'], $ret);
				} else {
					return sprintf($lang['for_minutes_5_59'], $ret);
				}
			} else if ($same_day && $maths > 3540) {
				return sprintf($lang['today'], $timedate);
			} else if (!$same_day && $day_after == 1) {
				return sprintf($lang['tomorow'], $timedate);
			} else if (!$same_day && $day_after > 1 && $day_after < 7) {
				if ($day_after == 2) {
					return sprintf($lang[strtolower(date("D", ($now+172800)))], $timedate);
				} else if ($day_after == 3) {
					return sprintf($lang[strtolower(date("D", ($now+259200)))], $timedate);
				} else if ($day_after == 4) {
					return sprintf($lang[strtolower(date("D", ($now+345600)))], $timedate);
				} else if ($day_after == 5) {
					return sprintf($lang[strtolower(date("D", ($now+432000)))], $timedate);
				} else if ($day_after == 6) {
					return sprintf($lang[strtolower(date("D", ($now+518400)))], $timedate);
				}
			} else {
				return date("Y-m-d, H:i", $timestamp);
			}
		}
	}
?>
