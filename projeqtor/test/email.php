<?php

$to = 'pascal.bernard.muret@free.fr';
$subject = "Millennium Falcon";

$organizer          = 'Darth Vader';
$organizer_email    = 'darthvader@arturito.net';

$participant_name_1 = 'Boushh';
$participant_email_1= 'boushh@arturito.net';

$participant_name_2 = 'Boba Fett';
$participant_email_2= 'bobafett@arturito.net';

$location           = "Stardestroyer-013";
$date               = '20131026';
$startTime          = '0800';
$endTime            = '0900';
$subject            = 'Millennium Falcon';
$desc               = 'The purpose of the meeting is to discuss the capture of Millennium Falcon and its crew.';

$headers = 'Content-Type:text/calendar; Content-Disposition: inline; charset=utf-8;\r\n';
$headers .= "Content-Type: text/plain;charset=\"utf-8\"\r\n"; #EDIT: TYPO

$message = "BEGIN:VCALENDAR\r\n
    VERSION:2.0\r\n
    PRODID:-//Deathstar-mailer//theforce/NONSGML v1.0//EN\r\n
    METHOD:REQUEST\r\n
    BEGIN:VEVENT\r\n
    UID:" . md5(uniqid(mt_rand(), true)) . "example.com\r\n
    DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z\r\n
    DTSTART:".$date."T".$startTime."00Z\r\n
    DTEND:".$date."T".$endTime."00Z\r\n
    SUMMARY:".$subject."\r\n
    ORGANIZER;CN=".$organizer.":mailto:".$organizer_email."\r\n
    LOCATION:".$location."\r\n
    DESCRIPTION:".$desc."\r\n
    ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN".$participant_name_1.";X-NUM-GUESTS=0:MAILTO:".$participant_email_1."\r\n
    ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN".$participant_name_2.";X-NUM-GUESTS=0:MAILTO:".$participant_email_2."\r\n
    END:VEVENT\r\n
    END:VCALENDAR\r\n";

$headers .= $message;
$res = mail($to, $subject, $message, $headers);
echo "mail envoyé ? result = $res";
?>