<?php
class TmzoneComponent extends Component
{
    public function GetDateTime($timezoneid, $gmt_offset, $dst_offset, $timezone_code, $db_date, $type='datetime')
    {
        $dst = 1;
        if (!$timezoneid) {
            return date('Y-m-d H:i');
        }
        if ($db_date == '0000-00-00 00:00:00' || $db_date == '0000-00-00') {
            return $db_date;
        }
        if ($type == "revdate") {
            $exp = explode(" ", $db_date);
            $exp_d = explode("-", $exp[0]);
            $exp_t = explode(":", $exp[1]);
            
            if ($gmt_offset != 0) {
                $sign1 = substr($gmt_offset, 0, 1);
                $value = substr($gmt_offset, 1, -4);
                
                if ($this->isDaylightSaving($timezoneid, $gmt_offset)) {
                    $value = $value - $dst_offset;
                } else {
                    $value = $value + $dst_offset;
                }
                if ($sign1 == "+") {
                    return date("Y-m-d", mktime($exp_t[0]-$value, $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
                } elseif ($sign1 == "-") {
                    return date("Y-m-d", mktime($exp_t[0]-$value, $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
                } else {
                    return date("Y-m-d", mktime($exp_t[0]-$value, $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
                }
            } else {
                return date("Y-m-d", mktime($exp_t[0], $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
            }
        } else {
            if ($dst_offset > 0) {
                if (!($dst)) {
                    $dst_offset = 0;
                } elseif (!$this->isDaylightSaving($timezoneid, $gmt_offset)) {
                    $dst_offset = 0;
                }
            }
            $dst_offset *= 60;
            $gmt_offset *= 60;
            
            $exp = explode(" ", $db_date);
            $exp_d = explode("-", $exp[0]);
            $exp_t = explode(":", $exp[1]);
            
            $gmt_hour = $exp_t[0];
            $gmt_minute = $exp_t[1];
            $gmt_secs = $exp_t[2];
            
            
            
            $time = $gmt_hour * 60 + $gmt_minute + $gmt_offset + $dst_offset;
            if ($type == "datetime") {
                return date('Y-m-d H:i:s', @mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "date") {
                return date('Y-m-d', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "time") {
                return date('H-i-s', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "dateFormat") {
                return date('m/d/Y', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "header") {
                return date('l, F j Y h:i A', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "td") {
                return date('"G.i"', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "onlytime") {
                return date('H:i:s', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } else {
                return date('Y-m-d H:i:s', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            }
        }
    }
    public function isDaylightSaving($timezoneid, $gmt_offset)
    {
        $gmt_minute = gmdate("i");
        $gmt_hour = gmdate("H");
        $gmt_month = gmdate("m");
        $gmt_day = gmdate("d");
        $gmt_year = gmdate("Y");
        $cur_year = date("Y", mktime($gmt_hour + $gmt_offset, $gmt_minute, 0, $gmt_month, $gmt_day, $gmt_year));
    
        switch ($timezoneid) {
    /*	North American cases: begins at 2 am on the first Sunday in April
        and ends on the last Sunday in October.  Note: Monterrey does not
        actually observe DST */
            case 4:		/*	Alaska */
            case 5:		/*	Pacific Time (US & Canada); Tijuana */
            case 8:		/*	Mountain Time (US & Canada) */
            case 10:	/*	Central Time (US & Canada) */
            case 11:	/*	Guadalajara, Mexico City, Monterrey */
            case 14:	/*	Eastern Time (US & Canada) */
            case 16:	/*	Atlantic Time (Canada) */
            case 19:	/*	Newfoundland */
                if ($this->afterFirstDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
                $this->beforeLastDayInMonth($cur_year, $cur_year, 11, "Sun", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            case 7:		/*	Chihuahua, La Paz, Mazatlan */
                if ($this->afterFirstDayInMonth($cur_year, $cur_year, 5, "Sun", $gmt_offset) &&
                $this->beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            case 18:	/*	Santiago, Chile */
                if ($this->afterSecondDayInMonth($cur_year, $cur_year, 10, "Sat", $gmt_offset) &&
                $this->beforeSecondDayInMonth($cur_year + 1, $cur_year, 3, "Sat", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            case 20:	/*	Brasilia, Brazil */
                if ($this->afterFirstDayInMonth($cur_year, $cur_year, 11, "Sun", $gmt_offset) &&
                $this->beforeThirdDayInMonth($cur_year, $cur_year, 2, "Sun", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            case 23:	/*	Mid-Atlantic */
                if ($this->afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
                $this->beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
    /*	EU, Russia, other cases: begins at 1 am GMT on the last Sunday
        in March and ends on the last Sunday in October */
            case 22:	/*	Greenland */
            case 24:	/*	Azores */
            case 27:	/*	Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London */
            case 28:	/*	Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna */
            case 29:	/*	Belgrade, Bratislava, Budapest, Ljubljana, Prague */
            case 30:	/*	Brussels, Copenhagen, Madrid, Paris */
            case 31:	/*	Sarajevo, Skopje, Warsaw, Zagreb */
            case 33:	/*	Athens, Istanbul, Minsk */
            case 34:	/*	Bucharest */
            case 37:	/*	Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius */
            case 41:	/*	Moscow, St. Petersburg, Volgograd */
            case 47:	/*	Ekaterinburg */
            case 45:	/*	Baku, Tbilisi, Yerevan */
            case 51:	/*	Almaty, Novosibirsk */
            case 56:	/*	Krasnoyarsk */
            case 58:	/*	Irkutsk, Ulaan Bataar */
            case 64:	/*	Yakutsk, Sibiria */
            case 71:	/*	Vladivostok */
                if ($this->afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
                $this->beforeLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            case 35:	/*	Cairo, Egypt */
                if ($this->afterLastDayInMonth($cur_year, $cur_year, 4, "Fri", $gmt_offset) &&
                $this->beforeLastDayInMonth($cur_year, $cur_year, 9, "Thu", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            case 39:	/*	Baghdad, Iraq */
                if ($this->afterFirstOfTheMonth($cur_year, $cur_year, 4, $gmt_offset) &&
                $this->beforeFirstOfTheMonth($cur_year, $cur_year, 10, $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            case 43:	/*	Tehran, Iran - Note: This is an approximation to
                            the actual DST dates since Iran goes by the Persian
                            calendar.  There are tools for converting between
                            Gregorian and Persian calendars at www.farsiweb.info.
                            This may be added at a later date for better accuracy */
                if ($this->afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
                $this->beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            case 65:	/*	Adelaide */
            case 68:	/*	Canberra, Melbourne, Sydney */
                if ($this->afterLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
                $this->beforeLastDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            case 70:	/*	Hobart */
                if ($this->afterFirstDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
                $this->beforeLastDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            case 73:	/*	Auckland, Wellington */
                if ($this->afterFirstDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
                $this->beforeThirdDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset)) {
                    return true;
                } else {
                    return false;
                }
                break;
    
            default:
                break;
        }
        return false;
    }
    
    /*	This function returns true if the current date (at the specified GMT
    offset) is after the first specified day of the week in specified
    month and false if it is not */
    
    public function afterFirstDayInMonth($curYear, $year, $month, $day, $gmt_offset)
    {
        for ($i = 1; $i < 8; $i++) {
            if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {
                $first_day = $i;
                break;
            }
        }
        
        $curDay = gmdate("d");
        $curMonth = gmdate("m");
        $curHour = gmdate("H") + $gmt_offset;
        /* The current time stamp */
        $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);
    
        /* Time stamp for the first occurence for the specified day in the month */
        $first_day_stamp = mktime(2, 0, 0, $month, $first_day, $year);
                
        if ($cur_stamp >= $first_day_stamp) {
            return true;
        }
            
        return false;
    }
    
    /*	This function returns true if the current date (at the specified GMT
    offset) is before the last specified day of the week in specified
    month and false if it is not */
    
    public function beforeLastDayInMonth($curYear, $year, $month, $day, $gmt_offset)
    {
        $days_in_month = $this->getDaysInMonth($month);
        
        for ($i = $days_in_month; $i > ($days_in_month - 8); $i--) {
            if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {
                $last_day = $i;
                break;
            }
        }
        
        $curDay = gmdate("d");
        $curMonth = gmdate("m");
        $curHour = gmdate("H") + $gmt_offset;
        /* The current time stamp */
        $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);
    
        /* Time stamp for the last occurrence of the day in the month at 2 am */
        $last_sun_stamp = mktime(2, 0, 0, $month, $last_day, $year);
                
        if ($cur_stamp < $last_sun_stamp) {
            return true;
        }
            
        return false;
    }
    
    /*	This function returns true if the current date (at the specified GMT
    offset) is after the last specified day of the week in specified
    month and false if it is not */
    
    public function afterLastDayInMonth($curYear, $year, $month, $day, $gmt_offset)
    {
        $days_in_month = $this->getDaysInMonth($month);
    
        for ($i = $days_in_month; $i > ($days_in_month - 8); $i--) {
            if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {
                $last_day = $i;
                break;
            }
        }
        
        $curDay = gmdate("d");
        $curMonth = gmdate("m");
        /* All EU countries observe the DST change at 1 am GMT */
        $curHour = gmdate("H");
        /* The current time stamp */
        $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);
    
        /* Time stamp for the first occurence for the specified day in the month */
        $last_day_stamp = mktime(1, 0, 0, $month, $last_day, $year);
                
        if ($cur_stamp >= $last_day_stamp) {
            return true;
        }
            
        return false;
    }
    
    /*	This function returns true if the current date (at the specified GMT
    offset) is after the first day of the specified month and false if
    it is not */
    
    public function afterFirstOfTheMonth($curYear, $year, $month, $gmt_offset)
    {
        $curDay = gmdate("d");
        $curMonth = gmdate("m");
        $curHour = gmdate("H") + $gmt_offset;
        /* The current time stamp */
        $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);
    
        /* Time stamp for the first of the month */
        $last_day_stamp = mktime(3, 0, 0, $month, 1, $year);
                
        if ($cur_stamp >= $last_day_stamp) {
            return true;
        }
            
        return false;
    }
    
    /*	This function returns true if the current date (at the specified GMT
    offset) is before the first day of the specified month and false if
    it is not */
    
    public function beforeFirstOfTheMonth($curYear, $year, $month, $gmt_offset)
    {
        $curDay = gmdate("d");
        $curMonth = gmdate("m");
        $curHour = gmdate("H") + $gmt_offset;
        /* The current time stamp */
        $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);
    
        /* Time stamp for the first of the month */
        $first_day_stamp = mktime(3, 0, 0, $month, 1, $year);
                
        if ($cur_stamp < $first_day_stamp) {
            return true;
        }
            
        return false;
    }
    
    /*	This function returns true if the current date (at the specified GMT
    offset) is before the third occurrence of the specified day of the
    week in the specified month and false if it is not */
    
    public function beforeThirdDayInMonth($curYear, $year, $month, $day, $gmt_offset)
    {
        $count = 0;
        
        for ($i = 1; $i < 22; $i++) {
            if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {
                $count++;
                if ($count == 3) {
                    $third_day = $i;
                    break;
                }
            }
        }
        
        $curDay = gmdate("d");
        $curMonth = gmdate("m");
        $curHour = gmdate("H") + $gmt_offset;
        /* The current time stamp */
        $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);
    
        /* Time stamp for the third occurence for the specified day in the month */
        $third_day_stamp = mktime(2, 0, 0, $month, $third_day, $year);
                
        if ($cur_stamp < $third_day_stamp) {
            return true;
        }
            
        return false;
    }
    
    /*	This function returns true if the current date (at the specified GMT
    offset) is before the second occurrence of the specified day of the
    week in the specified month and false if it is not */
    
    public function beforeSecondDayInMonth($curYear, $year, $month, $day, $gmt_offset)
    {
        $count = 0;
        
        for ($i = 1; $i < 15; $i++) {
            if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {
                $count++;
                if ($count == 2) {
                    $second_day = $i;
                    break;
                }
            }
        }
        
        $curDay = gmdate("d");
        $curMonth = gmdate("m");
        $curHour = gmdate("H") + $gmt_offset;
        /* The current time stamp */
        $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);
    
        /*	Time stamp for the second occurence of the specified day in the month;
            change in Chile occurs at midnight */
        $second_day_stamp = mktime(0, 0, 0, $month, $second_day, $year);
    
        if ($cur_stamp < $second_day_stamp) {
            return true;
        }
            
        return false;
    }
    
    /*	This function returns true if the current date (at the specified GMT
    offset) is after the second occurrence of the specified day of the
    week in the specified month and false if it is not */
    
    public function afterSecondDayInMonth($curYear, $year, $month, $day, $gmt_offset)
    {
        $count = 0;
        
        for ($i = 1; $i < 15; $i++) {
            if (date("D", mktime(0, 0, 0, $month, $i)) == $day) {
                $count++;
                if ($count == 2) {
                    $second_day = $i;
                    break;
                }
            }
        }
        
        $curDay = gmdate("d");
        $curMonth = gmdate("m");
        $curHour = gmdate("H") + $gmt_offset;
        /* The current time stamp */
        $cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);
    
        /*	Time stamp for the second occurence of the specified day in the month;
            change in Chile occurs at midnight */
        $second_day_stamp = mktime(0, 0, 0, $month, $second_day, $year);
    
        if ($cur_stamp >= $second_day_stamp) {
            return true;
        }
            
        return false;
    }
    
    /*	A function that returns the number of days in the specified month */
    
    public function getDaysInMonth($month)
    {
        switch ($month) {
        /*	The February case, check for leap year */
            case 2:
                return (date("L")?29:28);
                break;
        /* Months with 31 days */
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                return 31;
                break;
            default:
                return 30;
                break;
        }
    }
        
    /*this function is used to convert user time to utc*/
    public function convert_to_utc($timezoneid, $gmt_offset, $dst_offset, $timezone_code, $db_date, $type='datetime')
    {
        $dst = 1;
        if (!$timezoneid) {
            return date('Y-m-d H:i');
        }
        if ($dst_offset > 0) {
            if (!($dst)) {
                $dst_offset = 0;
            } elseif (!$this->isDaylightSaving($timezoneid, $gmt_offset)) {
                $dst_offset = 0;
            }
        }
        $dst_offset *= 60;
        $gmt_offset *= 60;
            
        $exp = explode(" ", $db_date);
        $exp_d = explode("-", $exp[0]);
        $exp_t = explode(":", $exp[1]);
            
        $gmt_hour = $exp_t[0];
        $gmt_minute = $exp_t[1];
        $gmt_secs = $exp_t[2];
            
            
            
        $time = $gmt_hour * 60 + $gmt_minute - ($gmt_offset + $dst_offset);
        if ($type == "datetime") {
            return date('Y-m-d H:i:s', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
        } elseif ($type == "date") {
            return date('Y-m-d', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
        } elseif ($type == "time") {
            return date('H-i-s', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
        } elseif ($type == "dateFormat") {
            return date('m/d/Y', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
        } elseif ($type == "header") {
            return date('l, F j Y h:i A', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
        } elseif ($type == "td") {
            return date('"G.i"', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
        } else {
            return date('Y-m-d H:i:s', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
        }
    }
        
    public function convert12hourformat($time)
    {
        $time = explode(':', $time);
        $pm = false;
        if ($time[0] > 12) {
            $time[0] = $time[0]-12;
            $pm = true;
        } elseif ($time[0] == 12) {
            $pm = true;
        }
        if ($pm) {
            return $time[0].':'.$time[1].'pm';
        } else {
            return $time[0].':'.$time[1].'am';
        }
    }
    public function getGmtTz($gmt_offset, $dst_offset)
    {
        if ($dst_offset > 0) {
            if (!$this->isDaylightSaving($timezoneid, $gmt_offset)) {
                $dst_offset = 0;
            }
        }
        $fnl_tm = $gmt_offset + $dst_offset;
        if (stristr($fnl_tm, ".")) {
            $fnl_tm_t = explode('.', $fnl_tm);
            $fnl_tm_t[1] = '0.'.$fnl_tm_t[1];
            $fnl_tm = str_pad($fnl_tm_t[0], 2, '0', STR_PAD_LEFT).':'.str_pad(($fnl_tm_t[1]*60), 2, '0', STR_PAD_LEFT);
        } else {
            if ($fnl_tm < 0) {
                $fnl_tm_t = substr($fnl_tm, 1);
                $fnl_tm = str_pad($fnl_tm_t, 2, '0', STR_PAD_LEFT).':00';
                $fnl_tm = '-'.$fnl_tm;
            } else {
                $fnl_tm = str_pad($fnl_tm, 2, '0', STR_PAD_LEFT).':00';
            }
        }
        return (stristr($fnl_tm, '-'))?$fnl_tm:'+'.$fnl_tm;
    }
    public function dateFormatReverse_helper($output_date)
    {
        if ($output_date != "") {
            if (strstr($output_date, " ")) {
                $exp = explode(" ", $output_date);
                $od = $exp[0];
            } else {
                $od = $output_date;
            }
            $date_ex2 = explode("-", $od);
            $dateformated_input = $date_ex2[1] . "/" . $date_ex2[2] . "/" . $date_ex2[0];
            if ($date_ex2[2] != "00") {
                return $dateformated_input;
            }
        }
    }

    public function dateFormatOutputdateTime_day_helper($date_time, $curdate = null, $type = null, $is_month_last = 0, $viewtype = '')
    {
        $tm_format = (SES_TIME_FORMAT ==12)?'g:i a':'H:i';
        if ($date_time != "") {
            $date_time = date("Y-m-d H:i:s", strtotime($date_time));
            $output = explode(" ", $date_time);
            $date_ex2 = explode("-", $output[0]);

            $dateformated = $date_ex2[1] . "/" . $date_ex2[2] . "/" . $date_ex2[0];
            if ($date_ex2[2] != "00") {
                $displayWeek = 0;
                $timeformat = date($tm_format, strtotime($date_time));

                $week1 = date("l", mktime(0, 0, 0, $date_ex2[1], $date_ex2[2], $date_ex2[0]));
                $week_sub1 = substr($week1, "0", "3");

                $yesterday = date("Y-m-d", strtotime($curdate . "-1 days"));

                if ($dateformated == $this->dateFormatReverse_helper($curdate)) {
                    $dateTime_Format = __("Today", true);
                } elseif ($dateformated == $this->dateFormatReverse_helper($yesterday)) {
                    $dateTime_Format = "Y'day";
                } else {
                    $CurYr = date("Y", strtotime($curdate));
                    $DateYr = date("Y", strtotime($dateformated));
                    if ($viewtype == 'kanban') {
                        $dateformated = date("m/d", strtotime($dateformated));
                    } elseif ($CurYr == $DateYr) {
                        $dateformated = date("M d", strtotime($dateformated));
                        $dtformated = date("M d", strtotime($dateformated)) . ", " . date("D", strtotime($dateformated));
                        $displayWeek = 1;
                    } else {
                        $dateformated = date("M d, Y", strtotime($dateformated));
                        $dtformated = date("M d, Y", strtotime($dateformated));
                    }
                    $dateTime_Format = $dateformated;
                }
                if ($type == 'date') {
                    return $dateTime_Format;
                } elseif ($type == 'time') {
                    return $dateTime_Format . " " . $timeformat;
                } elseif ($type == 'week') {
                    if ($dateTime_Format == "Today" || $dateTime_Format == "Y'day" || !$displayWeek) {
                        return $dateTime_Format;
                    } else {
                        //return $dateTime_Format.", ".date("D",strtotime($dateformated));
                        return $dtformated;
                        //return $dateTime_Format;
                    }
                } else {
                    if ($dateTime_Format == "Today" || $dateTime_Format == "Y'day") {
                        if ($is_month_last) {
                            return $dateTime_Format;
                        } else {
                            return $dateTime_Format . " " . $timeformat;
                        }
                    } else {
                        if ($is_month_last) {
                            return date("D", strtotime($dateformated)) . ", " . $dateTime_Format;
                        } elseif ($viewtype == 'kanban') {
                            return $dateTime_Format . ", " . " " . $timeformat;
                        } else {
                            //return $dateTime_Format.", ".date("D",strtotime($dateformated))." ".$timeformat;
                            return $dtformated . " " . $timeformat;
                        }
                    }
                }
            }
        }
    }
}
